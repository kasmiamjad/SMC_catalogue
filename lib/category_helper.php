<?php

/**
 * Normalize a category name for comparison.
 * - trim
 * - replace unicode dashes with ASCII hyphen "-"
 * - normalize whitespace around "/" to single space each side ("a / b")
 * - collapse multiple internal spaces to single space
 * - lowercase
 */
function normalize_category_name(string $name): string {
    $name = trim($name);
    
    // Replace unicode dashes (–, —, −, ‐, ‑) with ASCII hyphen "-"
    $unicode_dashes = ['–', '—', '−', '‐', '‑'];
    $name = str_replace($unicode_dashes, '-', $name);
    
    // Normalize whitespace around "/"
    $name = preg_replace('/\s*\/\s*/', ' / ', $name);
    
    // Collapse multiple internal spaces
    $name = preg_replace('/\s+/', ' ', $name);
    
    return strtolower($name);
}

/**
 * Load the category mapping configuration.
 * Caches the result in a static variable.
 */
function load_category_config(): array {
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../config/category_mapping.php';
    }
    return $config;
}

/**
 * Get the ordered list of parent names.
 */
function get_parents(): array {
    $config = load_category_config();
    return $config['parents'] ?? [];
}

/**
 * Get the parent category for a given child name.
 */
function get_parent_for(string $child_name): ?string {
    static $lookup_table = null;
    if ($lookup_table === null) {
        $config = load_category_config();
        $lookup_table = [];
        foreach ($config['mappings'] as $child => $parent) {
            $lookup_table[normalize_category_name($child)] = $parent;
        }
    }
    
    $normalized_input = normalize_category_name($child_name);
    return $lookup_table[$normalized_input] ?? null;
}

/**
 * Get the subset of unique categories that map to a specific parent.
 */
function get_children_of(string $parent_name, array $all_unique_categories): array {
    $children = [];
    foreach ($all_unique_categories as $category) {
        if (get_parent_for($category) === $parent_name) {
            $children[] = $category;
        }
    }
    return $children;
}

/**
 * Get the list of pinned parents that must always stay at the top.
 */
function get_pinned_parents(): array {
    return [
        'ALL',
        'FF&E - Furniture, Fixtures & Equipment',
        'OS&E - Operating Supplies & Equipment',
    ];
}

/**
 * Get the grouped menu structure.
 */
function get_grouped_menu(array $all_unique_categories, bool $is_admin = false): array {
    $all_parents = get_parents();
    $pinned_names = get_pinned_parents();
    
    // 1. Identify which parents actually have children present in this data set
    $active_groups = [];
    $mapped_children_names = [];
    
    foreach ($all_parents as $parent) {
        $children = get_children_of($parent, $all_unique_categories);
        if (!empty($children)) {
            // Sort children A-Z (case-insensitive)
            usort($children, 'strcasecmp');
            
            $active_groups[$parent] = [
                'parent' => $parent,
                'children' => $children
            ];
            foreach ($children as $child) {
                $mapped_children_names[] = normalize_category_name($child);
            }
        }
    }
    
    // 2. Separate into pinned and non-pinned
    $pinned_menu = [];
    
    // Process pinned first (in the order of get_pinned_parents)
    foreach ($pinned_names as $p_name) {
        if (isset($active_groups[$p_name])) {
            $pinned_menu[] = $active_groups[$p_name];
            unset($active_groups[$p_name]);
        }
    }
    
    // Remaining active groups are non-pinned
    $non_pinned_names = array_keys($active_groups);
    natcasesort($non_pinned_names); // Alphabetical A-Z
    
    $sorted_non_pinned = [];
    foreach ($non_pinned_names as $p_name) {
        $sorted_non_pinned[] = $active_groups[$p_name];
    }
    
    // 3. Assemble final menu
    $menu = array_merge($pinned_menu, $sorted_non_pinned);
    
    // 4. Handle Unassigned for admins
    if ($is_admin) {
        $unmapped = [];
        foreach ($all_unique_categories as $category) {
            if (!in_array(normalize_category_name($category), $mapped_children_names)) {
                $unmapped[] = $category;
            }
        }
        if (!empty($unmapped)) {
            usort($unmapped, 'strcasecmp');
            $menu[] = [
                'parent' => 'Unassigned',
                'children' => $unmapped
            ];
        }
    }
    
    return $menu;
}

/**
 * Check if the current view should be an admin view.
 * TODO: wire to real auth when available. Hardcoded false means SHOW CAR and other unmapped items are hidden from menu.
 */
function is_admin_view(): bool {
    return false;
}

/**
 * Maps parent categories to Lucide icon names.
 */
function get_parent_icon(string $parent_name): string {
    static $icons = [
        'ALL'                                     => 'layout-grid',
        'Promotional Goods'                       => 'shirt',
        'Private Storage'                         => 'warehouse',
        'Technical'                               => 'wrench',
        'OS&E - Operating Supplies & Equipment'   => 'package',
        'FORMULA E'                               => 'flag',
        'CWW - Cleaning, Waste & Washrooms'       => 'spray-can',
        'FF&E - Furniture, Fixtures & Equipment'  => 'sofa',
        'IT'                                      => 'monitor',
        'KITCHEN EQUIPMENT'                       => 'utensils',
        'MICROMOBILITY'                           => 'bike',
        'SPORTING'                                => 'trophy',
        'Production elements'                     => 'clapperboard',
        'FIRE AND SAFETY'                         => 'shield-alert',
    ];
    return $icons[$parent_name] ?? 'tag';   // 'tag' as fallback
}

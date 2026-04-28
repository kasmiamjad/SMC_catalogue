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
 * Get the grouped menu structure.
 */
function get_grouped_menu(array $all_unique_categories, bool $is_admin = false): array {
    $menu = [];
    $parents = get_parents();
    $mapped_children = [];
    
    foreach ($parents as $parent) {
        $children = get_children_of($parent, $all_unique_categories);
        if (!empty($children)) {
            $menu[] = [
                'parent' => $parent,
                'children' => $children
            ];
            // Keep track of which categories were mapped
            foreach ($children as $child) {
                $mapped_children[] = normalize_category_name($child);
            }
        }
    }
    
    if ($is_admin) {
        $unmapped = [];
        foreach ($all_unique_categories as $category) {
            if (!in_array(normalize_category_name($category), $mapped_children)) {
                $unmapped[] = $category;
            }
        }
        
        if (!empty($unmapped)) {
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

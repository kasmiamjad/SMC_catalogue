<?php
/**
 * Category taxonomy — single source of truth for parent → child grouping.
 *
 * Edit this file directly to add/move/remove mappings. Run the audit tool
 * after editing:
 *   php tools/audit_categories.php
 *
 * Match rule: child names are compared against product_category strings in
 * data.json after normalization (trim, lowercase, collapse internal whitespace,
 * normalize unicode dashes, normalize slash-spacing). Render uses the original
 * Odoo string, not the normalized form.
 */

return [

    // Parent categories — display order matters. This is the order they
    // appear in the sidebar menu.
    'parents' => [
        'ALL',
        'Promotional Goods',
        'Private Storage',
        'Technical',
        'OS&E - Operating Supplies & Equipment',
        'FORMULA E',
        'CWW - Cleaning, Waste & Washrooms',
        'FF&E - Furniture, Fixtures & Equipment',
        'IT',
        'KITCHEN EQUIPMENT',
        'MICROMOBILITY',
        'SPORTING',
        'Production elements',
        'FIRE AND SAFETY',
        'Other',   // catch-all for categories not mapped below; always rendered last
    ],

    // Categories hidden from the catalogue entirely (menu, counts, product
    // lists). Matched after normalization, like the mappings below.
    'hidden' => [
        'All / Saleable / PoS',   // POS-only items (Discount, Tips)
    ],

    // Child → parent mappings.
    // Keys are child names matching product_category in data.json (after
    // normalization). Values are parent names from the list above.
    'mappings' => [

        // ALL
        'All'                                => 'ALL',

        // Promotional Goods
        'MERCHANDISE'                        => 'Promotional Goods',
        'GIVE AWAYS'                         => 'Promotional Goods',
        'UNIFORM'                            => 'Promotional Goods',

        // Private Storage
        'KARTING'                            => 'Private Storage',
        'STAFF APARTMENTS'                   => 'Private Storage',
        'TENNIS - ATP'                       => 'Private Storage',
        'COMMUNITY PROGRAM'                  => 'Private Storage',
        'PRIVATE SUITE'                      => 'Private Storage',
        'SAFF'                               => 'Private Storage',
        'SSC'                                => 'Private Storage',
        'STF'                                => 'Private Storage',
        'SAMF'                               => 'Private Storage',
        'RUH'                                => 'Private Storage',

        // Technical
        'TECHNICAL'                          => 'Technical',
        'TECHNICAL / ICAD'                   => 'Technical',
        'TECHNICAL / MUSCO'                  => 'Technical',
        'TECHNICAL / TV SCREEN'              => 'Technical',
        'TECHNICAL / VMR'                    => 'Technical',
        'IT / SKIDATA'                       => 'Technical',
        // Odoo dropped the "TECHNICAL / " / "IT / " prefixes (Nov 2026)
        'ICAD'                               => 'Technical',
        'MUSCO'                              => 'Technical',
        'TV SCREEN'                          => 'Technical',
        'SKIDATA'                            => 'Technical',

        // OS&E
        'CONSUMABLE'                         => 'OS&E - Operating Supplies & Equipment',
        'WARNING/CARDBOARD SIGNAGES'         => 'OS&E - Operating Supplies & Equipment',
        'LCT'                                => 'OS&E - Operating Supplies & Equipment',
        'STATIONERY'                         => 'OS&E - Operating Supplies & Equipment',
        'TOOLS & EQUIPMENTS'                 => 'OS&E - Operating Supplies & Equipment',
        'WATER & BEVERAGE'                   => 'OS&E - Operating Supplies & Equipment',
        'WRISTBAND & LANYARDS'               => 'OS&E - Operating Supplies & Equipment',

        // FORMULA E
        'FORMULA E'                          => 'FORMULA E',

        // CWW
        'CLEANING & WASTE'                   => 'CWW - Cleaning, Waste & Washrooms',

        // FF&E
        'FURNITURE'                          => 'FF&E - Furniture, Fixtures & Equipment',
        'FURNITURE / DECOR'                  => 'FF&E - Furniture, Fixtures & Equipment',
        'FURNITURE / MOS'                    => 'FF&E - Furniture, Fixtures & Equipment',
        'FURNITURE / OUTDOOR FURNITURE'      => 'FF&E - Furniture, Fixtures & Equipment',
        'FURNITURE / FANZONE'                => 'FF&E - Furniture, Fixtures & Equipment',
        'FURNITURE / POTTED PLANTS'          => 'FF&E - Furniture, Fixtures & Equipment',
        'FURNITURE / RUGS & CARPETS'         => 'FF&E - Furniture, Fixtures & Equipment',
        'FURNITURE / VILLA 4'                => 'FF&E - Furniture, Fixtures & Equipment',
        // Odoo dropped the "FURNITURE / " prefix (Nov 2026)
        'DECOR'                              => 'FF&E - Furniture, Fixtures & Equipment',
        'MOS'                                => 'FF&E - Furniture, Fixtures & Equipment',
        'OUTDOOR FURNITURE'                  => 'FF&E - Furniture, Fixtures & Equipment',
        'FANZONE'                            => 'FF&E - Furniture, Fixtures & Equipment',
        'POTTED PLANTS'                      => 'FF&E - Furniture, Fixtures & Equipment',
        'RUGS & CARPETS'                     => 'FF&E - Furniture, Fixtures & Equipment',
        'VILLA 4'                            => 'FF&E - Furniture, Fixtures & Equipment',
        'INDOOR SPORTS'                      => 'FF&E - Furniture, Fixtures & Equipment',
        'ELECTRIC & ELECTRONIC'              => 'FF&E - Furniture, Fixtures & Equipment',
        // ^ NOTE: source taxonomy assigns this child to BOTH FF&E and OS&E
        //   (fridges/water-dispensers/fans → FF&E; extension-cords/microphones/
        //   coffee-machines → OS&E). Defaulting to FF&E. Manual split is a
        //   future task — do not auto-split.

        // IT
        'IT'                                 => 'IT',

        // KITCHEN EQUIPMENT
        'KITCHEN EQUIPMENT'                  => 'KITCHEN EQUIPMENT',

        // MICROMOBILITY
        'MICROMOBILITY'                      => 'MICROMOBILITY',

        // SPORTING
        'SPORTING'                           => 'SPORTING',
        'MEDICAL'                            => 'SPORTING',
        'MARSHAL'                            => 'SPORTING',
        'SPORT TOTAL'                        => 'SPORTING',
        'SWEEPER'                            => 'SPORTING',
        'SWEEPER MACHINE'                    => 'SPORTING',
        'TRACK PAINT'                        => 'SPORTING',

        // Production elements
        'PRODUCTION ASSETS'                  => 'Production elements',
        'PRODUCTION / SINGNAGE & WAYFINDING' => 'Production elements',
        'SIGNAGE & WAYFINDING'               => 'Production elements',
        'SHOW CAR'                           => 'Production elements',

        // FIRE AND SAFETY
        'PRODUCTION / FIRE & SAFETY'         => 'FIRE AND SAFETY',
        'FIRE & SAFETY'                      => 'FIRE AND SAFETY',

    ],
];

<?php

declare(strict_types=1);

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * @return array<string, mixed>
 */
function modularityMosaicBuildColorField(string $prefix): array
{
    return [
        'key' => 'field_' . $prefix . '_color',
        'label' => __('Färg', 'modularity-mosaic'),
        'name' => 'color',
        'type' => 'button_group',
        'required' => 1,
        'instructions' => __('På Lidingö är Primär = blå, Sekundär = röd, Tertiär = brun och Kvartär = grön. Se satta temafärger under Utseende -> Anpassa -> Generellt utseende -> Färger. Underwebbar kan använda andra paletter.', 'modularity-mosaic'),
        'choices' => [
            'primary' => __('Primär', 'modularity-mosaic'),
            'secondary' => __('Sekundär', 'modularity-mosaic'),
            'tertiary' => __('Tertiär', 'modularity-mosaic'),
            'quaternary' => __('Kvartär', 'modularity-mosaic'),
        ],
        'default_value' => 'tertiary',
        'return_format' => 'value',
        'allow_null' => 0,
        'layout' => 'horizontal',
        'wrapper' => [
            'width' => '50',
            'class' => '',
            'id' => '',
        ],
    ];
}

/**
 * @return array<string, mixed>
 */
function modularityMosaicBuildImagePositionField(string $prefix): array
{
    return [
        'key' => 'field_' . $prefix . '_image_position',
        'label' => __('Bildplacering', 'modularity-mosaic'),
        'name' => 'image_position',
        'type' => 'radio',
        'required' => 1,
        'choices' => [
            'left' => __('Vänster', 'modularity-mosaic'),
            'right' => __('Höger', 'modularity-mosaic'),
        ],
        'default_value' => 'right',
        'return_format' => 'value',
        'allow_null' => 0,
        'other_choice' => 0,
        'layout' => 'horizontal',
        'save_other_choice' => 0,
        'wrapper' => [
            'width' => '50',
            'class' => '',
            'id' => '',
        ],
    ];
}

/**
 * @return array<int, array<string, mixed>>
 */
function modularityMosaicBuildCardFields(string $prefix, bool $includeImage, bool $includeImagePosition): array
{
    $fields = [
        [
            'key' => 'field_' . $prefix . '_title',
            'label' => __('Rubrik', 'modularity-mosaic'),
            'name' => 'title',
            'type' => 'text',
            'required' => 1,
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
        ],
        [
            'key' => 'field_' . $prefix . '_body',
            'label' => __('Text', 'modularity-mosaic'),
            'name' => 'body',
            'type' => 'textarea',
            'required' => 1,
            'default_value' => '',
            'new_lines' => 'wpautop',
            'maxlength' => '',
            'placeholder' => '',
            'rows' => 4,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
        ],
        [
            'key' => 'field_' . $prefix . '_link',
            'label' => __('Knapplänk', 'modularity-mosaic'),
            'name' => 'link',
            'type' => 'link',
            'required' => 0,
            'return_format' => 'array',
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
        ],
        modularityMosaicBuildColorField($prefix),
    ];

    if ($includeImage) {
        $fields[] = [
            'key' => 'field_' . $prefix . '_image',
            'label' => __('Bild', 'modularity-mosaic'),
            'name' => 'image',
            'type' => 'image',
            'required' => 1,
            'return_format' => 'id',
            'preview_size' => 'medium',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
        ];
    }

    if ($includeImagePosition) {
        $fields[] = modularityMosaicBuildImagePositionField($prefix);
    }

    return $fields;
}

/**
 * @return array<string, mixed>
 */
function modularityMosaicBuildCardGroup(
    string $prefix,
    string $name,
    string $label,
    bool $includeImage,
    bool $includeImagePosition
): array {
    return [
        'key' => 'field_' . $prefix . '_group',
        'label' => $label,
        'name' => $name,
        'type' => 'group',
        'required' => 1,
        'layout' => 'block',
        'sub_fields' => modularityMosaicBuildCardFields($prefix, $includeImage, $includeImagePosition),
        'wrapper' => [
            'width' => '',
            'class' => '',
            'id' => '',
        ],
    ];
}

/**
 * @return array<string, mixed>
 */
function modularityMosaicBuildLayoutInfoField(string $keySuffix, string $message): array
{
    return [
        'key' => 'field_mod_mosaic_layout_info_' . $keySuffix,
        'label' => __('Instruktion', 'modularity-mosaic'),
        'name' => '',
        'type' => 'message',
        'message' => $message,
        'new_lines' => 'wpautop',
        'esc_html' => 0,
        'wrapper' => [
            'width' => '',
            'class' => '',
            'id' => '',
        ],
    ];
}

acf_add_local_field_group([
    'key' => 'group_modularity_mosaic_settings',
    'title' => __('Modularity Mosaic', 'modularity-mosaic'),
    'fields' => [
        [
            'key' => 'field_mod_mosaic_sections',
            'label' => __('Mosaiker', 'modularity-mosaic'),
            'name' => 'mod_mosaic_sections',
            'type' => 'flexible_content',
            'required' => 1,
            'instructions' => __(
                "Välj en mosaiktyp för varje rad. Du kan kombinera flera mosaiker i valfri ordning.",
                'modularity-mosaic'
            ),
            'button_label' => __('Lägg till mosaik', 'modularity-mosaic'),
            'layouts' => [
                [
                    'key' => 'layout_mod_mosaic_full',
                    'name' => 'full',
                    'label' => __('Helbredd (split)', 'modularity-mosaic'),
                    'display' => 'block',
                    'sub_fields' => [
                        modularityMosaicBuildLayoutInfoField(
                            'full',
                            __('Visning: en stor mosaik i helbredd med textdel och bilddel. Välj bildplacering till vänster eller höger.', 'modularity-mosaic')
                        ),
                        modularityMosaicBuildCardGroup(
                            'mod_mosaic_full_main',
                            'main_card',
                            __('Huvudkort', 'modularity-mosaic'),
                            true,
                            true
                        ),
                    ],
                    'min' => '',
                    'max' => '',
                ],
                [
                    'key' => 'layout_mod_mosaic_two_col_stacked',
                    'name' => 'two_col_stacked',
                    'label' => __('Två kolumner (huvud + två)', 'modularity-mosaic'),
                    'display' => 'block',
                    'sub_fields' => [
                        modularityMosaicBuildLayoutInfoField(
                            'two_col_stacked',
                            __('Visning: vänster kolumn med ett huvudkort. Höger kolumn med två mindre kort, ett överst och ett nederst.', 'modularity-mosaic')
                        ),
                        modularityMosaicBuildCardGroup(
                            'mod_mosaic_two_col_stacked_left_main',
                            'left_main',
                            __('Huvudkort (vänster)', 'modularity-mosaic'),
                            true,
                            false
                        ),
                        modularityMosaicBuildCardGroup(
                            'mod_mosaic_two_col_stacked_right_top',
                            'right_top',
                            __('Sidokort (höger, överst)', 'modularity-mosaic'),
                            true,
                            false
                        ),
                        modularityMosaicBuildCardGroup(
                            'mod_mosaic_two_col_stacked_right_bottom',
                            'right_bottom',
                            __('Sidokort (höger, nederst)', 'modularity-mosaic'),
                            true,
                            false
                        ),
                    ],
                    'min' => '',
                    'max' => '',
                ],
                [
                    'key' => 'layout_mod_mosaic_two_col_image_top',
                    'name' => 'two_col_image_top',
                    'label' => __('Två kolumner (huvud + bildkort)', 'modularity-mosaic'),
                    'display' => 'block',
                    'sub_fields' => [
                        modularityMosaicBuildLayoutInfoField(
                            'two_col_image_top',
                            __('Visning: vänster kolumn med huvudkort. Höger kolumn med ett kort där bilden ligger ovanför textinnehållet.', 'modularity-mosaic')
                        ),
                        modularityMosaicBuildCardGroup(
                            'mod_mosaic_two_col_image_top_left_main',
                            'left_main',
                            __('Huvudkort (vänster)', 'modularity-mosaic'),
                            true,
                            true
                        ),
                        modularityMosaicBuildCardGroup(
                            'mod_mosaic_two_col_image_top_right_card',
                            'right_card',
                            __('Sidokort (höger, bild över text)', 'modularity-mosaic'),
                            true,
                            false
                        ),
                    ],
                    'min' => '',
                    'max' => '',
                ],
            ],
            'min' => 1,
            'max' => 0,
            'layout' => 'block',
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
        ],
    ],
    'location' => [
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'mod-mosaic',
            ],
        ],
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/mosaic',
            ],
        ],
    ],
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
]);

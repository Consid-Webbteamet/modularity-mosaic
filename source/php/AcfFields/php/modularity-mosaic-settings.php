<?php

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group([
        'key' => 'group_modularity_mosaic_settings',
        'title' => __('Modularity Mosaic', 'modularity-mosaic'),
        'fields' => [
            [
                'key' => 'field_modularity_mosaic_rubrik',
                'label' => __('Rubrik', 'modularity-mosaic'),
                'name' => 'mod_mosaic_rubrik',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
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
}

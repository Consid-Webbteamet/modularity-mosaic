<?php

declare(strict_types=1);

namespace ModularityMosaic\Module;

class Mosaic extends \Modularity\Module
{
    public $slug = 'mosaic';
    public $supports = [];
    public $isBlockCompatible = true;
    public $expectsTitleField = false;

    public function init(): void
    {
        $this->nameSingular = __('Mosaic', 'modularity-mosaic');
        $this->namePlural = __('Mosaic', 'modularity-mosaic');
        $this->description = __('Displays mixed mosaic sections with image, text and links.', 'modularity-mosaic');
    }

    public function data(): array
    {
        $fields = $this->getFields();
        $sections = $this->normalizeSections((array) ($fields['mod_mosaic_sections'] ?? []));

        return [
            'sections' => $sections,
        ];
    }

    public function template(): string
    {
        return 'mosaic.blade.php';
    }

    /**
     * @param array<int, array<string, mixed>> $sections
     * @return array<int, array<string, mixed>>
     */
    private function normalizeSections(array $sections): array
    {
        $normalized = [];

        foreach ($sections as $index => $section) {
            if (!is_array($section)) {
                continue;
            }

            $layout = (string) ($section['acf_fc_layout'] ?? '');
            $sectionData = $this->normalizeSectionByLayout($layout, $section);

            if (empty($sectionData)) {
                continue;
            }

            $sectionData['index'] = $index;
            $normalized[] = $sectionData;
        }

        return $normalized;
    }

    /**
     * @param array<string, mixed> $section
     * @return array<string, mixed>
     */
    private function normalizeSectionByLayout(string $layout, array $section): array
    {
        switch ($layout) {
            case 'full':
                return [
                    'layout' => 'full',
                    'cards' => [
                        $this->normalizeCard((array) ($section['main_card'] ?? []), 'right'),
                    ],
                ];

            case 'two_col_stacked':
                return [
                    'layout' => 'two_col_stacked',
                    'cards' => [
                        $this->normalizeCard((array) ($section['left_main'] ?? []), 'right'),
                        $this->normalizeCard((array) ($section['right_top'] ?? []), 'right'),
                        $this->normalizeCard((array) ($section['right_bottom'] ?? []), 'left'),
                    ],
                ];

            case 'two_col_image_top':
                return [
                    'layout' => 'two_col_image_top',
                    'cards' => [
                        $this->normalizeCard((array) ($section['left_main'] ?? []), 'right'),
                        $this->normalizeCard((array) ($section['right_card'] ?? []), 'top'),
                    ],
                ];
        }

        return [];
    }

    /**
     * @param array<string, mixed> $card
     * @return array<string, mixed>
     */
    private function normalizeCard(array $card, string $defaultImagePosition): array
    {
        $colorParts = $this->splitColor((string) ($card['color'] ?? ''));
        $imagePosition = (string) ($card['image_position'] ?? $defaultImagePosition);
        $imageId = (int) ($card['image'] ?? 0);

        return [
            'title' => (string) ($card['title'] ?? ''),
            'body' => (string) ($card['body'] ?? ''),
            'link' => $this->normalizeLink($card['link'] ?? []),
            'imageId' => $imageId > 0 ? $imageId : null,
            'imagePosition' => $imagePosition,
            'backgroundVar' => $colorParts['backgroundVar'],
            'backgroundHex' => $colorParts['backgroundHex'],
            'textColor' => $this->getTextColor($colorParts['backgroundHex']),
        ];
    }

    /**
     * @param mixed $link
     * @return array{url:string,title:string,target:string}
     */
    private function normalizeLink($link): array
    {
        if (!is_array($link)) {
            return [
                'url' => '',
                'title' => '',
                'target' => '',
            ];
        }

        return [
            'url' => (string) ($link['url'] ?? ''),
            'title' => (string) ($link['title'] ?? ''),
            'target' => (string) ($link['target'] ?? ''),
        ];
    }

    /**
     * @return array{backgroundVar:string,backgroundHex:string}
     */
    private function splitColor(string $color): array
    {
        $namedColors = [
            'red' => [
                'backgroundVar' => '',
                'backgroundHex' => '#5B1E1E',
            ],
            'green' => [
                'backgroundVar' => '',
                'backgroundHex' => '#0E3E38',
            ],
            'brown' => [
                'backgroundVar' => '',
                'backgroundHex' => '#3A2A17',
            ],
        ];

        if (isset($namedColors[$color])) {
            return $namedColors[$color];
        }

        if (!str_contains($color, '::')) {
            return [
                'backgroundVar' => '',
                'backgroundHex' => '',
            ];
        }

        [$backgroundVar, $backgroundHex] = explode('::', $color);

        return [
            'backgroundVar' => (string) $backgroundVar,
            'backgroundHex' => (string) $backgroundHex,
        ];
    }

    private function getTextColor(string $backgroundHex): string
    {
        if (empty($backgroundHex)) {
            return '';
        }

        if (!class_exists('\Municipio\Helper\Color')) {
            return '';
        }

        return (string) \Municipio\Helper\Color::getBestContrastColor($backgroundHex, false);
    }
}

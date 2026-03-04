<?php

declare(strict_types=1);

namespace ModularityMosaic\Module;

class Mosaic extends \Modularity\Module
{
    public $slug = 'mosaic';
    public $supports = [];
    public $isBlockCompatible = true;

    public function init(): void
    {
        $this->nameSingular = __('Mosaic', 'modularity-mosaic');
        $this->namePlural = __('Mosaic', 'modularity-mosaic');
        $this->description = __('Displays a simple heading value.', 'modularity-mosaic');
    }

    public function data(): array
    {
        $fields = $this->getFields();

        return [
            'rubrik' => (string) ($fields['mod_mosaic_rubrik'] ?? ''),
        ];
    }

    public function template(): string
    {
        return 'mosaic.blade.php';
    }
}

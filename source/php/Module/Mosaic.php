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
        return [
            'rubrik' => (string) get_field('mod_mosaic_rubrik', $this->ID),
        ];
    }

    public function template(): string
    {
        return 'mosaic.blade.php';
    }
}

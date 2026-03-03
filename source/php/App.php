<?php

declare(strict_types=1);

namespace ModularityMosaic;

class App
{
    public function __construct()
    {
        add_action('init', [$this, 'registerModule']);
        add_filter('/Modularity/externalViewPath', [$this, 'registerExternalViewPath'], 10, 1);
    }

    public function registerModule(): void
    {
        if (function_exists('modularity_register_module')) {
            modularity_register_module(MODULARITYMOSAIC_MODULE_PATH, 'Mosaic');
        }
    }

    public function registerExternalViewPath(array $paths): array
    {
        $paths['mod-mosaic'] = MODULARITYMOSAIC_MODULE_VIEW_PATH;
        return $paths;
    }
}

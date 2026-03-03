<?php

declare(strict_types=1);

/**
 * Plugin Name:       Modularity Mosaic
 * Description:       A Modularity module with a simple heading field.
 * Version:           0.1.0
 * Author:            Consid Webbteamet
 * Text Domain:       modularity-mosaic
 * Domain Path:       /languages
 */

namespace ModularityMosaic;

if (!defined('WPINC')) {
    die;
}

define('MODULARITYMOSAIC_PATH', plugin_dir_path(__FILE__));
define('MODULARITYMOSAIC_URL', plugins_url('', __FILE__));
define('MODULARITYMOSAIC_MODULE_PATH', MODULARITYMOSAIC_PATH . 'source/php/Module/');
define('MODULARITYMOSAIC_MODULE_VIEW_PATH', MODULARITYMOSAIC_PATH . 'source/php/Module/views');

add_action('init', static function (): void {
    load_plugin_textdomain('modularity-mosaic', false, plugin_basename(dirname(__FILE__)) . '/languages');
});

require_once MODULARITYMOSAIC_PATH . 'Public.php';

$autoload = MODULARITYMOSAIC_PATH . 'vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
} else {
    spl_autoload_register(static function (string $class): void {
        $prefix = __NAMESPACE__ . '\\';
        if (strpos($class, $prefix) !== 0) {
            return;
        }

        $relativeClass = substr($class, strlen($prefix));
        $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
        $file = MODULARITYMOSAIC_PATH . 'source/php/' . $relativePath;

        if (file_exists($file)) {
            require_once $file;
        }
    });
}

add_action('acf/init', static function (): void {
    if (class_exists('\\AcfExportManager\\AcfExportManager')) {
        $acfExportManager = new \AcfExportManager\AcfExportManager();
        $acfExportManager->setTextdomain('modularity-mosaic');
        $acfExportManager->setExportFolder(MODULARITYMOSAIC_PATH . 'source/php/AcfFields/');
        $acfExportManager->autoExport([
            'modularity-mosaic-settings' => 'group_modularity_mosaic_settings',
        ]);
        $acfExportManager->import();

        return;
    }

    // Fallback if AcfExportManager is unavailable.
    $acfFields = MODULARITYMOSAIC_PATH . 'source/php/AcfFields/php/modularity-mosaic-settings.php';
    if (file_exists($acfFields)) {
        require_once $acfFields;
    }
});

add_action('plugins_loaded', static function (): void {
    if (!class_exists(App::class)) {
        return;
    }

    new App();
});

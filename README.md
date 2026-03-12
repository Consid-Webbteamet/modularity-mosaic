# Modularity Mosaic

A Modularity module plugin for Municipio that provides configurable mosaic layouts in Gutenberg.

## Features

- Registers the Modularity module `Mosaic` (`mod-mosaic` / `acf/mosaic`)
- Supports block-based editing in Gutenberg
- Supports multiple mosaics in one block via flexible content
- Includes three layout variants:
  - `Helbredd (split)`
  - `Två kolumner (huvud + två)`
  - `Två kolumner (huvud + bildkort)`
- Includes semantic color roles per card:
  - `Primär`
  - `Sekundär`
  - `Tertiär`
  - `Kvartär`
- Exports ACF definitions to both PHP and JSON using `AcfExportManager`

## Requirements

- PHP 8.0+
- Municipio / Modularity
- Advanced Custom Fields

## Installation

Install as a Composer package (type `wordpress-plugin`) from:

- `https://github.com/Consid-Webbteamet/modularity-mosaic`

Then activate the plugin in WordPress and enable `Mosaic` in Modularity options.

## ACF Export

The plugin uses `AcfExportManager` on `acf/init` with:

- Group key: `group_modularity_mosaic_settings`
- PHP export: `source/php/AcfFields/php/modularity-mosaic-settings.php`
- JSON export: `source/php/AcfFields/json/modularity-mosaic-settings.json`

If ACF field groups are edited in admin, keep the group key mapping in sync with `autoExport`.

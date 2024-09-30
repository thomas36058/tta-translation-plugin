# TTA Translation Plugin

This WordPress plugin allows users to enter English strings for translation into multiple languages using the Weglot API. Translated strings are accessible via a REST API.

## Features

- Custom post type for managing translatable strings.
- Translates strings into the following languages:
  - Brazilian Portuguese
  - Dutch
  - French
  - German
  - Italian
  - Japanese
  - Polish
  - Portuguese
  - Spanish
  - Russian
- Translated strings are available as a JSON response.

## Installation

1. Clone the repository or download the ZIP file.
2. Upload the plugin folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

1. **Add Translatable Strings**: Navigate to the "Translatable Strings" section in the WordPress admin to add new strings.
2. **Translate Strings**: Use the provided REST API endpoint to retrieve translations.

### API Endpoints

- **Get Translations**:

GET /wp-json/tta-plugin/v1/translate/{lang}

Replace `{lang}` with the desired language code (e.g., `fr` for French).

## Code Documentation

### `tm_register_translations_post_type()`

Registers a custom post type for translatable strings.

### `tta_get_original_texts()`

Retrieves all original strings stored.

### `tta_get_translations_for_language($request)`

Retrieves translations for the requested language.

### `tta_translate_strings($texts, $target_language)`

Translates an array of strings into the specified target language using the Weglot API.

### `tta_get_available_languages()`

Returns an array of available languages for translation.

## Requirements

- WordPress 5.0 or higher.
- PHP 7.0 or higher.

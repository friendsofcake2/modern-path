# ModernPath Plugin for CakePHP 2.x

Simple plugin to use `/templates` directory instead of `/app/View` for templates and modernize your CakePHP 2.x directory structure to match CakePHP 5 conventions.

## Benefits

By adopting the CakePHP 5 directory structure in your CakePHP 2.x application, you gain:

- **Smoother Migration Path**: When upgrading to CakePHP 5 in the future, your directory structure will already be compatible, reducing migration complexity
- **Consistent Development Experience**: Developers working on both CakePHP 2 and CakePHP 5 projects can use the same directory conventions
- **Modern Standards**: Align with PSR-4 autoloading standards and modern PHP project structures
- **Reduced Refactoring**: Template files and configuration locations remain unchanged when upgrading
- **Cleaner Project Root**: Separate concerns with dedicated directories for source code, configuration, and templates

## Modern Directory Structure

With this plugin, you can achieve a CakePHP 5-compatible directory structure:

```
/                        # Your project root
├── config/             # Configuration files (instead of app/Config)
│   ├── bootstrap.php
│   ├── core.php
│   ├── database.php
│   └── email.php
├── plugins/            # CakePHP plugins
│   ├── DebugKit/
│   └── ModernPath/
├── resources/          # Resources
│   └── locales/       # Translation files (instead of app/Locale)
│       ├── eng/
│       └── jpn/
├── src/                # Application source (instead of app/)
│   ├── Controller/
│   ├── Model/
│   └── View/          # View classes only
├── templates/          # Template files (instead of app/View)
│   ├── Users/
│   ├── Posts/
│   ├── Layouts/
│   └── Emails/
├── tests/              # Test files
├── tmp/                # Temporary files
├── logs/               # Log files
├── vendor/             # Composer dependencies
├── webroot/            # Public web root
└── composer.json
```

This structure matches CakePHP 5's directory layout, making future upgrades significantly easier.

## Directory Structure Comparison

| Purpose | CakePHP 2 (Default) | Modern Structure (CakePHP 5 Compatible) |
|---------|-------------------|------------------------------------------|
| Application Code | `/app/Controller/`<br>`/app/Model/` | `/src/Controller/`<br>`/src/Model/` |
| Configuration | `/app/Config/` | `/config/` |
| View Templates | `/app/View/` | `/templates/` |
| Plugins | `/app/Plugin/` | `/plugins/` |
| Translations | `/app/Locale/` | `/resources/locales/` |
| Web Root | `/app/webroot/` | `/webroot/` |
| Temporary Files | `/app/tmp/` | `/tmp/` |
| Test Files | `/app/Test/` | `/tests/` |
| Vendor Libraries | `/app/Vendor/` or `/vendors/` | `/vendor/` |
| Log Files | `/app/tmp/logs/` | `/logs/` |
| Cache Files | `/app/tmp/cache/` | `/tmp/cache/` |

## Installation

```bash
composer require friendofcake2/modern-path
```

## Setup

### 1. Configure webroot/index.php

Update your `webroot/index.php` with the following configuration to support the modern directory structure:

```php
/*
 * The full path to the directory which holds "app", WITHOUT a trailing DS.
 */
if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__));
}

/*
 * The actual directory name for the "app".
 */
if (!defined('APP_DIR')) {
    define('APP_DIR', 'src');
}

/*
 * Config Directory
 */
if (!defined('CONFIG')) {
    define('CONFIG', ROOT.'/config/');
}

/**
 * This auto-detects CakePHP as a composer installed library.
 * You may remove this if you are not planning to use composer (not recommended, though).
 */
$vendorPath = ROOT.'/vendor/friendsofcake2/cakephp/lib';
$dispatcher = 'Cake/Console/ShellDispatcher.php';
if (!defined('CAKE_CORE_INCLUDE_PATH') && file_exists($vendorPath.'/'.$dispatcher)) {
    define('CAKE_CORE_INCLUDE_PATH', $vendorPath);
}

/*
 * Editing below this line should NOT be necessary.
 * Change at your own risk.
 */
if (!defined('WEBROOT_DIR')) {
    define('WEBROOT_DIR', basename(__DIR__));
}
if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', __DIR__.'/');
}
if (!defined('VENDORS')) {
    define('VENDORS', ROOT.'/vendor/');
}
if (!defined('TESTS')) {
    define('TESTS', ROOT.'/tests/');
}
if (!defined('TMP')) {
    define('TMP', ROOT.'/tmp/');
}
if (!defined('LOGS')) {
    define('LOGS', ROOT.'/logs/');
}
```

### 2. Load the plugin

Add to your `app/Config/bootstrap.php` or `config/bootstrap.php`:

```php
CakePlugin::load('ModernPath', array('bootstrap' => true));
```

### 3. Configure plugins directory in composer.json

To use the modern `/plugins` directory instead of `/app/Plugin`, update your `composer.json`:

```json
{
    "extra": {
        "installer-paths": {
            "plugins/{$name}/": ["type:cakephp-plugin"]
        }
    }
}
```

This will install CakePHP plugins to `/plugins` directory when using Composer.

### 4. Configure Email (if using CakeEmail)

Update your email configuration in `app/Config/email.php` or `config/email.php`:

```php
class EmailConfig {
    public $default = [
        'viewRender' => 'ModernPath.ModernPath',
        // ... other email configuration
    ];

    // Other email configurations can also use ModernPath
    public $smtp = [
        'viewRender' => 'ModernPath.ModernPath',
        'transport' => 'Smtp',
        // ... other smtp configuration
    ];
}
```

## Usage

### Create templates in the new structure

```
/templates/
├── Users/
│   ├── index.ctp
│   └── view.ctp
├── Posts/
│   └── index.ctp
├── Layouts/
│   └── default.ctp
└── Emails/
    ├── text/
    │   └── welcome.ctp
    └── html/
        └── welcome.ctp
```

## Configuration

### Template Path Configuration

You can customize the template path by setting the configuration in your bootstrap file:

```php
// Use a different template directory
Configure::write('ModernPath.templatePath', ROOT . DS . 'themes' . DS . 'modern' . DS);

// Or use a subdirectory
Configure::write('ModernPath.templatePath', ROOT . DS . 'public' . DS . 'templates' . DS);
```

### Translation Files

The plugin automatically configures the locale directory to use `/resources/locales/`. Simply organize your translation files as:

```
/resources/locales/
├── eng/
│   └── LC_MESSAGES/
│       └── default.po
├── jpn/
│   └── LC_MESSAGES/
│       └── default.po
└── fra/
    └── LC_MESSAGES/
        └── default.po
```

No additional configuration is required for translations. The plugin's bootstrap automatically sets up the locale path.

You can customize the locale path if needed:

```php
// Use a different locale directory
Configure::write('ModernPath.localePath', ROOT . DS . 'custom' . DS . 'translations' . DS);
```

## Features

- Use `/templates` directory for views instead of `/app/View`
- Automatic configuration of `/resources/locales` for translations instead of `/app/Locale`
- Support for Email templates with custom ViewRender
- Configurable template and locale paths
- Compatible with CakePHP 5 directory structure
- Maintains backward compatibility with CakePHP 2.x

## Migration Advantages

When you eventually upgrade to CakePHP 5, the following elements will already be in place:

1. **Templates Location**: Your `.ctp` files in `/templates` will only need extension changes to `.php`
2. **Configuration Path**: Config files in `/config` directory match CakePHP 5 exactly
3. **Source Organization**: The `/src` directory structure aligns with CakePHP 5's namespace conventions
4. **Vendor Integration**: Composer-based vendor directory is already standard
5. **Test Structure**: Tests in `/tests` follow the modern convention

This means your upgrade process focuses on code changes rather than restructuring your entire project.

## Email Template Usage

When using the ModernPath plugin for emails:

```php
// In your controller or model
App::uses('CakeEmail', 'Network/Email');

$Email = new CakeEmail();
$Email->config('default')  // Uses ModernPath.ModernPath viewRender
    ->template('welcome')
    ->emailFormat('html')
    ->to('user@example.com')
    ->subject('Welcome!')
    ->send();
```

Your email templates should be placed in:
- **Text emails**: `/templates/Emails/text/welcome.ctp`
- **HTML emails**: `/templates/Emails/html/welcome.ctp`

## Advanced Usage

### Custom Theme Directory

```php
// In your bootstrap.php
Configure::write('ModernPath.templatePath', ROOT . DS . 'themes' . DS . 'mytheme' . DS);
```

## Troubleshooting

### Templates not loading

1. Ensure the plugin is loaded correctly in bootstrap.php
2. Check that your template files have the `.ctp` extension
3. Verify the template path configuration

### Email templates not working

1. Confirm `viewRender` is set to `ModernPath.ModernPath` in email config
2. Check that email templates are in `/templates/Emails/` directory
3. Ensure email format matches template directory (`text/` or `html/`)

## Requirements

- CakePHP 2.10 or higher
- PHP 8.0 or higher
- Composer

## License

MIT License

<!-- README.md -->

# Livewire Easy Tags

Livewire Easy Tags is a powerful and convenient package that enhances the Livewire experience by simplifying the process of working with tags and tag inputs. With this package, you can easily integrate tags functionality into your Livewire components, allowing users to add, edit, and remove tags effortlessly.

## Installation

To install Livewire Easy Tags, use Composer:

```bash
composer require codekinz/livewire-easy-tags
```

## Prerequisite

- Livewire 2.x or higher
- Alpine Js 3.x or higher
- Laravel Spatie Tags 4.x or higher
- Tagify 3.x or higher
- Tailwind 2.x or higher


## Getting Started

### Setup

1. After installing the package via Composer, add the service provider to your `config/app.php` file:

```php
// config/app.php

'providers' => [
    // Other service providers
    Codekinz\LivewireEasyTags\ServiceProvider::class,
],
```
Publish the migration and config files
```
php artisan vendor:publish --tag=livewire-easy-tags
```

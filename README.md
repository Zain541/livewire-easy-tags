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

1. After installing the package via Composer, you may need to add the service provider to your `config/app.php` file:

```php
// config/app.php

'providers' => [
    // Other service providers
    Codekinz\LivewireEasyTags\LivewireEasyTagsServiceProvider::class,
],
```
Publish the migration and config files
```
php artisan vendor:publish --tag=livewire-easy-tags
```
Run the migration
```
php artisan migrate
```
##Usage
In order to use Livewire easy tags, you will first need to create a Livewire component
```
php artisan make:livewire Tags
```
In Livewire Tags componenent, instead of extending the Livewire class you will need to extend the `LivewireEasyTags`. You Tags component should look like this
```
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Codekinz\LivewireEasyTags\Components\LivewireEasyTags;
use Codekinz\LivewireEasyTags\Contracts\HasEasyTags;
use Codekinz\LivewireEasyTags\Traits\InteractsWithTags;

class Tags extends LivewireEasyTags implements HasEasyTags
{
    use InteractsWithTags;
}

```
This package uses <a href="https://spatie.be/docs/laravel-tags/v4/introduction" target="_blank">Laravel Spatie Tags</a> as an underlying package. So, you need to use this Trait `HasSpatieTags` in your model class to use. Your model should look like this
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Codekinz\LivewireEasyTags\Traits\HasSpatieTags;

class YourModel extends Model
{
    use HasFactory, HasSpatieTags;
}
```

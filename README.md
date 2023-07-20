<!-- README.md -->

# Livewire Easy Tags

Livewire Easy Tags is a powerful and convenient package that enhances the Livewire experience by simplifying the process of working with tags and tag inputs. With this package, you can easily integrate tags functionality into your Livewire components, allowing users to add, edit, and remove tags effortlessly.

## Installation

To install Livewire Easy Tags, use Composer:

```bash
composer require codekinz/livewire-easy-tags
```

## Prerequisite
- Laravel 7.x or higher
- Livewire 2.x or higher
- Alpine Js 3.x or higher
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
```bash
php artisan vendor:publish --tag=livewire-easy-tags
```
Run the migration
```bash
php artisan migrate
```
## Usage
In order to use Livewire easy tags, you will first need to create a Livewire component
```bash
php artisan make:livewire Tags
```
In Livewire Tags componenent, instead of extending the Livewire class you will need to extend the `LivewireEasyTags`. You Tags component should look like this
```php
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
This package uses <a href="https://spatie.be/docs/laravel-tags/v4/introduction" target="_blank">Laravel Spatie Tags</a> as an underlying package. So, in order to use its functionality, you need to use this Trait `HasSpatieTags` in your model class.
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Codekinz\LivewireEasyTags\Traits\HasSpatieTags;

class YourModel extends Model
{
    use HasFactory, HasSpatieTags;
    ...
}
```
Now we are good to go. We just need to call our Livewire component in a blade file.
```blade
 @livewire('dashboard',
        [
            'modelClass' => App\Models\User::class,
            'modelId' => 2,
            'tagType' => 'tasks'
        ])
```
Here is the explanation of parameters
- `modelClass` is the class of the model that you want to associate with the tag
- `modelId` is the record identifier i.e primary key value
- `tagType` allows you to set up tags for multiple modules. For instance, you need to use tags for multiple modules like `travel`, `bookings` and `tasks` then you can add these values to the `tagType` parameter

## Configurations
Configurations are available at `config/livewire-easy-tags`. You can change the configuration in this file globally or you can use this function in your `Tags` component if you want to have multiple tags component
```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Codekinz\LivewireEasyTags\Components\LivewireEasyTags;
use Codekinz\LivewireEasyTags\Contracts\HasEasyTags;
use Codekinz\LivewireEasyTags\Traits\InteractsWithTags;

class Tags extends LivewireEasyTags implements HasEasyTags
{
    use InteractsWithTags;

    protected function configurations(): array
    {
       return [
            'colors' => [
                'lightblue' => '#add8e6',
                'lightgreen' => '#90ee90',
                'pink' => '#ffc0cb',
            ],
            'default_color' => 'yellow'
        ];
    }
}

```
## Main Contributor
- [Zain Farooq](https://www.linkedin.com/in/zain-farooq-b3a914147)

  
## License
Livewire Easy Tags is open-source software licensed under the MIT license and powered by [Codekinz](https://codekinz.com)

<?php

namespace LivewireEasyTags;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use LivewireEasyTags\components\LivewireEasyTags;
// namespace WireElements\Pro\Components\Modal\Foundation;


class LivewireEasyTagsServiceProvider extends ServiceProvider{


  public function boot()
  {
    $this->loadRoutesFrom(__DIR__  .   '/routes/web.php');
    $this->loadViewsFrom(__DIR__. '/views', 'livewire-easy-tags');
    Livewire::component('livewire-easy-tags', LivewireEasyTags::class);

    $this->publishes([
        __DIR__.'/Config/livewire-easy-tags.php' => config_path('livewire-easy-tags.php'),
    ], 'livewire-easy-tags-config');
    //php artisan vendor:publish --provider="LivewireEasyTags\LivewireEasyTagsServiceProvider"  --tag=livewire-easy-tags-config
  }

  public function register()
  {
  }

}

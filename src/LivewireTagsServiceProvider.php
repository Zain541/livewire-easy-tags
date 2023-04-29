<?php

namespace LivewireTags;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use LivewireTags\Components\LivewireTags;

// namespace WireElements\Pro\Components\Modal\Foundation;


class LivewireTagsServiceProvider extends ServiceProvider{

  public function boot()
  {
    $this->loadRoutesFrom(__DIR__  .   '/routes/web.php');
    $this->loadViewsFrom(__DIR__. '/views', 'livewire-tags');
    Livewire::component('livewire-tags', LivewireTags::class);
  }

  public function register()
  {
  }

}
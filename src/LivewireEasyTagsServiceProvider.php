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
  }

  public function register()
  {
  }

}
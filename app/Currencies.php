<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Currencies extends Model
{
        protected $presenter = "App\Presenters\SitePresenter";
}

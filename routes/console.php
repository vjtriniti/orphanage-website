<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about:app', function () {
    $this->info('Hope & Care orphanage application');
})->purpose('Display application information');

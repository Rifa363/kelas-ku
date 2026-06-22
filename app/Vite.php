<?php

namespace App;

use Illuminate\Foundation\Vite as BaseVite;

class Vite extends BaseVite
{
    public function isRunningHot(): bool
    {
        return false;
    }
}

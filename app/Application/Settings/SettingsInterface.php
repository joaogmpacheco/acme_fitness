<?php

namespace App\Application\Settings;

interface SettingsInterface
{
    public function getSettings(): array;
    public function get(string $key, $default = null);
}
<?php

namespace App\Application\Settings;

class Settings implements SettingsInterface
{
    private array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function get(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }
}

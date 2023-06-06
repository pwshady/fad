<?php

namespace fa\basic\models;

use fa\App;

class WidgetModel extends Model
{
    protected array $configs = [];

    public function __construct(public $dir){}

    public function run()
    {
        self::setConfigs();
        self::setSettings();
    }

    public function setConfigs()
    {
        if (file_exists($this->dir . '/config.json')) {            
            $configs = json_decode(file_get_contents($this->dir . '/config.json'), true);
            if (is_array($configs)) {
                $this->configs = $configs;
            }
        }
    }

    public function getConfigs()
    {
        return $this->configs;
    }

    public function getConfig($key)
    {
        if (array_key_exists($key, $this->configs)) {
            return $this->configs($key);
        }
        return null;
    }

}
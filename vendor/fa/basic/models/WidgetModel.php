<?php

namespace fa\basic\models;

use fa\App;

class WidgetModel extends Model
{
    protected $config;

    public function __construct(public $dir){}

    public function run()
    {
        self::getConfig();
        self::getSettings();
    }

    public function getConfig()
    {
        if (file_exists($this->dir . '/config.json')) {            
            $this->config = json_decode(file_get_contents($this->dir . '/config.json'), true);
        }
    }

}
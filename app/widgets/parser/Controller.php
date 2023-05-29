<?php

namespace app\widgets\parser;

use fa\basic\controllers\WidgetController;

use fa\App;

class Controller extends WidgetController
{

    private string $result = 'unknown result';
    private array $configs;

    public function run()
    {
        parent::run();
        self::job();
    }

    private function job(){
        $url_name = 'url';
        $key_name = 'key';
        $key = '';
        $url = '';
        $this->configs = $this->model->getConfigs();
        if (array_key_exists('url_name', $this->configs) && $this->configs['url_name'] != '') {
            $url_name = $this->configs['url_name'];
        }
        if (array_key_exists('key_name', $this->configs) && $this->configs['key_name'] != '') {
            $key_name = $this->configs['key_name'];
        }
        if (array_key_exists($url_name, $this->params) && $this->params[$url_name] != '') {
            $url = $this->params[$url_name]['value'];
            unset($this->params[$url_name]);
        } else {
            $this->result = 'Error. Url not set';
            return;
        }
        if (array_key_exists($key_name, $this->params) && $this->params[$key_name] != '') {
            $key = $this->params[$key_name]['value'];
            unset($this->params[$key_name]);
        }
        if (array_key_exists('key', $this->configs) && $key != $this->configs['key']) {
            $this->result = 'Error. Wrong key';
            return;
        }
        if (array_key_exists('type_pagination', $this->configs) && $this->configs['type_pagination'] != '') {
            switch ($this->configs['type_pagination']) {
                case 'next':
                    echo 'next';
            }
        } else {
            $html = self::getPage($url);
            $data = self::parsPage($html);
        }
    }

    private function getPage($url)
    {
        $curl = App::$app->getModul('curl')['object'];
        $ch = $curl->curl_init();
        $curl->curl_setopt($ch, CURLOPT_URL, "example.com");
        $curl->curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $html = $curl->curl_exec($ch);
        $curl->curl_close($ch);
        return $html;
    }

    private function parsPage($html)
    {
        $data = [];
        if (array_key_exists('mask', $this->configs) && is_array($this->configs['mask'])) {
            $mask = $this->configs['mask'];
            $data = self::parsDatas($html, $mask);
        } else {
            $this->result = 'Error. Mask not set';
        }
        return $data;
    }

    private function parsDatas($html, $mask)
    {
        $data = [];
            foreach ($mask as $key=>$value) {
                $revers = false;
                $type = 'single';
                $recurs = false;
                $recurs_mask = [];
                debug($mask);
                if (array_key_exists('data', $value) && is_array($value['data'])) {
                    if (array_key_exists('name', $value['data']) && is_string($value['data']['name']) && $value['data']['name'] != '') {
                        $key = $value['data']['name'];
                    }
                    if (array_key_exists('type', $value['data']) && is_string($value['data']['type']) && ($value['data']['type'] == 'single' || $value['data']['type'] == 'multi')) {
                        $type = $value['data']['type'];
                    } else {
                        $this->result = 'Error. Data type must be single or multi';
                    }
                    if (array_key_exists('revers', $value['data'])) {
                        $revers = $value['data']['type'];
                    }
                    debug( $key);
                
                    debug( $type);
                    debug( $revers);
                    echo 'hhhhh';
                } else {
                    $this->result = 'Error. No data in the mask';
                }
                //echo htmlspecialchars($html);
            }
        return $data;
    }

    public function render()
    {
        $widget['name'] = $this->widget_name;
        $widget['complete'] = 1;
        $labels = $this->model->setLabels();
        ob_start();
        echo $this->result;
        $html[0] = ob_get_clean();
        $widget['code'] = $html;
        App::$app->updateWidget($widget);
    }

}
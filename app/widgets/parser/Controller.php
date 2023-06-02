<?php

namespace app\widgets\parser;

use fa\basic\controllers\WidgetController;

use fa\App;

class Controller extends WidgetController
{

    private string $result = 'unknown result';
    private array $res = [];
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
            $url = $this->configs['base_url'] . $this->params[$url_name]['value'];
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
        $request = [];
        foreach ($this->params as $key=>$value) {
            $request[$key] = $value['value'];
        }
        $url .= '?' . http_build_query($request);
        if (array_key_exists('type_pagination', $this->configs) && $this->configs['type_pagination'] != '') {
            switch ($this->configs['type_pagination']) {
                case 'next':
                    $i = 0;
                    do{
                        $html = self::getPage($url);
                        $data = self::parsPage($html);
                        self::jobDatas($this->configs['mask_data'], $data);
                        $url = $this->configs['base_url'] . $this->res['pagination'];
                    } while($this->res['pagination'] != '');
                    break;
            }
        } else {
            $html = self::getPage($url);
            $data = self::parsPage($html);
            self::jobDatas($this->configs['mask_data'], $data);
        }
        debug($this->res);
    }

    private function getPage($url, $error=0)
    {
        $curl = App::$app->getModul('curl')['object'];
        $ch = $curl->curl_init();
        $curl->curl_setopt($ch, CURLOPT_URL, $url);
        $curl->curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
        $curl->curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
        $curl->curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl->curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $curl->curl_setopt($ch, CURLOPT_HEADER, false);
        $html = $curl->curl_exec($ch);
        $curl->curl_close($ch);
        if ($html == '' && array_key_exists('max_error', $this->configs) && is_numeric($this->configs['max_error']) && $error < $this->configs['max_error']){
            $html = self::getPage($url, $error+1);
        }
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
        $tec_html = $html;
            foreach ($mask as $key=>$value) {
                $type = 'all';
                $recurs_mask = [];
                $result['html'] = '';
                $recurs = false;
                if (array_key_exists('data', $value) && is_array($value['data'])) {
                    if (array_key_exists('name', $value['data']) && is_string($value['data']['name']) && $value['data']['name'] != '') {
                        $key = $value['data']['name'];
                    }
                    if (array_key_exists('type', $value['data']) && is_string($value['data']['type']) && 
                    (
                        $value['data']['type'] == 'single' || 
                        $value['data']['type'] == 'multi' || 
                        $value['data']['type'] == 'all' || 
                        $value['data']['type'] == 'revers'
                    )) {
                        $type = $value['data']['type'];
                    } else {
                        $this->result = 'Error. Data type must be single or multi or all';
                    }
                    if (array_key_exists('revers', $value['data'])) {
                        $revers = $value['data']['type'];
                    }
                    if (array_key_exists('mask', $value['data'])&& is_array($value['data']['mask'])) {
                        $recurs = true;
                        $recurs_mask = $value['data']['mask'];
                    }
                } else {
                    $this->result = 'Error. No data in the mask';
                    return;
                }
                //Proverka ne dodelana
                switch($type){
                    case 'single':
                        $result = self::parsData($tec_html, $value['prefix'], $value['postfix']);
                        $data[$key] = $result['data'];
                        if ($recurs) {
                            if (is_array($data[$key])){
                                $data[$key] = implode($data[$key]);
                            }
                            $data[$key] = self::parsDatas($data[$key], $recurs_mask);
                        }
                        break;
                    case 'multi':
                        $i = 0;
                        while($tec_html){
                            $result = self::parsData($tec_html, $value['prefix'], $value['postfix']);
                            $tec_html = $result['html'];
                            $data[$key][$i] = $result['data'];
                            if ($recurs) {
                                if (is_array($data[$key][$i])){
                                    $data[$key][$i] = implode($data[$key][$i]);
                                }
                                $data[$key][$i] = self::parsDatas($data[$key][$i], $recurs_mask);
                            }
                            $i++;
                        }
                        break;
                    case 'all':
                        $data[$key] = $tec_html;
                        if ($recurs) {
                            if (is_array($data[$key])){
                                $data[$key] = implode($data[$key]);
                            }
                            $data[$key] = self::parsDatas($data[$key], $recurs_mask);
                        }
                        break;
                    case 'revers':
                        $data[$key] = strrev($tec_html);
                        if ($recurs) {
                            if (is_array($data[$key])){
                                $data[$key] = implode($data[$key]);
                            }
                            $data[$key] = self::parsDatas($data[$key], $recurs_mask);
                        }
                        break;
                }
                $tec_html = $result['html'];
            }
        return $data;
    }

    private function parsData($html, $prefixs, $postfixs)
    {
        $result['data'] = [];
        $result['html'] = '';
        foreach($prefixs as $prefix) {
            $pos = strpos($html, $prefix);
            if ($pos === false){
                return $result;
            }
            $html = substr($html,$pos + strlen($prefix));
        }
        $tec_html = $html;
        foreach($postfixs as $postfix){
            $pos = strpos($tec_html, $postfix);
            if ($pos === false){
                return $result;
            }
            $tec_html = substr($tec_html,$pos + strlen($postfix));
        }
        $result['html'] = $tec_html;
        $tec_html = substr($html,0, -strlen($tec_html));
        $postfixs = array_reverse($postfixs);
        foreach($postfixs as $postfix){
            $pos = strrpos($tec_html, $postfix);
            $tec_html = substr($tec_html, 0, $pos);
        }
        $result['data'] = $tec_html;
        return $result;
    }

    private function jobDatas($mask_datas, $data)
    {
        $tec_result = [];
        foreach ($mask_datas as $key=>$mask_data){
            if (array_key_exists('key', $mask_data) && array_key_exists($mask_data['key'], $data)){
                $type = 'data';
                if (array_key_exists('type', $mask_data)){
                    $type = $mask_data['type'];
                }
                switch($type){
                    case 'data':
                        $tec_result = htmlspecialchars_decode($data[$mask_data['key']]);
                        break;
                    case 'datas':
                        $tec_result = self::jobDatas($mask_data['mask_data'], $data[$mask_data['key']]);
                        break;
                    case 'pagination':
                        $this->res['pagination'] = htmlspecialchars_decode($data[$mask_data['key']]);
                        break;
                    case 'table':
                        self::jobTable($data[$mask_data['key']], $mask_data['params']);
                        break;
                }
            }
        }
        return $tec_result;
    }

    private function jobTable($rows, $params)
    {
        foreach($rows as $row){
            $element = self::jobRow($row, $params);
            if($element){
                debug($element);
                debug('================================');
            }
        }

    }

    private function jobRow($row, $params)
    {
        $element = [];
        foreach ($params['row'] as $name=>$cell) {
            switch($cell['type']){
                case 'const':
                    $element[$name] = $cell['value'];
                    break;
                case 'data':
                    if (array_key_exists($cell['name'], $row)){
                        if (array_key_exists('dtype', $cell)) {
                            switch($cell['dtype']){
                                case 'is_string':
                                    if(is_string($row[$cell['name']])){
                                        $element[$name] = $row[$cell['name']];
                                    } else {
                                        return [];
                                    }
                                    break;
                            }
                        } else {
                            $element[$name] = $row[$cell['name']];
                        }
                    } else {
                        return [];
                    }
            }
        }
        return $element;
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
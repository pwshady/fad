<?php

namespace app\widgets\dtorrent;

use fa\basic\models\WidgetModel;

use fa\App;

class Model extends WidgetModel
{

    public function run()
    {
        parent::run();

    }

    public function setTdata($hash)
    {
        $db = App::$app->getModul('basedb')['object'];
        $tname = $this->configs['tdata']['tname'];
        $data = $db->findOne($tname,"hash=?",[$hash]);
        $data = empty($data) ? [] : $data->export();
        $result['hash'] = array_key_exists($this->configs['tdata']['hash'] ,$data) ? $data[$this->configs['tdata']['hash']] : '';
        $result['cat'] = array_key_exists($this->configs['tdata']['cat'] ,$data) ? 'cat-' . $data[$this->configs['tdata']['cat']] : 'cat-0';
        $result['name'] = array_key_exists($this->configs['tdata']['name'] ,$data) ? $data[$this->configs['tdata']['name']] : '';
        $result['magnet'] = array_key_exists($this->configs['tdata']['magnet'] ,$data) ? $data[$this->configs['tdata']['magnet']] : '';
        $result['size'] = array_key_exists($this->configs['tdata']['size'] ,$data) ? $data[$this->configs['tdata']['size']] : '';
        $result['seed'] = array_key_exists($this->configs['tdata']['seed'] ,$data) ? $data[$this->configs['tdata']['seed']] : 0;
        $result['leech'] = array_key_exists($this->configs['tdata']['leech'] ,$data) ? $data[$this->configs['tdata']['leech']] : 0;
        $result['dtime'] = array_key_exists($this->configs['tdata']['dtime'] ,$data) ? $data[$this->configs['tdata']['dtime']] : 0;
        return $result;
    }

    public function setInfo($hash)
    {
        $db = App::$app->getModul('basedb')['object'];
        $tname = $this->configs['info']['tname'];
        $description = $this->configs['info']['description'];
        $data = $db->findOne($tname,"hash=?",[$hash]);
        $data = empty($data) ? [] : $data->export();
        return empty($data) ? '' : (array_key_exists($description, $data) ? $data[$description] : '');
    }

    public function setTrackers($hash)
    {
        $db = App::$app->getModul('basedb')['object'];
        $tname = $this->configs['trackers']['tname'];
        $trackers = $this->configs['trackers']['trackers'];
        return $db->getAll('SELECT ' . $trackers . ' FROM ' . $tname . ' WHERE hash = ?',[$hash]);
    }

    public function setFiles($hash)
    {
        $db = App::$app->getModul('basedb')['object'];
        $tname = $this->configs['files']['tname'];
        $name = $this->configs['files']['name'];
        $size = $this->configs['files']['size'];
        return $db->getAll('SELECT ' . $name . ', ' . $size . ' FROM ' . $tname . ' WHERE hash = ?',[$hash]);
    }
}
<?php

namespace app\widgets\torrent;

use fa\basic\models\WidgetModel;
use fa\App;

class Model extends WidgetModel
{

    protected string $db = 'basedb';

    public function getLastAdd()
    {
        $db = App::$app->getModul($this->db)['object'];
        $start = $db->getCell("SELECT COUNT(*) FROM torrent", []) - 4;
        return $db->getAll("SELECT * FROM torrent ORDER BY id LIMIT $start, 4", []);
    }

    public function getCellLastRequest()
    {
        $db = App::$app->getModul($this->db)['object'];
        return $db->getCell("SELECT COUNT(*) FROM request", []);
    }

    public function save($table, $attributes)
    {
        $db = App::$app->getModul($this->db)['object'];
        $tbl = $db->dispense($table);
        foreach ( $attributes as $key => $value ) {
            if ( $value != '' ) {
                $tbl->$key = $value;
            }
        }
        return $db->store($tbl);
    }

    public function getLastRequest($start)
    {
        $db = App::$app->getModul($this->db)['object'];
        return $db->getAll("SELECT * FROM request ORDER BY id LIMIT $start, 4", []);
    }

    public function getCellResult($search)
    {
        $db = App::$app->getModul($this->db)['object'];
        return $db->getCell("SELECT COUNT(*) FROM torrent WHERE torrent.name LIKE ?", ["%{$search}%"]);
    }

    public function getResult($search, $start, $perpage): array
    {
        $db = App::$app->getModul($this->db)['object'];
        return $db->getAll("SELECT * FROM torrent WHERE torrent.name LIKE ? LIMIT $start, $perpage", ["%{$search}%"]);
    }

}
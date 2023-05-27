<?php

namespace app\widgets\torrent;

use fa\basic\controllers\WidgetController;

use fa\App;

class Controller extends WidgetController
{

    private array $result = [];
    private array $last_request = [];
    private array $last_add = [];
    public array $cat = [
        'cat-5' => '0',
        'cat-28' => '0',
        'cat-18' => '0',
        'cat-51' => '0',
        'cat-75' => '0',
        'cat-10' => '0',
        'cat-55' => '0',
        'cat-52' => '0',
        'cat-1' => '0',
        'cat-22' => '0',
        'cat-33' => '0',
        'cat-72' => '0',
        'cat-70' => '0',
        'cat-76' => '0',
        'cat-74' => '0',
        'cat-41' => '0',
        'cat-71' => '0',
        'cat-54' => '0',
    ];
    public $direct = '/search/';

    public function run()
    {
        parent::run();
        if ( App::$app->getLanguage()['code'] ) {
            $this->direct = App::$app->getLanguage()['code'] . $this->direct;
        }
        $url = rtrim( $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], '/' );


        if ( !isset($_SESSION[$this->prefix_kebab . 'last']) ) {
            $_SESSION[$this->prefix_kebab . 'last'] = $this->model->getCellLastRequest();
        }
        if ( isset($this->params['last']['value']) ) {
            $_SESSION[$this->prefix_kebab . 'last'] = $this->params['last']['value'];
        }
        if ( isset($this->params['add']['value']) ) {
            $_SESSION[$this->prefix_kebab . 'add'] = $this->params['add']['value'];
        }


        if ( isset($this->params['search']) ) {
            //cat
            if ( !isset($_SESSION[$this->prefix_kebab . 'cat']) ) {
                $_SESSION[$this->prefix_kebab . 'cat'] = $this->cat;
            }
            for ( $i = 1; $i < 100; $i++ ) {
                if ( isset($this->params['cat-' . $i]) && isset($_SESSION[$this->prefix_kebab . 'cat']['cat-' . $i]) ) {
                    $_SESSION[$this->prefix_kebab . 'cat']['cat-' . $i] = 1;
                }
                if ( isset($_SESSION[$this->prefix_kebab . 'cat']['cat-' . $i]) && !isset($this->params['cat-' . $i]) ) {
                    $_SESSION[$this->prefix_kebab . 'cat']['cat-' . $i] = 0;
                }
            }
        //---
        }
        //debug($this->params);
        //search
        if ( isset($this->params['search']['value']) && !empty($this->params['search']['value'])) {
            $url = rtrim( $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . App::$app->getUrl() . $this->direct, '/' ) . '/' . $this->params['search']['value'];
            header('Location: ' . $url );
            die;
        }
            $del = rtrim($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . App::$app->getUrl() . $this->direct, '/') . '/';
            $e = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            $search = str_replace($del, '', $e);
            $_SESSION[$this->prefix_kebab . 'search'] = $search;
            //debug($this->params);
            if ( isset($_SESSION[$this->prefix_kebab . 'add']) && $_SESSION[$this->prefix_kebab . 'add'] == 1 ) {
                $this->model->save('request', ['request' => $search, 'lang' => App::$app->getLanguage()['code']]);
                $_SESSION[$this->prefix_kebab . 'last'] = $this->model->getCellLastRequest();
            }
            $count = $this->model->getCellResult($search);
            if ( isset( $_SESSION[$this->prefix_kebab]['start']['value'] ) ) {
                $start = $_SESSION[$this->prefix_kebab]['start']['value'];
            } else {
                $start = 0;
            }
            $this->result = $this->model->getResult($search, $start, 5);
        
        //----




        $start = 0;
        if ( $_SESSION[$this->prefix_kebab . 'last'] - 4 > 0 ) {
            $start = $_SESSION[$this->prefix_kebab . 'last'] - 4;
        }
        $this->last_request = $this->model->getLastRequest($start);
        if ( isset($_SESSION[$this->prefix_kebab . 'cat']) ) {
            $this->cat = $_SESSION[$this->prefix_kebab . 'cat'];
        }
        $this->last_add = $this->model->getLastAdd();
        
    }

    public function render()
    {
        $widget['name'] = $this->widget_name;
        $widget['complete'] = 1;
        $labels = $this->model->setLabels();
        ob_start();
        require_once __DIR__ . '/searchView.php';
        $html[0] = ob_get_clean();
        ob_start();
        require_once __DIR__ . '/lastRequestView.php';
        $html[1] = ob_get_clean();
        ob_start();
        require_once __DIR__ . '/lastAddView.php';
        $html[2] = ob_get_clean();
        ob_start();
        require_once __DIR__ . '/resultView.php';
        $html[3] = ob_get_clean();
        $widget['code'] = $html;
        App::$app->updateWidget($widget);
    }

}

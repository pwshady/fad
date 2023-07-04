<?php

namespace app\widgets\dtorrent;

use fa\basic\controllers\WidgetController;

use fa\App;

class Controller extends WidgetController
{
    private array $tdata = [];
    private string $info = '';
    private array $trackers = [];
    private array $files = [];

    public function run()
    {
        parent::run();
        self::job();
    }

    private function job()
    {        
        $request = !empty(App::$app->getRequest()) ? App::$app->getRequest() : '';
        $this->tdata = $this->model->setTdata(App::$app->getRequest());
        $this->info = $this->model->setInfo(App::$app->getRequest());
        $this->trackers = $this->model->setTrackers(App::$app->getRequest());
        $this->files = $this->model->setFiles(App::$app->getRequest());
    }

    public function render()
    {
        $widget['name'] = $this->widget_name;
        $widget['complete'] = 1;
        $labels = $this->model->setLabels();
        ob_start();
        require_once __DIR__ . '/tdataView.php';
        $html[0] = ob_get_clean();
        ob_start();
        require_once __DIR__ . '/infoView.php';
        $html[1] = ob_get_clean();
        ob_start();
        require_once __DIR__ . '/fileView.php';
        $html[2] = ob_get_clean();
        ob_start();
        require_once __DIR__ . '/trackerView.php';
        $html[3] = ob_get_clean();
        $widget['code'] = $html;
        App::$app->updateWidget($widget);
    }

}
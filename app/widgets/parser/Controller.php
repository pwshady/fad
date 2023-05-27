<?php

namespace app\widgets\parser;

use fa\basic\controllers\WidgetController;

use fa\App;

class Controller extends WidgetController
{

    public function run()
    {
        parent::run();
        self::job();
    }

    private function job(){

    }

    public function render()
    {
        $widget['name'] = $this->widget_name;
        $widget['complete'] = 1;
        $labels = $this->model->setLabels();
        ob_start();
        //debug($this->model->getConfigs());
        debug($this->params);
        $html[0] = ob_get_clean();
        $widget['code'] = $html;
        App::$app->updateWidget($widget);
    }

}
<?php

namespace app\widgets\dtorrent;

use fa\basic\controllers\WidgetController;

use fa\App;

class Controller extends WidgetController
{

    public function run()
    {
        parent::run();
    }

    public function render()
    {
        $widget['name'] = $this->widget_name;
        $widget['complete'] = 1;
        $labels = $this->model->setLabels();
        ob_start();
        debug(App::$app->getPrefix());
        require_once __DIR__ . '/infoView.php';
        $html[0] = ob_get_clean();
        $widget['code'] = $html;
        App::$app->updateWidget($widget);
    }

}
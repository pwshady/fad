<?php

namespace app\widgets\languageselector;

use fa\basic\controllers\WidgetController;

use fa\App;

class Controller extends WidgetController
{

    private array $languages = [];
    private array $tec_language = [];

    public function run()
    {
        parent::run();
        self::job();
    }

    private function job()
    {
        if (!empty($this->params)){
            App::$app->setLanguage(['code' => $this->params['code']['value']]);
            App::$app->redirect();
        }
        if (is_file(ROOT . '/app/landlang.json')){
            $ll = json_decode(file_get_contents(ROOT . '/app/landlang.json'), true);
            $allowed_languages = $ll['languages'];
            if (is_file(__DIR__ . '/languages.json')){
                $all_languages = json_decode(file_get_contents(__DIR__ . '/languages.json'), true);
                $code = App::$app->getLanguage()['code'];
                $this->tec_language = $all_languages[$code];
                $this->tec_language['code'] = $code;
                $this->languages = array_intersect_key($all_languages, $allowed_languages);
            } else {
                return;
            }

        } else {
            return;
        }
        debug($this->public);
    }

    public function render()
    {
        $public = $this->public;
        $tec_language = $this->tec_language;
        $languages = $this->languages;
        $view_path = __DIR__ . '/indexView.php';
        $widget = App::$app->getWidget($this->widget_name);
        if (is_file($view_path)) {
            ob_start();
            require_once $view_path;
            $widget['code'] = ob_get_clean();
        } else {
            $widget['code'] = 'no code';
        }
        $widget['complete'] = 1;
        App::$app->updateWidget($widget);
    }
}
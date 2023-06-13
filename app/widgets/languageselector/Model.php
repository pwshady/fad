<?php

namespace app\widgets\languageselector;

use fa2\basic\models\WidgetModel;

class Model extends WidgetModel
{

    public function getLanguages()
    {
        $complete_languages = [];
        $languages = json_decode(file_get_contents(PAGE . '/language.json'), true);
        if (is_array($languages)) {
            if (array_key_exists('language', $languages)) {
                $languages = $languages['language'];
                $w_languages = json_decode(file_get_contents(__DIR__ . '/languages.json'), true);
                foreach ($languages as $key => $value) {
                    if ( array_key_exists('code', $value) ) {
                        if ( array_key_exists($value['code'], $w_languages) ) {
                            $complete_languages[$value['code']] = $w_languages[$value['code']];
                        }
                    }
                }
            }
        }
        return $complete_languages;
    }

}
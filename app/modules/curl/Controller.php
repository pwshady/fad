<?php

namespace app\modules\curl;

use fa\traits as t;
use Curl;

class Controller 
{

    use t\TSingleton;

    public function curl_init()
    {
        return curl_init();
    }

    public function curl_setopt($ch, $option, $value)
    {
        return curl_setopt($ch, $option, $value);
    }

    public function curl_exec($ch)
    {
        return curl_exec($ch);
    }

    public function curl_close($ch)
    {
        return curl_close($ch);
    }

}
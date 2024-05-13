<?php

namespace Ahmedmi;

class Helpers
{
    static public function dump($val): void
    {
        echo "<pre>";
        var_dump($val);
        echo "</pre>";
    }

    static public function dd($val): void
    {
        self::dump($val);
        die();
    }

    static function urlIs($value) : bool {
        return parse_url($_SERVER['REQUEST_URI'])['path'] == $value;
    }
    
    static function abort($code = 404) : void {
        // 404
        http_response_code($code);
        // you will need to check if you have a controller with the code name
        require "controllers/{$code}.php"; // different views for different status codes
        die();
    }

    static function setLoginErrorMsg() {
        if($_SESSION['loginError']) {
            $_SESSION['loginError'] = false;
            return "Error failed to login";
        }
    }
    
    
}

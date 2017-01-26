<?php

namespace Rfussien\Dotenv;

class Loader
{
    public static function load($file = null)
    {
        $env = (new Parser)->parse($file);

        foreach ($env as $key => $value) {
            static::setEnvironmentVariable($key, $value);
        }

        return $env;
    }

    public static function setEnvironmentVariable($key, $value)
    {
        if (function_exists('apache_getenv') &&
            function_exists('apache_setenv') &&
            apache_getenv($key)
        ) {
            apache_setenv($key, $value);
        }

        $_ENV[$key]    = $value;
        $_SERVER[$key] = $value;

        switch($value) {
            case null:
                putenv("$key=null");
                break;
            default:
            putenv("$key=$value");
        }
    }

    public static function getEnvironmentVariable($key, $default = null)
    {
        switch (true) {
            case array_key_exists($key, $_ENV):
                return $_ENV[$key];
            case array_key_exists($key, $_SERVER):
                return $_SERVER[$key];
            default:
                $value = getenv($key);
                return $value === false ? $default : $value;
        }
    }
}

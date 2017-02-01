<?php

/**
 * add the env function from illuminate 5.x
 */
if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        return Rfussien\Dotenv\Loader::getenv($key, $default);
    }
}

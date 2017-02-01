<?php

namespace Rfussien\Dotenv;

class Loader
{
    /**
     * Set the env file
     */
    protected $file;

    protected $parser;

    public function __construct($path, $filename = '.env')
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $this->file = $path . DIRECTORY_SEPARATOR . $filename;

        return $this;
    }

    /**
     * parse and set the env
     */
    public function load()
    {
        $this->parse();
        $this->toEnv();

        return $this;
    }

    public function parse(array $options = [])
    {
        $this->parser = new Parser;

        $this->parser->parse($this->file);

        return $this;
    }

    /**
     * Return the parser
     */
    public function getParser()
    {
        return $this->parser;
    }

    public function toEnv()
    {
        if (!isset($this->parser)) {
            throw new \LogicException("You must call parse() before", 1);
        }

        foreach ($this->parser->getContent() as $key => $value) {
            static::putenv($key, $value);
        }

        return $this;
    }

    public static function putenv($key, $value)
    {
        $_ENV[$key]    = $value;
        $_SERVER[$key] = $value;

        /*
         * putenv only accept string value
         */
        $value = $value === null ? 'null' : $value;
        putenv("$key=$value");
    }

    public static function getenv($key, $default = null)
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

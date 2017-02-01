<?php

namespace Rfussien\Dotenv;

class Parser
{
    /**
     * parsed content of the dotenv file
     */
    private $content = [];

    /**
     * Which parsing style is used
     *
     * @see http://php.net/parse_ini_file
     */
    private $scannerMode;

    /**
     * Set the default parsing style
     */
    public function __construct()
    {
        /**
         * INI_SCANNER_TYPED won't work on hhvm
         * @see https://github.com/facebook/hhvm/issues/5239
         */
        if (defined('HHVM_VERSION')) {
            $this->setScannerMode(\INI_SCANNER_NORMAL);
        } else {
            $this->setScannerMode(\INI_SCANNER_TYPED);
        }
    }

    public function setScannerMode($scannerMode)
    {
        $this->scannerMode = $scannerMode;
    }

    /**
     * parse the .env file
     *
     * @param string $file file to parse
     *
     * @return string Returns the phrase passed in
     */
    public function parse($file)
    {
        try {
            $this->content = parse_ini_file(
                $file,
                false,
                $this->scannerMode
            );
        } catch (\Exception $e) {
            throw new Exception\ParseException($e);
        }

        return $this;
    }

    public function sanitizeValues()
    {
        array_walk($this->content, function (&$value, $key) {
            // sanitize boolean values
            if (in_array($value, ['true', 'on', 'yes', 'false', 'off', 'no'])) {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        });

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
}

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

    /**
     * Set the scanner_mode used by the parse_ini_file function
     */
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

    /**
     * Transforme the boolean used as string in the env file to real boolean
     */
    public function sanitizeValues()
    {
        array_walk($this->content, function (&$value) {
            // sanitize boolean values
            if (in_array($value, ['true', 'on', 'yes', 'false', 'off', 'no'])) {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        });

        return $this;
    }

    /**
     * Return the parsed content
     *
     * @return array content
     */
    public function getContent()
    {
        return $this->content;
    }
}

<?php

namespace Rfussien\Dotenv;

class Parser
{
    private $content = [];

    /**
     * Friendly welcome
     *
     * @param string $phrase Phrase to return
     *
     * @return string Returns the phrase passed in
     */
    public function Parse($file)
    {
        try {
            $this->content = parse_ini_file(
                $file,
                false,
                INI_SCANNER_TYPED
            );
        } catch (\Exception $e) {
            throw new Exception\ParseException($e);
        }

        return $this->content;
    }
}

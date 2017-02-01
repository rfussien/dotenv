<?php

namespace Rfussien\Dotenv;

use PHPUnit\Framework\TestCase;
use Rfussien\Dotenv;
use Rfussien\Dotenv\Exception\ParseException;

class EnvTest extends TestCase
{
    protected function parse($file)
    {
        return (new Parser)->parse(__DIR__ . "/mocks/${file}");
    }

    public function test1Booleans()
    {
        $expectedBeforeSanitization = [
            'K01' => true,
            'K02' => true,
            'K03' => 'true',
            'K04' => true,
            'K05' => true,
            'K06' => 'on',
            'K07' => true,
            'K08' => true,
            'K09' => 'yes',
            'K10' => false,
            'K11' => false,
            'K12' => 'false',
            'K13' => false,
            'K14' => false,
            'K15' => 'off',
            'K16' => false,
            'K17' => false,
            'K18' => 'no',
        ];

        $expectedAfterSanitization = [
            'K01' => true,
            'K02' => true,
            'K03' => true,
            'K04' => true,
            'K05' => true,
            'K06' => true,
            'K07' => true,
            'K08' => true,
            'K09' => true,
            'K10' => false,
            'K11' => false,
            'K12' => false,
            'K13' => false,
            'K14' => false,
            'K15' => false,
            'K16' => false,
            'K17' => false,
            'K18' => false,
        ];

        $parsed = $this->parse('1_booleans.env');

        $this->assertSame($expectedBeforeSanitization, $parsed->getContent());

        $parsed->sanitizeValues();

        $this->assertSame($expectedAfterSanitization, $parsed->getContent());
    }

    public function test2Numbers()
    {
        $expected = [
            'K01' => 1,
            'K02' => 1.1,
        ];

        $parsed = $this->parse('2_numbers.env');

        $this->assertSame($expected, $parsed->getContent());
    }

    public function test3Strings()
    {
        $expected = [
            'K01' => 'value',
            'K02' => 'value',
            'K03' => 'VaLuE',
            'K04' => 'VaLuE',
            'K05' => 'value " value',
            'K06' => 'value "value" value',
            'K07' => "value 'value' value",
            'K08' => '',
            'K09' => 'value',
            'K10' => 'value',
            'K11' => '',
            'K12' => '',
        ];

        $parsed = $this->parse('3_strings.env');

        $this->assertSame($expected, $parsed->getContent());
    }

    public function test4Null()
    {
        $expected = [
            'K01' => null,
        ];

        $parsed = $this->parse('4_null.env');

        $this->assertSame($expected, $parsed->getContent());
    }

    public function test5EmptyFile()
    {
        $expected = [];

        $parsed = $this->parse('5_empty_file.env');

        $this->assertSame($expected, $parsed->getContent());

        $parsed = $this->parse('5b_empty_file.env');

        $this->assertSame($expected, $parsed->getContent());
    }

    /**
     * @expectedException Rfussien\Dotenv\Exception\ParseException
     */
    public function testInvalidKey()
    {
        $this->parse('fail_invalid_key.env');
    }

    /**
     * @expectedException Rfussien\Dotenv\Exception\ParseException
     */
    public function testMissingSingleQuote()
    {
        $this->parse('fail_missing_single_quote.env');
    }
}

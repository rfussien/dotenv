<?php

namespace Rfussien\Dotenv;

use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    public function testLoadAFile()
    {
        $loader = new Loader(__DIR__ . '/mocks/', '0_all.env');
        $loader->load();

        $expected = [
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
            'K19' => 1,
            'K20' => 1.1000000000000001,
            'K21' => 'value',
            'K22' => 'value',
            'K23' => 'VaLuE',
            'K24' => 'VaLuE',
            'K25' => 'value " value',
            'K26' => 'value "value" value',
            'K27' => 'value \'value\' value',
            'K28' => '',
            'K29' => 'value',
            'K30' => 'value',
            'K31' => '',
            'K32' => '',
            'K33' => null,
        ];

        $this->assertSame($expected, $_ENV);
        $this->assertEquals('value "value" value', $_SERVER['K26']);
    }

    /**
     * @expectedException LogicException
     */
    public function testCallingToEnvWithoutParseShouldRaiseAnExeption()
    {
        $loader = new Loader(__DIR__ . '/mocks/', '0_all.env');
        $loader->toEnv();
    }

    public function testParserShouldBeAnInstanceOfParser()
    {
        $loader = new Loader(__DIR__ . '/mocks/', '0_all.env');
        $loader->load();

        $this->assertInstanceOf(Parser::class, $loader->getParser());
    }

    public function testEnvIsRetrievedFromServer()
    {
        $loader = new Loader(__DIR__ . '/mocks/', '0_all.env');
        $loader->load();

        $_SERVER['ONLYINSERVER'] = 'value';

        $this->assertEquals('value', env('ONLYINSERVER'));
    }

    public function testEnvIsRetrievedFromPhpEnv()
    {
        $loader = new Loader(__DIR__ . '/mocks/', '0_all.env');
        $loader->load();

        putenv('ONLYINPHPENV=value');

        $this->assertEquals('value', env('ONLYINPHPENV'));
    }
}

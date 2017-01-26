<?php

namespace Rfussien\Dotenv;

use Rfussien\Dotenv;
use Rfussien\Dotenv\Exception\ParseException;

class EnvTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that true does in fact equal true
     */
    public function setUp()
    {
        $this->parser = new Parser;
    }

    public function testSimpleEnv()
    {
        $expected = array(
            'TK1' => 'value',
            'TK2' => 'value',
            'TK3' => 'value',
        );

        $env = $this->parser->Parse(__DIR__ . '/mocks/simple.env');
        $this->assertSame($expected, $env);
    }

    public function testDoubleQuotedEnv()
    {
        $expected = array(
            'TK1' => 'value',
            'TK2' => 'value " value',
            'TK3' => 'value "value" value',
            'TK6' => "value 'value' value",
            'TK8' => "",
            'TK9' => 'value',
        );

        $env = $this->parser->Parse(__DIR__ . '/mocks/double_quoted.env');
        $this->assertEquals($expected, $env);
    }

    public function testSingleQuotedEnv()
    {
        $expected = array(
            'TK1' => 'value',
            'TK8' => '',
            'TK9' => 'value',
        );

        $env = $this->parser->Parse(__DIR__ . '/mocks/single_quoted.env');
        $this->assertSame($expected, $env);
    }

    public function testBoolEnv()
    {
        $expected = array(
            'TK1' => true,
            'TK2' => false,
            'TK3' => true,
            'TK4' => false,
            'TK5' => true,
            'TK6' => false,
            'TK7' => true,
            'TK8' => false,
        );

        $env = $this->parser->Parse(__DIR__ . '/mocks/bool.env');
        $this->assertSame($expected, $env);
    }

    public function testNumbersEnv()
    {
        $expected = array(
            'TK1' => 1,
            'TK2' => 1.1,
            'TK3' => "33 33",
        );

        $env = $this->parser->Parse(__DIR__ . '/mocks/numbers.env');
        $this->assertSame($expected, $env);
    }

    public function testNullEnv()
    {
        $expected = array(
            'TK2' => null,
        );

        $env = $this->parser->Parse(__DIR__ . '/mocks/null.env');
        $this->assertSame($expected, $env);
    }

    public function testEmptyFileEnv()
    {
        $expected = array(
        );

        $env = $this->parser->Parse(__DIR__ . '/mocks/empty_file.env');
        $this->assertSame($expected, $env);
    }

    public function testFinalCase()
    {
        $expected = array(
            "TEST1"  => "value",
            "TEST2"  => "value",
            "TEST3"  => "value",
            "TEST4"  => "value",
            "TEST7"  => 'value "value" value',
            "TEST8"  => "value",
            "TEST10" => 1,
            "TEST11" => 1.1,
            "TEST12" => "33 33",
            "TEST13" => "33",
            "TEST14" => true,
            "TEST15" => false,
            "TEST16" => true,
            "TEST17" => false,
            "TEST18" => true,
            "TEST19" => false,
            "TEST20" => true,
            "TEST21" => false,
            "TEST22" => "true",
            "TEST23" => "YES",
            "TEST24" => 'NO',
            "TEST25" => "",
            "TEST26" => null,
            "TEST27" => "hello",
            "TEST29" => 1,
            "TEST30" => 2,
            "TEST34" => "foo",
            "TEST35" => "bar",
            "TEST37" => "foo",
            "TEST38" => 'bar',
            "TEST40" => true,
            "TEST41" => false,
            "TEST44" => null,
            'TEST47' => 'foo',
            'TEST53' => null,
            'TEST55' => null,
        );

        $env = $this->parser->Parse(__DIR__ . '/mocks/all_testcase.env');
        $this->assertEquals($expected, $env);
    }

    public function testOtherEnv()
    {
        $expected = array(
        );

        $env = $this->parser->Parse(__DIR__ . '/mocks/other.env');
        $this->assertSame($expected, $env);
    }

    /**
     * @expectedException Rfussien\Dotenv\Exception\ParseException
     */
    public function testInvalidKey()
    {
        $env = $this->parser->Parse(__DIR__ . '/mocks/fail_invalid_key.env');
    }

    /**
     * @expectedException Rfussien\Dotenv\Exception\ParseException
     */
    public function testMissingSingleQuote()
    {
        $env = $this->parser->Parse(__DIR__ . '/mocks/fail_missing_single_quote.env');
    }
}

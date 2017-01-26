<?php

namespace Rfussien\Dotenv;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->dotenv = Loader::load(__DIR__ . '/mocks/all_testcase.env');
    }

    public function testEnvReturnTheGoodValue()
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

        $this->assertSame($expected, $this->dotenv);
    }

    public function testEnvHelperFunction()
    {
        $this->assertEquals(env('TEST1'), 'value');
    }

    public function testEnvHelperFunctionReturnDefaultValue()
    {
        $this->assertEquals(env('IDONOTEXISTS', 'default'), 'default');
    }

    public function testEnvHelperFunctionReturnNullWhenItDoesNotExists()
    {
        $this->assertNull(env('IDONOTEXISTS'));
    }

    public function testEnvHelperFunctionDoesNotReturnValueWhenValueIsFalse()
    {
        $this->assertFalse(env('TEST15', 'default'));
    }

    public function testEnvHelperFunctionDoesNotReturnValueWhenValueIsNull()
    {
        $this->assertNull(env('TEST26', 'default'));
    }

    public function testEnvHelperFunctionReturnValueFromServerVariable()
    {
        unset($_ENV['TEST2']);

        $this->assertEquals(env('TEST2'), 'value');
    }
}

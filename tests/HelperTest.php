<?php

namespace Rfussien\Dotenv;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function setUp()
    {
        $loader = new Loader(__DIR__ . '/mocks/', '0_all.env');
        $loader->load();
    }

    public function testDefaultValueForEnvHelperFunction()
    {
        $this->assertEquals('value', env('K21'));
    }

    public function testTheEnvHelperCanReturnTheDefaultValue()
    {
        $this->assertEquals('default', env('ITDOESNTEXISTS', 'default'));
    }
}

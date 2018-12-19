<?php

namespace Modules\Yasna\Tests\Unit;

use Modules\Yasna\Services\YasnaTest;

class ExampleTest extends YasnaTest
{
    /**
     * Example!
     */
    public function testFolan()
    {
        $this->assertTrue(is_string(url_locale()));
    }



    /**
     * Example!
     */
    public function testExample()
    {
        $this->assertTrue(is_bool(false));
    }
}

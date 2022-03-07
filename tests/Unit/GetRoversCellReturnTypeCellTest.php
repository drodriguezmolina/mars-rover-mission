<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Map;

class GetRoversCellReturnTypeCellTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test()
    {
        $map = new Map();
        $map->create();
        $this->assertInstanceOf('App\Cell', $map->getRoversCell());
    }
}

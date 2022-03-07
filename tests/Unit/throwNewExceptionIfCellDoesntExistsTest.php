<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Map;

class throwNewExceptionIfCellDoesntExistsTest extends TestCase
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
        $this->expectExceptionMessage('Movement not valid this cell not exists!');
        $map->find('-1', '-1');
    }
}

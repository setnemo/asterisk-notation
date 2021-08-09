<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class GetTest
 */
class GetTest extends Unit
{
    /**
     * @dataProvider getWithStar()
     */
    public function testGet(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->get($example['keys']));
    }

    /**
     * @dataProvider getWithStar()
     */
    public function testGetOffset(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk[$example['keys']]);
    }

    public function getWithStar(): array
    {
        return [
  /* #0 */  [[
                'constructor' => ['1' => ['second' => 'value'],'2' => ['second' => 'value']],
                'expected' => ['1.second' => 'value', '2.second' => 'value',],
                'keys' => '*.second',
            ]],
  /* #1 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]],
                'expected' => ['1.first.value' => 42, '3.third.value' => 42,],
                'keys' => '*.*.value',
            ]],
  /* #2 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]],
                'expected' => 42,
                'keys' => '3.third.value',
            ]],
  /* #3 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'], ],
                'expected' => null,
                'keys' => '3.third.value',
            ]],
  /* #4 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'], ],
                'expected' => ['user1.name' => 'John', 'user2.name' => 'Robin'],
                'keys' => '*.name',
            ]],
  /* #5 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'], ],
                'expected' => null,
                'keys' => '*.spouse',
            ]],
        ];
    }
}

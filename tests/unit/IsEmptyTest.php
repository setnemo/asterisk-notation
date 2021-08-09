<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class IsEmptyTest
 */
class IsEmptyTest extends Unit
{
    /**
     * @dataProvider isEmptyTestWithStars()
     */
    public function testGet(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->isEmpty($example['keys']));
    }

    public function isEmptyTestWithStars(): array
    {
        return [
  /* #0 */  [[
                'constructor' => ['1' => ['second' => 'value'],'2' => ['second' => 'value']],
                'expected' => false,
                'keys' => '*.second',
            ]],
  /* #1 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]],
                'expected' => false,
                'keys' => '*.*.value',
            ]],
  /* #2 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]],
                'expected' => false,
                'keys' => '3.third.value',
            ]],
  /* #3 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'], ],
                'expected' => true,
                'keys' => '3.third.value',
            ]],
  /* #4 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'], ],
                'expected' => false,
                'keys' => '*.name',
            ]],
  /* #5 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'], ],
                'expected' => true,
                'keys' => '*.spouse',
            ]],
        ];
    }
}

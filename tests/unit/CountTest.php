<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class CountTest
 */
class CountTest extends Unit
{
    /**
     * @dataProvider countWithStar()
     */
    public function testCount(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->count($example['keys']));
    }

    public function countWithStar(): array
    {
        return [
  /* #0 */  [[
                'constructor' => ['1' => ['second' => 'value'],'2' => ['second' => 'value']],
                'expected' => 2,
                'keys' => '*.second',
            ]],
  /* #1 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]],
                'expected' => 2,
                'keys' => '*.*.value',
            ]],
  /* #2 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => [1,2,3,4,5]]]],
                'expected' => 5,
                'keys' => '3.third.value',
            ]],
  /* #3 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => [1,2,3,4,5]]]],
                'expected' => 3,
                'keys' => null,
            ]],
        ];
    }
}

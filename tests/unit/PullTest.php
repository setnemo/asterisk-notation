<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class PullTest
 */
class PullTest extends Unit
{
    /**
     * @dataProvider pullWithStar()
     */
    public function testGet(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected_pull'], $asterisk->pull($example['keys']));
        $this->assertEquals($example['expected_all'], $asterisk->all());
    }

    public function pullWithStar(): array
    {
        return [
  /* #0 */  [[
                'constructor' => ['1' => ['second' => 'value'],'2' => ['second' => 'value']],
                'expected_pull' => ['1.second' => 'value', '2.second' => 'value',],
                'expected_all' => ['1' => [], '2' => [], ],
                'keys' => '*.second',
            ]],
  /* #1 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]],
                'expected_pull' => ['1.first.value' => 42, '3.third.value' => 42,],
                'expected_all' => ['1' => ['first' => []], '2' => ['second' => 'value'], '3' => ['third' => []], ],
                'keys' => '*.*.value',
            ]],
  /* #2 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]],
                'expected_pull' => 42,
                'expected_all' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => []]],
                'keys' => '3.third.value',
            ]],
  /* #3 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'],],
                'expected_pull' => null,
                'expected_all' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'],],
                'keys' => '3.third.value',
            ]],
  /* #4 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'],],
                'expected_pull' => ['user1.name' => 'John', 'user2.name' => 'Robin'],
                'expected_all' => ['user1' => ['job' => 'warrior'], 'user2' => ['job' => 'archer'],],
                'keys' => '*.name',
            ]],
  /* #5 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'],],
                'expected_pull' => null,
                'expected_all' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'],],
                'keys' => '*.spouse',
            ]],
        ];
    }
}

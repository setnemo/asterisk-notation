<?php

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class PullTest
 * @package Tests\Unit
 */
class PullTest extends Unit
{
    /**
     * @dataProvider pullWithAsterisk()
     */
    public function testGet(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected_pull'], $asterisk->pull($example['key']));
        $this->assertEquals($example['expected_all'], $asterisk->all());
    }

    /**
     * @return \array[][]
     */
    public function pullWithAsterisk(): array
    {
        return [
            /* #0 */ [
                [
                    'constructor' => ['1' => ['second' => 'value'], '2' => ['second' => 'value']],
                    'expected_pull' => ['1.second' => 'value', '2.second' => 'value',],
                    'expected_all' => ['1' => [], '2' => [],],
                    'key' => '*.second',
                ]
            ],
            /* #1 */ [
                [
                    'constructor' => [
                        '1' => ['first' => ['value' => 42]],
                        '2' => ['second' => 'value'],
                        '3' => ['third' => ['value' => 42]]
                    ],
                    'expected_pull' => ['1.first.value' => 42, '3.third.value' => 42,],
                    'expected_all' => ['1' => ['first' => []], '2' => ['second' => 'value'], '3' => ['third' => []],],
                    'key' => '*.*.value',
                ]
            ],
            /* #2 */ [
                [
                    'constructor' => [
                        '1' => ['first' => ['value' => 42]],
                        '2' => ['second' => 'value'],
                        '3' => ['third' => ['value' => 42]]
                    ],
                    'expected_pull' => 42,
                    'expected_all' => [
                        '1' => ['first' => ['value' => 42]],
                        '2' => ['second' => 'value'],
                        '3' => ['third' => []]
                    ],
                    'key' => '3.third.value',
                ]
            ],
            /* #3 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected_pull' => null,
                    'expected_all' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'key' => '3.third.value',
                ]
            ],
            /* #4 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected_pull' => ['user1.name' => 'John', 'user2.name' => 'Robin'],
                    'expected_all' => ['user1' => ['job' => 'warrior'], 'user2' => ['job' => 'archer'],],
                    'key' => '*.name',
                ]
            ],
            /* #5 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected_pull' => null,
                    'expected_all' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'key' => '*.spouse',
                ]
            ],
        ];
    }
}

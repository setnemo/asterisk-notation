<?php

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class IsEmptyTest
 * @package Tests\Unit
 */
class IsEmptyTest extends Unit
{
    /**
     * @dataProvider isEmptyTestWithAsterisk()
     */
    public function testGet(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->isEmpty($example['key']));
    }

    /**
     * @return \array[][]
     */
    public function isEmptyTestWithAsterisk(): array
    {
        return [
            /* #0 */ [
                [
                    'constructor' => ['1' => ['second' => 'value'], '2' => ['second' => 'value']],
                    'expected' => false,
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
                    'expected' => false,
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
                    'expected' => false,
                    'key' => '3.third.value',
                ]
            ],
            /* #3 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected' => true,
                    'key' => '3.third.value',
                ]
            ],
            /* #4 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected' => false,
                    'key' => '*.name',
                ]
            ],
            /* #5 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected' => true,
                    'key' => '*.spouse',
                ]
            ],
        ];
    }
}

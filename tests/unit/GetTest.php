<?php

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class GetTest
 * @package Tests\Unit
 */
class GetTest extends Unit
{
    /**
     * @dataProvider getWithAsterisk()
     */
    public function testGet(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->get($example['key']));
    }

    /**
     * @dataProvider getWithAsterisk()
     */
    public function testGetOffset(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk[$example['key']]);
    }

    /**
     * @return \array[][]
     */
    public function getWithAsterisk(): array
    {
        return [
            /* #0 */ [
                [
                    'constructor' => ['1' => ['second' => 'value'], '2' => ['second' => 'value']],
                    'expected' => ['1.second' => 'value', '2.second' => 'value',],
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
                    'expected' => ['1.first.value' => 42, '3.third.value' => 42,],
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
                    'expected' => 42,
                    'key' => '3.third.value',
                ]
            ],
            /* #3 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected' => null,
                    'key' => '3.third.value',
                ]
            ],
            /* #4 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected' => ['user1.name' => 'John', 'user2.name' => 'Robin'],
                    'key' => '*.name',
                ]
            ],
            /* #5 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected' => null,
                    'key' => '*.spouse',
                ]
            ],
        ];
    }
}

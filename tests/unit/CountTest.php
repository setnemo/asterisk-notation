<?php

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class CountTest
 * @package Tests\Unit
 */
class CountTest extends Unit
{
    /**
     * @dataProvider countWithAsterisk()
     */
    public function testCount(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->count($example['key']));
    }

    /**
     * @return \array[][]
     */
    public function countWithAsterisk(): array
    {
        return [
            /* #0 */ [
                [
                    'constructor' => ['1' => ['second' => 'value'], '2' => ['second' => 'value']],
                    'expected' => 2,
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
                    'expected' => 2,
                    'key' => '*.*.value',
                ]
            ],
            /* #2 */ [
                [
                    'constructor' => [
                        '1' => ['first' => ['value' => 42]],
                        '2' => ['second' => 'value'],
                        '3' => ['third' => ['value' => [1, 2, 3, 4, 5]]]
                    ],
                    'expected' => 5,
                    'key' => '3.third.value',
                ]
            ],
            /* #3 */ [
                [
                    'constructor' => [
                        '1' => ['first' => ['value' => 42]],
                        '2' => ['second' => 'value'],
                        '3' => ['third' => ['value' => [1, 2, 3, 4, 5]]]
                    ],
                    'expected' => 3,
                    'key' => null,
                ]
            ],
        ];
    }
}

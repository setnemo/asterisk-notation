<?php

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class AddTest
 * @package Tests\Unit
 */
class AddTest extends Unit
{
    /**
     * @dataProvider addWithAsterisk()
     */
    public function testAdd(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk->add($example['key'], $example['value']);

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    /**
     * @return \array[][]
     */
    public function addWithAsterisk(): array
    {
        return [
            /* #0 */ [
                [
                    'constructor' => [],
                    'expected' => [
                        '*' => ['second' => 'VALUE'],
                    ],
                    'key' => '*.second',
                    'value' => 'VALUE'
                ]
            ],
            /* #1 */ [
                [
                    'constructor' => ['*' => ['second' => 'VALUE']],
                    'expected' => [
                        '*' => ['second' => 'VALUE'],
                    ],
                    'key' => '*.second',
                    'value' => 'value'
                ]
            ],
            /* #2 */ [
                [
                    'constructor' => ['*' => ['second' => 'value']],
                    'expected' => [
                        '*' => ['second' => 'value', '*' => '1'],
                    ],
                    'key' => '*.*',
                    'value' => '1'
                ]
            ],
            /* #3 */ [
                [
                    'constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0]],
                    'expected' => [
                        '*' => ['second' => 'value', '*' => '1'],
                        0 => [0 => 0]
                    ],
                    'key' => '*.*',
                    'value' => '1'
                ]
            ],
            /* #4 */ [
                [
                    'constructor' => [
                        '*' => ['second' => 'value'],
                        0 => [0 => 0],
                        11 => [11 => [11 => [11 => [11 => 11]]]]
                    ],
                    'expected' => [
                        '*' => ['second' => 'value', '*' => '1'],
                        0 => [0 => 0],
                        11 => [11 => [11 => [11 => [11 => 11]]]]
                    ],
                    'key' => '*.*',
                    'value' => '1'
                ]
            ],
            /* #5 */ [
                [
                    'constructor' => ['1' => ['second' => 'value'], '2' => ['second' => 'value']],
                    'expected' => [
                        '1' => ['second' => 'value'],
                        '2' => ['second' => 'value'],
                        '*' => ['second' => '1']
                    ],
                    'key' => '*.second',
                    'value' => '1'
                ]
            ],
            /* #6 */ [
                [
                    'constructor' => [1 => ['first' => 'value',], 2 => ['second' => 'value']],
                    'expected' => [
                        1 => ['first' => 'value', '*' => ['new' => 1]],
                        2 => ['second' => 'value', '*' => ['new' => 1]],
                    ],
                    'key' => ['1.*.new' => 1, '2.*.new' => 1],
                    'value' => null
                ]
            ],
        ];
    }
}

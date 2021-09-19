<?php

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class DeleteTest
 * @package Tests\Unit
 */
class DeleteTest extends Unit
{
    /**
     * @dataProvider deleteWithAsterisk()
     */
    public function testDelete(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk->delete($example['key']);

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    /**
     * @return \array[][]
     */
    public function deleteWithAsterisk(): array
    {
        return [
            /* #0 */
            [
                [
                    'constructor' => [],
                    'expected' => [],
                    'key' => '*.second'
                ],
            ],
            /* #1 */
            [
                [
                    'constructor' => ['*' => ['second' => 'VALUE']],
                    'expected' => [
                        '*' => [],
                    ],
                    'key' => '*.second',
                ]
            ],
            /* #2 */
            [
                [
                    'constructor' => ['*' => ['second' => 'value']],
                    'expected' => [
                        '*' => [],
                    ],
                    'key' => '*.*',
                ]
            ],
            /* #3 */
            [
                [
                    'constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0]],
                    'expected' => [
                        '*' => [],
                        0 => []
                    ],
                    'key' => '*.*',
                ]
            ],
            /* #4 */
            [
                [
                    'constructor' => [
                        '*' => ['second' => 'value'],
                        0 => [0 => 0],
                        11 => [11 => [11 => [11 => [11 => 11]]]]
                    ],
                    'expected' => [
                        '*' => [],
                        0 => [],
                        11 => []
                    ],
                    'key' => '*.*',
                ]
            ],
            /* #5 */
            [
                [
                    'constructor' => ['1' => ['second'], '2' => ['second' => 'value']],
                    'expected' => [
                        '1' => ['second'],
                        '2' => [],
                    ],
                    'key' => '*.second',
                ]
            ],
            /* #6 */
            [['constructor' => ['*' => ['second' => 'VALUE']], 'expected' => [], 'key' => '*',]],
            /* #7 */
            [['constructor' => ['second' => 'VALUE'], 'expected' => [], 'key' => '*',]],
            /* #8 */
            [['constructor' => [0, 'first', 'second',], 'expected' => [], 'key' => '*',]],
            /* #9 */
            [['constructor' => [0 => [0], 'first' => [], 'second' => [],], 'expected' => [], 'key' => '*',]],
            /* #10*/
            [
                [
                    'constructor' => [0 => [0], 'first' => [0], 'second' => [0],],
                    'expected' => [0 => [], 'first' => [], 'second' => []],
                    'key' => '*.*',
                ]
            ],
            /* #11*/
            [
                [
                    'constructor' => [
                        '*' => ['second' => 'value'],
                        0 => [11 => 0],
                        11 => [11 => [11 => [11 => [11 => 11]]]]
                    ],
                    'expected' => [
                        '*' => [],
                        0 => [11 => 0],
                        11 => [11 => []]
                    ],
                    'key' => ['*.second', '*.*.11']
                ]
            ],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class HasTest
 * @package Tests\Unit
 */
class HasTest extends Unit
{
    /**
     * @dataProvider hasWithAsterisk()
     */
    public function testHas(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->has($example['key']));
    }

    /**
     * @dataProvider hasWithAsteriskAndValue()
     */
    public function testHasEqual(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->has($example['key'], $example['value']));
    }

    /**
     * @dataProvider hasWithAsteriskAndValueNonStrict()
     */
    public function testHasEqualNonStrict(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->has($example['key'], $example['value'], false));
    }

    /**
     * @return \array[][]
     */
    public function hasWithAsterisk(): array
    {
        return [
            /* #0 */ [
                [
                    'constructor' => ['1' => ['second' => 'value'], '2' => ['second' => 'value']],
                    'expected' => true,
                    'key' => '*.second',
                ]
            ],
            /* #1 */ [
                [
                    'constructor' => [
                        '1' => ['first' => ['test' => 42]],
                        '2' => ['second' => 'value'],
                        '3' => ['third' => ['value' => 42]]
                    ],
                    'expected' => true,
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
                    'expected' => true,
                    'key' => '3.third.value',
                ]
            ],
            /* #3 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected' => false,
                    'key' => '3.third.value',
                ]
            ],
            /* #4 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected' => true,
                    'key' => '*.name',
                ]
            ],
            /* #5 */ [
                [
                    'constructor' => [
                        'user1' => ['name' => 'John', 'job' => 'warrior'],
                        'user2' => ['name' => 'Robin', 'job' => 'archer'],
                    ],
                    'expected' => false,
                    'key' => '*.spouse',
                ]
            ],
        ];
    }

    /**
     * @return \array[][]
     */
    public function hasWithAsteriskAndValue(): array
    {
        return [
            /* #0 */
            [['constructor' => [], 'expected' => false, 'key' => '*', 'value' => false]],
            /* #1 */
            [
                [
                    'constructor' => ['*' => ['second' => 'VALUE']],
                    'expected' => true,
                    'key' => '*.second',
                    'value' => 'VALUE'
                ]
            ],
            /* #2 */
            [
                [
                    'constructor' => ['*' => ['second' => 'VALUE']],
                    'expected' => false,
                    'key' => '*.second',
                    'value' => 'value'
                ]
            ],
            /* #3 */
            [['constructor' => ['*' => ['second' => 'value']], 'expected' => false, 'key' => '*.*', 'value' => '1']],
            /* #4 */
            [
                [
                    'constructor' => ['*' => ['second' => 'value']],
                    'expected' => true,
                    'key' => '*.*',
                    'value' => 'value'
                ]
            ],
            /* #5 */
            [
                [
                    'constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0]],
                    'expected' => false,
                    'key' => '*.*',
                    'value' => 'value'
                ]
            ],
            /* #6 */
            [
                [
                    'constructor' => ['*' => ['second' => 'value'], 0 => [0 => 'value']],
                    'expected' => true,
                    'key' => '*.*',
                    'value' => 'value'
                ]
            ],
            /* #7 */
            [
                [
                    'constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0], 11 => 11],
                    'expected' => true,
                    'key' => '*.11',
                    'value' => 11
                ]
            ],
            /* #8 */
            [
                [
                    'constructor' => ['*' => ['second' => 'value'], '00' => [0 => 0], 0 => [11 => [2]]],
                    'expected' => true,
                    'key' => '*.11',
                    'value' => [2]
                ]
            ],
            /* #9 */
            [
                [
                    'constructor' => ['1' => ['second' => 'value'], '2' => ['second' => '-']],
                    'expected' => false,
                    'key' => '*.second',
                    'value' => 'value'
                ]
            ],
            /* #10*/
            [
                [
                    'constructor' => ['1' => ['second' => 'value'], '2' => ['second' => 'value']],
                    'expected' => true,
                    'key' => '*.second',
                    'value' => 'value'
                ]
            ],
        ];
    }

    /**
     * @return \array[][]
     */
    public function hasWithAsteriskAndValueNonStrict(): array
    {
        $constructor = [
            'locations' => [
                'Europe' => [
                    'Ukraine' => [
                        'capital' => 'Kyiv',
                        'currency' => 'UAH'
                    ],
                    'Poland' => [
                        'capital' => 'Warsaw',
                        'currency' => 'PLN'
                    ],

                ],
                'Africa' => [
                    'South Africa' => [
                        'capital' => 'Capetown',
                        'currency' => 'ZAR'
                    ],
                    'Nigeria' => [
                        'capital' => 'Abuja',
                        'currency' => 'NGN'
                    ],
                ],
            ],
        ];

        return [
            /* #0 */
            [['constructor' => $constructor, 'expected' => true, 'key' => 'locations.*.*.capital', 'value' => 'Kyiv']],
            /* #1 */
            [['constructor' => $constructor, 'expected' => true, 'key' => 'locations.*.*.currency', 'value' => 'ZAR']],
            /* #2 */
            [
                [
                    'constructor' => $constructor,
                    'expected' => false,
                    'key' => 'locations.Europe.*.currency',
                    'value' => 'ZAR'
                ]
            ],
            /* #3 */
            [
                [
                    'constructor' => $constructor,
                    'expected' => true,
                    'key' => ['locations.Africa.South Africa.currency', 'locations.Africa.*.currency',],
                    'value' => 'ZAR'
                ]
            ],
        ];
    }
}

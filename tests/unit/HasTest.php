<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class HasTest
 */
class HasTest extends Unit
{
    /**
     * @dataProvider hasWithStar()
     */
    public function testHas(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->has($example['keys']));
    }

    /**
     * @dataProvider hasWithStarAndValue()
     */
    public function testHasEqual(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->has($example['keys'], $example['value']));
    }

    /**
     * @dataProvider hasWithStarAndValueNonStrict()
     */
    public function testHasEqualNonStrict(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);

        $this->assertEquals($example['expected'], $asterisk->has($example['keys'], $example['value'], false));
    }

    public function hasWithStar(): array
    {
        return [
  /* #0 */  [[
                'constructor' => ['1' => ['second' => 'value'],'2' => ['second' => 'value']],
                'expected' => true,
                'keys' => '*.second',
            ]],
  /* #1 */  [[
                'constructor' => ['1' => ['first' => ['test' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]],
                'expected' => true,
                'keys' => '*.*.value',
            ]],
  /* #2 */  [[
                'constructor' => ['1' => ['first' => ['value' => 42]],'2' => ['second' => 'value'],'3' => ['third' => ['value' => 42]]],
                'expected' => true,
                'keys' => '3.third.value',
            ]],
  /* #3 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'], ],
                'expected' => false,
                'keys' => '3.third.value',
            ]],
  /* #4 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'], ],
                'expected' => true,
                'keys' => '*.name',
            ]],
  /* #5 */  [[
                'constructor' => ['user1' => ['name' => 'John', 'job' => 'warrior'], 'user2' => ['name' => 'Robin', 'job' => 'archer'], ],
                'expected' => false,
                'keys' => '*.spouse',
            ]],
        ];
    }

    public function hasWithStarAndValue(): array
    {
        return [
  /* #0 */  [['constructor' => [], 'expected' => false, 'keys' => '*', 'value' => false]],
  /* #1 */  [['constructor' => ['*' => ['second' => 'VALUE']], 'expected' => true, 'keys' => '*.second', 'value' => 'VALUE']],
  /* #2 */  [['constructor' => ['*' => ['second' => 'VALUE']], 'expected' => false, 'keys' => '*.second', 'value' => 'value']],
  /* #3 */  [['constructor' => ['*' => ['second' => 'value']], 'expected' => false, 'keys' => '*.*', 'value' => '1']],
  /* #4 */  [['constructor' => ['*' => ['second' => 'value']], 'expected' => true, 'keys' => '*.*', 'value' => 'value']],
  /* #5 */  [['constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0]], 'expected' => false, 'keys' => '*.*', 'value' => 'value']],
  /* #6 */  [['constructor' => ['*' => ['second' => 'value'], 0 => [0 => 'value']], 'expected' => true, 'keys' => '*.*', 'value' => 'value']],
  /* #7 */  [['constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0], 11 => 11], 'expected' => true, 'keys' => '*.11', 'value' => 11]],
  /* #8 */  [['constructor' => ['*' => ['second' => 'value'], '00' => [0 => 0], 0 => [11 => [2]]], 'expected' => true, 'keys' => '*.11', 'value' => [2]]],
  /* #9 */  [['constructor' => ['1' => ['second' => 'value'],'2' => ['second' => '-']], 'expected' => false, 'keys' => '*.second', 'value' => 'value']],
  /* #10*/  [['constructor' => ['1' => ['second' => 'value'],'2' => ['second' => 'value']], 'expected' => true, 'keys' => '*.second', 'value' => 'value']],
        ];
    }

    public function hasWithStarAndValueNonStrict(): array
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
  /* #0 */  [['constructor' => $constructor, 'expected' => true, 'keys' => 'locations.*.*.capital', 'value' => 'Kyiv']],
  /* #1 */  [['constructor' => $constructor, 'expected' => true, 'keys' => 'locations.*.*.currency', 'value' => 'ZAR']],
  /* #2 */  [['constructor' => $constructor, 'expected' => false, 'keys' => 'locations.Europe.*.currency', 'value' => 'ZAR']],
  /* #3 */  [['constructor' => $constructor, 'expected' => true, 'keys' => ['locations.Africa.South Africa.currency', 'locations.Africa.*.currency', ], 'value' => 'ZAR']],
        ];
    }
}

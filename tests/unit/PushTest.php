<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class PushTest
 */
class PushTest extends Unit
{
    /**
     * @dataProvider pushWithStar()
     */
    public function testSet(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk->push($example['keys'], $example['value']);

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    public function pushWithStar(): array
    {
        return [
  /* #0 */  [['constructor' => [], 'expected' => [
                '*' => ['second' => ['VALUE']],
            ], 'keys' => '*.second', 'value' => 'VALUE']],
  /* #1 */  [['constructor' => [
                'first_one' => ['second' => 'value'],
                'first_two' => ['second' => 'value']
            ], 'expected' => [
                'first_one' => ['second' => ['value','VALUE']],
                'first_two' => ['second' => ['value','VALUE']]
            ], 'keys' => '*.second', 'value' => 'VALUE']],
  /* #2 */  [['constructor' => [
                'first_one' => ['second2' => 'value'],
                'first_two' => ['second' => 'value']
            ], 'expected' => [
                'first_one' => ['second2' => 'value', 'second' => ['VALUE']],
                'first_two' => ['second' => ['value','VALUE']]
            ], 'keys' => '*.second', 'value' => 'VALUE']],
  /* #3 */  [['constructor' => [
                'first_one' => ['second' => [
                    'third_one' => ['fourth' => ['value']],
                    'third_two' => ['fourth' => ['value']],
                ], 'second2' => [
                    'third_one' => ['fourth' => 'value'],
                    'third_two' => ['fourth' => 'value'],
                ],
                ],
                'first_two' => ['second' => [
                    'third_one' => [],
                    'third_two' => ['fourth' => 'value'],
                ], 'second2' => [
                    'third_one' => ['fourth2' => 'value'],
                ],
                ],
            ], 'expected' => [
                'first_one' => ['second' => [
                    'third_one' => ['fourth' => ['value','VALUE']],
                    'third_two' => ['fourth' => ['value','VALUE']],
                ], 'second2' => [
                    'third_one' => ['fourth' => 'value'],
                    'third_two' => ['fourth' => 'value'],
                ],
                ],
                'first_two' => ['second' => [
                    'third_one' => [],
                    'third_two' => ['fourth' => ['value','VALUE']],
                ], 'second2' => [
                    'third_one' => ['fourth2' => 'value'],
                ],
                ],
            ], 'keys' => '*.second.*.fourth', 'value' => 'VALUE']],
        ];
    }
}

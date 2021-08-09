<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class SetTest
 */
class SetTest extends Unit
{
    /**
     * @dataProvider setWithStar()
     */
    public function testSet(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk->set($example['keys'], $example['value']);

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    /**
     * @dataProvider setWithStar()
     */
    public function testOffset(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk[$example['keys']] = $example['value'];

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    public function setWithStar(): array
    {
        return [
  /* #0 */  [['constructor' => [], 'expected' => [
                '*' => ['second' => 'VALUE'],
            ], 'keys' => '*.second', 'value' => 'VALUE']],
  /* #1 */  [['constructor' => [
                'first_one' => ['second' => 'value'],
                'first_two' => ['second' => 'value']
            ], 'expected' => [
                'first_one' => ['second' => 'VALUE'],
                'first_two' => ['second' => 'VALUE']
            ], 'keys' => '*.second', 'value' => 'VALUE']],
  /* #2 */  [['constructor' => [
                'first_one' => ['second2' => 'value'],
                'first_two' => ['second' => 'value']
            ], 'expected' => [
                'first_one' => ['second2' => 'value', 'second' => 'VALUE'],
                'first_two' => ['second' => 'VALUE']
            ], 'keys' => '*.second', 'value' => 'VALUE']],
  /* #3 */  [['constructor' => [
                'first_one' => ['second' => [
                    'third_one' => ['fourth' => 'value'],
                    'third_two' => ['fourth' => 'value'],
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
                    'third_one' => ['fourth' => 'VALUE'], // updated
                    'third_two' => ['fourth' => 'VALUE'], // updated
                ], 'second2' => [                         // without update
                    'third_one' => ['fourth' => 'value'],
                    'third_two' => ['fourth' => 'value'],
                ],
                ],
                'first_two' => ['second' => [
                    'third_one' => [],
                    'third_two' => ['fourth' => 'VALUE'], // updated
                ], 'second2' => [
                    'third_one' => ['fourth2' => 'value'],
                ],
                ],
            ], 'keys' => '*.second.*.fourth', 'value' => 'VALUE']],
        ];
    }
}

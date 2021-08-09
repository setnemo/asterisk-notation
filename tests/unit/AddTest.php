<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class AddTest
 */
class AddTest extends Unit
{
    /**
     * @dataProvider addWithStar()
     */
    public function testAdd(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk->add($example['keys'], $example['value']);

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    public function addWithStar(): array
    {
        return [
  /* #0 */  [['constructor' => [], 'expected' => [
                '*' => ['second' => 'VALUE'],
            ], 'keys' => '*.second', 'value' => 'VALUE']],
  /* #1 */  [['constructor' => ['*' => ['second' => 'VALUE']], 'expected' => [
                '*' => ['second' => 'VALUE'],
            ], 'keys' => '*.second', 'value' => 'value']],
  /* #2 */  [['constructor' => ['*' => ['second' => 'value']], 'expected' => [
                '*' => ['second' => 'value', '*' => '1'],
            ], 'keys' => '*.*', 'value' => '1']],
  /* #3 */  [['constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0]], 'expected' => [
                '*' => ['second' => 'value', '*' => '1'], 0 => [0 => 0]
            ], 'keys' => '*.*', 'value' => '1']],
  /* #4 */  [['constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0], 11 => [11 => [11 => [11 => [11 => 11]]]]], 'expected' => [
                '*' => ['second' => 'value', '*' => '1'], 0 => [0 => 0], 11 => [11 => [11 => [11 => [11 => 11]]]]
            ], 'keys' => '*.*', 'value' => '1']],
  /* #5 */  [['constructor' => ['1' => ['second' => 'value'],'2' => ['second' => 'value']], 'expected' => [
                '1' => ['second' => 'value'],'2' => ['second' => 'value'], '*' => ['second' => '1']
            ], 'keys' => '*.second', 'value' => '1']],
  /* #6 */  [['constructor' => [1 => ['first' => 'value',],2 => ['second' => 'value']], 'expected' => [
                1 => ['first' => 'value', '*' => ['new' => 1]],2 => ['second' => 'value', '*' => ['new' => 1]],
            ], 'keys' => ['1.*.new' => 1, '2.*.new' => 1], 'value' => null]],
        ];
    }
}

<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class DeleteTest
 */
class DeleteTest extends Unit
{
    /**
     * @dataProvider deleteWithStar()
     */
    public function testDelete(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk->delete($example['keys']);

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    public function deleteWithStar(): array
    {
        return [
  /* #0 */  [['constructor' => [],
             'expected' => [],
             'keys' => '*.second']],
  /* #1 */  [['constructor' => ['*' => ['second' => 'VALUE']], 'expected' => [
                '*' => [],
            ], 'keys' => '*.second',]],
  /* #2 */  [['constructor' => ['*' => ['second' => 'value']], 'expected' => [
                '*' => [],
            ], 'keys' => '*.*',]],
  /* #3 */  [['constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0]], 'expected' => [
                '*' => [], 0 => []
            ], 'keys' => '*.*',]],
  /* #4 */  [['constructor' => ['*' => ['second' => 'value'], 0 => [0 => 0], 11 => [11 => [11 => [11 => [11 => 11]]]]], 'expected' => [
                '*' => [], 0 => [], 11 => []
            ], 'keys' => '*.*',]],
  /* #5 */  [['constructor' => ['1' => ['second'],'2' => ['second' => 'value']], 'expected' => [
                '1' => ['second'],'2' => [],
            ], 'keys' => '*.second',]],
  /* #6 */  [['constructor' => ['*' => ['second' => 'VALUE']], 'expected' => [], 'keys' => '*',]],
  /* #7 */  [['constructor' => ['second' => 'VALUE'], 'expected' => [], 'keys' => '*',]],
  /* #8 */  [['constructor' => [0, 'first','second',], 'expected' => [], 'keys' => '*',]],
  /* #9 */  [['constructor' => [0 => [0], 'first' => [],'second' => [],], 'expected' => [], 'keys' => '*',]],
  /* #10*/  [['constructor' => [0 => [0], 'first' => [0],'second' => [0],], 'expected' => [0 => [], 'first' => [],'second' => []], 'keys' => '*.*',]],
  /* #11*/  [['constructor' => ['*' => ['second' => 'value'], 0 => [11 => 0], 11 => [11 => [11 => [11 => [11 => 11]]]]], 'expected' => [
                '*' => [], 0 => [11 => 0], 11 => [11 => []]
            ], 'keys' => ['*.second','*.*.11']]],
        ];
    }
}

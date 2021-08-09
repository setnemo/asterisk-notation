<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class ClearTest
 */
class ClearTest extends Unit
{
    /**
     * @dataProvider clearWithStar()
     */
    public function testClear(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk->clear($example['keys']);

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    public function clearWithStar(): array
    {
        return [
            [['constructor' => [
                'first_one' => ['second' => 'value'],
                'first_two' => ['second' => 'value']
            ], 'expected' => [
                'first_one' => ['second' => []],
                'first_two' => ['second' => []]
            ], 'keys' => '*.second']],
            [['constructor' => [
                'first_one' => ['second' => 'value'],
                'first_two' => ['second' => 'value']
            ], 'expected' => [
                'first_one' => ['second' => []],
                'first_two' => ['second' => []]
            ], 'keys' => '*.second']],
            [['constructor' => [
                'first_one' => ['second' => ['third' => 'value']],
                'first_two' => ['second' => []]
            ], 'expected' => [
                'first_one' => ['second' => []],
                'first_two' => ['second' => []]
            ], 'keys' => '*.*']],
            [['constructor' => [
                'first_one' => ['second2' => 'value'],
                'first_two' => ['second' => 'value']
            ], 'expected' => [
                'first_one' => ['second2' => []],
                'first_two' => ['second' => 'value',]
            ], 'keys' => '*.second2']],
            [['constructor' => [
                'first_one' => ['second2' => 'value'],
                'first_two' => ['second' => 'value']
            ], 'expected' => [], 'keys' => null]],
        ];
    }
}

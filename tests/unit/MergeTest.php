<?php

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class MergeTest
 * @package Tests\Unit
 */
class MergeTest extends Unit
{
    /**
     * @dataProvider setWithAsterisk()
     */
    public function testMerge(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk->merge($example['key'], $example['value']);

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    /**
     * @return \array[][]
     */
    public function setWithAsterisk(): array
    {
        return [
            /* #0 */ [
                [
                    'constructor' => [],
                    'expected' => [
                        '*' => ['second' => ['value']],
                    ],
                    'key' => '*.second',
                    'value' => 'value'
                ],
            ],
            /* #1 */ [
                [
                    'constructor' => ['example1'],
                    'expected' => [
                        'example1','example2',
                    ],
                    'key' => new Asterisk(['example2']),
                    'value' => null,
                ],
            ],
            /* #2 */ [
                [
                    'constructor' => [],
                    'expected' => [
                        'test' => 'test',
                    ],
                    'key' => ['test' => 'test'],
                    'value' => null,
                ],
            ],
        ];
    }
}

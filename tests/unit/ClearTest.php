<?php

declare(strict_types=1);

namespace Tests\Unit;

use Codeception\Test\Unit;
use Setnemo\Asterisk;

/**
 * Class ClearTest
 * @package Tests\Unit
 */
class ClearTest extends Unit
{
    /**
     * @dataProvider clearWithAsterisk()
     */
    public function testClear(array $example): void
    {
        $asterisk = new Asterisk($example['constructor']);
        $asterisk->clear($example['key']);

        $this->assertEquals($example['expected'], $asterisk->all());
    }

    public function clearWithAsterisk(): array
    {
        return [
            [
                [
                    'constructor' => [
                        'first_one' => ['second' => 'value'],
                        'first_two' => ['second' => 'value']
                    ],
                    'expected' => [
                        'first_one' => ['second' => []],
                        'first_two' => ['second' => []]
                    ],
                    'key' => '*.second'
                ]
            ],
            [
                [
                    'constructor' => [
                        'first_one' => ['second' => 'value'],
                        'first_two' => ['second' => 'value']
                    ],
                    'expected' => [
                        'first_one' => ['second' => []],
                        'first_two' => ['second' => []]
                    ],
                    'key' => '*.second'
                ]
            ],
            [
                [
                    'constructor' => [
                        'first_one' => ['second' => ['third' => 'value']],
                        'first_two' => ['second' => []]
                    ],
                    'expected' => [
                        'first_one' => ['second' => []],
                        'first_two' => ['second' => []]
                    ],
                    'key' => '*.*'
                ]
            ],
            [
                [
                    'constructor' => [
                        'first_one' => ['second2' => 'value'],
                        'first_two' => ['second' => 'value']
                    ],
                    'expected' => [
                        'first_one' => ['second2' => []],
                        'first_two' => ['second' => 'value',]
                    ],
                    'key' => '*.second2'
                ]
            ],
            [
                [
                    'constructor' => [
                        'first_one' => ['second2' => 'value'],
                        'first_two' => ['second' => 'value']
                    ],
                    'expected' => [],
                    'key' => null
                ]
            ],
        ];
    }
}

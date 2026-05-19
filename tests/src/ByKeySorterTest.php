<?php

namespace Jmf\Sort;

use Override;
use PHPUnit\Framework\TestCase;

class ByKeySorterTest extends TestCase
{
    private ByKeySorter $byKeySorter;

    #[Override]
    protected function setUp(): void
    {
        $this->byKeySorter = new ByKeySorter();
    }

    public function testSortWithEmptyArray(): void
    {
        $input = [];

        $result = $this->byKeySorter->sort(
            $input,
        );

        $this->assertSame([], $result);
    }

    public function testSortWithOneItem(): void
    {
        $input = [
            'foo' => 'baz',
        ];

        $result = $this->byKeySorter->sort(
            $input,
        );

        $this->assertSame($input, $result);
    }

    public function testSortWithMultipleItems(): void
    {
        $input = [
            'bar' => 'abc',
            'foo' => 'def',
            'baz' => 'ghi',
        ];

        $result = $this->byKeySorter->sort(
            $input,
        );

        $this->assertSame(
            [
                'bar' => 'abc',
                'baz' => 'ghi',
                'foo' => 'def',
            ],
            $result,
        );
    }

    public function testSortDescendingWithMultipleItems(): void
    {
        $input = [
            'bar' => 'abc',
            'foo' => 'def',
            'baz' => 'ghi',
        ];

        $result = $this->byKeySorter->sort(
            $input,
            Direction::DESC,
        );

        $this->assertSame(
            [
                'foo' => 'def',
                'baz' => 'ghi',
                'bar' => 'abc',
            ],
            $result,
        );
    }
}

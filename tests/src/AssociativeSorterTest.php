<?php

namespace Jmf\Sort;

use Override;
use PHPUnit\Framework\TestCase;

class AssociativeSorterTest extends TestCase
{
    private AssociativeSorter $associativeSorter;

    #[Override]
    protected function setUp(): void
    {
        $this->associativeSorter = new AssociativeSorter();
    }

    public function testSortWithEmptyArray(): void
    {
        $input = [];

        $result = $this->associativeSorter->sort(
            $input,
        );

        $this->assertSame([], $result);
    }

    public function testSortWithOneItem(): void
    {
        $input = [
            'foo' => 'baz',
        ];

        $result = $this->associativeSorter->sort(
            $input,
        );

        $this->assertSame($input, $result);
    }

    public function testSortWithMultipleItems(): void
    {
        $input = [
            'foo' => 'def',
            'bar' => 'abc',
            'baz' => 'ghi',
        ];

        $result = $this->associativeSorter->sort(
            $input,
        );

        $this->assertSame(
            [
                'bar' => 'abc',
                'foo' => 'def',
                'baz' => 'ghi',
            ],
            $result,
        );
    }

    public function testSortDescendingWithMultipleItems(): void
    {
        $input = [
            'foo' => 'def',
            'bar' => 'abc',
            'baz' => 'ghi',
        ];

        $result = $this->associativeSorter->sort(
            $input,
            Direction::DESC,
        );

        $this->assertSame(
            [
                'baz' => 'ghi',
                'foo' => 'def',
                'bar' => 'abc',
            ],
            $result,
        );
    }
}

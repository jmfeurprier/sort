<?php

namespace Jmf\Sort;

use Override;
use PHPUnit\Framework\TestCase;

class ByValueSorterTest extends TestCase
{
    private ByValueSorter $byValueSorter;

    #[Override]
    protected function setUp(): void
    {
        $this->byValueSorter = new ByValueSorter();
    }

    public function testSortWithEmptyArray(): void
    {
        $input = [];

        $result = $this->byValueSorter->sort(
            $input,
        );

        $this->assertSame([], $result);
    }

    public function testSortWithOneItem(): void
    {
        $input = [
            'foo',
        ];

        $result = $this->byValueSorter->sort(
            $input,
        );

        $this->assertSame($input, $result);
    }

    public function testSortWithMultipleItems(): void
    {
        $input = [
            'def',
            'abc',
            'ghi',
        ];

        $result = $this->byValueSorter->sort(
            $input,
        );

        $this->assertSame(
            [
                'abc',
                'def',
                'ghi',
            ],
            $result,
        );
    }

    public function testSortDescendingWithMultipleItems(): void
    {
        $input = [
            'def',
            'abc',
            'ghi',
        ];

        $result = $this->byValueSorter->sort(
            $input,
            Direction::DESC,
        );

        $this->assertSame(
            [
                'ghi',
                'def',
                'abc',
            ],
            $result,
        );
    }
}

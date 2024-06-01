<?php

namespace Jmf\Sort;

use Override;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class ByPropertySorterTest extends TestCase
{
    private ByPropertySorter $byPropertySorter;

    #[Override]
    protected function setUp(): void
    {
        $this->byPropertySorter = new ByPropertySorter(
            new PropertyAccessor(),
            new AssociativeSorter(),
        );
    }

    public function testSortWithEmptyArray(): void
    {
        $input = [];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::asc(
                    'foo',
                ),
            ]
        );

        $this->assertSame([], $result);
    }

    public function testSortWithOneItem(): void
    {
        $input = [
            ['foo' => 'bar'],
        ];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::asc(
                    '[foo]',
                ),
            ]
        );

        $this->assertSame($input, $result);
    }

    public function testSortWithMultipleItems(): void
    {
        $input = [
            ['foo' => 'def'],
            ['foo' => 'abc'],
            ['foo' => 'ghi'],
        ];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::asc(
                    '[foo]',
                ),
            ]
        );

        $this->assertSame(
            [
                1 => ['foo' => 'abc'],
                0 => ['foo' => 'def'],
                2 => ['foo' => 'ghi'],
            ],
            $result,
        );
    }

    public function testSortDescendingWithMultipleItems(): void
    {
        $input = [
            ['foo' => 'def'],
            ['foo' => 'abc'],
            ['foo' => 'ghi'],
        ];

        $result = $this->byPropertySorter->sort(
            $input,
            [
                PropertyPass::desc(
                    '[foo]',
                ),
            ]
        );

        $this->assertSame(
            [
                2 => ['foo' => 'ghi'],
                0 => ['foo' => 'def'],
                1 => ['foo' => 'abc'],
            ],
            $result,
        );
    }
}

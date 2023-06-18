<?php

/**
 * Copyright (c) 2013-2023 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Test\Unit\Builder;

use PHPUnit\Framework;
use Tree\Builder\NodeBuilder;
use Tree\Node\Node;

/**
 * @internal
 *
 * @covers \Tree\Builder\NodeBuilder
 */
final class NodeBuilderTest extends Framework\TestCase
{
    public function testConstructorCreatesEmptyNodeIfNoSpecified(): void
    {
        $builder = new NodeBuilder();

        self::assertNull($builder->getNode()->getValue());
    }

    public function testConstructor(): void
    {
        $builder = new NodeBuilder($node = new Node('node'));

        self::assertSame($node, $builder->getNode());
    }

    public function testSetNodeAndGetNode(): void
    {
        $builder = new NodeBuilder();

        $builder->setNode($node1 = new Node('node1'));
        self::assertSame($node1, $builder->getNode());

        $builder->setNode($node2 = new Node('node2'));
        self::assertSame($node2, $builder->getNode());
    }

    public function testGetNodeThrowsLogicExceptionWhenNodeBuilderDoesNotManageAnyNodes(): void
    {
        $builder = new NodeBuilder();

        $builder->end();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('The node builder currently does not manage any nodes.');

        $builder->getNode();
    }

    public function testLeaf(): void
    {
        $builder = new NodeBuilder();

        $builder->leaf('a')->leaf('b');

        $children = $builder->getNode()->getChildren();

        self::assertSame('a', $children[0]->getValue());
        self::assertSame('b', $children[1]->getValue());
    }

    public function testLeafs(): void
    {
        $builder = new NodeBuilder();

        $builder->leafs('a', 'b');

        $children = $builder->getNode()->getChildren();

        self::assertSame('a', $children[0]->getValue());
        self::assertSame('b', $children[1]->getValue());
    }

    public function testTreeAddNewNodeAsChildOfTheParentNode(): void
    {
        $builder = new NodeBuilder();

        $builder
            ->value('root')
            ->tree('a')
            ->tree('b')->end()
            ->leaf('c')
            ->end();

        $node = $builder->getNode();
        self::assertSame(['a'], $this->childrenValues($node->getChildren()));

        $subtree = $node->getChildren()[0];
        self::assertSame(['b', 'c'], $this->childrenValues($subtree->getChildren()));
    }

    public function testTree(): void
    {
        $builder = new NodeBuilder();

        $builder->tree('a')->tree('b');

        self::assertSame('b', $builder->getNode()->getValue());
    }

    public function testEnd(): void
    {
        $builder = new NodeBuilder();

        $builder
            ->value('root')
            ->tree('a')
            ->tree('b')
            ->tree('c')
            ->end();

        self::assertSame('b', $builder->getNode()->getValue());

        $builder->end();
        self::assertSame('a', $builder->getNode()->getValue());

        $builder->end();
        self::assertSame('root', $builder->getNode()->getValue());
    }

    public function testValue(): void
    {
        $builder = new NodeBuilder();

        $builder->value('foo')->value('bar');

        self::assertSame('bar', $builder->getNode()->getValue());
    }

    public function testNodeInstanceByValue(): void
    {
        $builder = new NodeBuilder();

        $node = $builder->nodeInstanceByValue('baz');

        self::assertSame('baz', $node->getValue());
        self::assertInstanceOf('Tree\Node\Node', $node);
    }

    /**
     * @param array[Node] $children
     *
     * @return array
     */
    private function childrenValues(array $children)
    {
        return \array_map(static function (Node $node) {
            return $node->getValue();
        }, $children);
    }
}

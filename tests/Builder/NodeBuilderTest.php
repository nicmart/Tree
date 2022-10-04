<?php

/**
 * Copyright (c) 2013-2022 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Test\Builder;

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
    /**
     * @var NodeBuilder
     */
    protected $builder;

    protected function setUp()
    {
        $this->builder = new NodeBuilder();
    }

    public function testConstructorCreatesEmptyNodeIfNoSpecified()
    {
        $builder = new NodeBuilder();

        self::assertNull($builder->getNode()->getValue());
    }

    public function testConstructor()
    {
        $builder = new NodeBuilder($node = new Node('node'));

        self::assertSame($node, $builder->getNode());
    }

    public function testSetNodeAndGetNode()
    {
        $this->builder->setNode($node1 = new Node('node1'));
        self::assertSame($node1, $this->builder->getNode());

        $this->builder->setNode($node2 = new Node('node2'));
        self::assertSame($node2, $this->builder->getNode());
    }

    public function testLeaf()
    {
        $this->builder->leaf('a')->leaf('b');

        $children = $this->builder->getNode()->getChildren();

        self::assertSame('a', $children[0]->getValue());
        self::assertSame('b', $children[1]->getValue());
    }

    public function testLeafs()
    {
        $this->builder->leafs('a', 'b');

        $children = $this->builder->getNode()->getChildren();

        self::assertSame('a', $children[0]->getValue());
        self::assertSame('b', $children[1]->getValue());
    }

    public function testTreeAddNewNodeAsChildOfTheParentNode()
    {
        $this->builder
            ->value('root')
            ->tree('a')
            ->tree('b')->end()
            ->leaf('c')
            ->end();

        $node = $this->builder->getNode();
        self::assertSame(['a'], $this->childrenValues($node->getChildren()));

        $subtree = $node->getChildren()[0];
        self::assertSame(['b', 'c'], $this->childrenValues($subtree->getChildren()));
    }

    public function testTree()
    {
        $this->builder->tree('a')->tree('b');

        self::assertSame('b', $this->builder->getNode()->getValue());
    }

    public function testEnd()
    {
        $this->builder
            ->value('root')
            ->tree('a')
            ->tree('b')
            ->tree('c')
            ->end();

        self::assertSame('b', $this->builder->getNode()->getValue());

        $this->builder->end();
        self::assertSame('a', $this->builder->getNode()->getValue());

        $this->builder->end();
        self::assertSame('root', $this->builder->getNode()->getValue());
    }

    public function testValue()
    {
        $this->builder->value('foo')->value('bar');

        self::assertSame('bar', $this->builder->getNode()->getValue());
    }

    public function testNodeInstanceByValue()
    {
        $node = $this->builder->nodeInstanceByValue('baz');

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

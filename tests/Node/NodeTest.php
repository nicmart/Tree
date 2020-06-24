<?php

/**
 * Copyright (c) 2013-2020 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Test\Tree;

use PHPUnit\Framework;
use Tree\Node\Node;

/**
 * @internal
 *
 * @covers \Tree\Node\Node
 */
final class NodeTest extends Framework\TestCase
{
    public function testSetValue()
    {
        $node = new Node();

        $node->setValue('string value');

        self::assertSame('string value', $node->getValue());

        $node->setValue($object = new \stdClass());
        $object->foo = 'bar';

        self::assertSame($object, $node->getValue());
    }

    public function testAddAndGetChildren()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'));

        self::assertSame([$child1, $child2, $child3], $root->getChildren());
    }

    public function testAddChildSetParent()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'));

        self::assertSame($root, $child1->getParent());
        self::assertSame($root, $child2->getParent());
    }

    public function testSetAndGetParent()
    {
        $root = new Node();
        $child = new Node('foo');

        $child->setParent($root);

        self::assertSame($root, $child->getParent());
    }

    public function testSetChildren()
    {
        $children = [new Node('child1'), new Node('child2'), new Node('child3')];

        $root = new Node();

        $root->setChildren($children);

        self::assertSame($children, $root->getChildren());
    }

    public function testSetChildrenSetParentsReferences()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'));

        self::assertSame($root, $child1->getParent());
        self::assertSame($root, $child2->getParent());
    }

    public function testRemoveChild()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
            ->removeChild($child2);

        self::assertSame([$child1, $child3], $root->getChildren());
    }

    public function testRemoveChildRemoveParentReference()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->removeChild($child1);

        self::assertNull($child1->getParent());
    }

    public function testRemoveAllChildrenRemoveParentReferences()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->removeAllChildren();

        self::assertNull($child1->getParent());
    }

    public function testRemoveAllChildren()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
            ->removeAllChildren();

        self::assertEmpty($root->getChildren());
    }

    public function testGetAncestors()
    {
        $root = new Node('r');
        $root->addChild($a = new Node('a'));
        $a->addChild($b = new Node('b'));
        $b->addChild($c = new Node('c'));

        self::assertSame([$root, $a, $b], $c->getAncestors());
    }

    public function testGetAncestorsAndSelf()
    {
        $root = new Node('r');
        $root->addChild($a = new Node('a'));
        $a->addChild($b = new Node('b'));

        self::assertSame([$root, $a, $b], $b->getAncestorsAndSelf());
    }

    public function testGetNeighbors()
    {
        $root = new Node('r');
        $root
            ->addChild($a = new Node('a'))
            ->addChild($b = new Node('b'))
            ->addChild($c = new Node('c'));

        self::assertSame([$b, $c], $a->getNeighbors());
    }

    public function testGetNeighborsAndSelf()
    {
        $root = new Node('r');
        $root
            ->addChild($a = new Node('a'))
            ->addChild($b = new Node('b'))
            ->addChild($c = new Node('c'));

        self::assertSame([$a, $b, $c], $a->getNeighborsAndSelf());
    }

    public function testIsLeaf()
    {
        $root = new Node();

        self::assertTrue($root->isLeaf());

        $root->addChild(new Node('child'));

        self::assertFalse($root->isLeaf());
    }

    public function testRoot()
    {
        $root = (new Node('root'))
            ->addChild(
                (new Node('child'))->addChild($grandchild = new Node('grandchild'))
            );

        self::assertSame($root, $grandchild->root());
    }

    public function testIsRoot()
    {
        $root = new Node('root');
        $root->addChild($child = new Node('child'));

        self::assertTrue($root->isRoot());
        self::assertFalse($child->isRoot());
    }

    public function testIsChild()
    {
        $root = new Node('root');
        $root->addChild($child = new Node('child'));

        self::assertTrue($child->isChild());
        self::assertFalse($root->isChild());
    }

    public function testGetDepth()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'));

        $child3
            ->addChild($child4 = new Node('a'))
            ->addChild(new Node('b'));

        self::assertSame(1, $child1->getDepth());
        self::assertSame(0, $root->getDepth());
        self::assertSame(2, $child4->getDepth());
    }

    public function testGetHeight()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'));

        $child3
            ->addChild(new Node('a'))
            ->addChild(new Node('b'));

        self::assertSame(0, $child1->getHeight());
        self::assertSame(2, $root->getHeight());
        self::assertSame(1, $child3->getHeight());
    }

    public function testGetSize()
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'));

        $child3
            ->addChild(new Node('a'))
            ->addChild($child4 = new Node('b'));

        $child4->addChild($child5 = new Node('c'));
        $child5
            ->addChild(new Node('d'))
            ->addChild(new Node('f'));

        self::assertSame(9, $root->getSize());
        self::assertSame(3, $child5->getSize());
        self::assertSame(4, $child4->getSize());
        self::assertSame(6, $child3->getSize());
        self::assertSame(1, $child2->getSize());
    }
}

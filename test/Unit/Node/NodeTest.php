<?php

/**
 * Copyright (c) 2013-2023 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Test\Unit\Node;

use PHPUnit\Framework;
use Tree\Node\Node;
use Tree\Node\NodeInterface;
use Tree\Test;
use Tree\Visitor\Visitor;

/**
 * @internal
 *
 * @covers \Tree\Node\Node
 */
final class NodeTest extends Framework\TestCase
{
    use Test\Util\Helper;

    public function testDefaults(): void
    {
        $node = new Node();

        self::assertSame([], $node->getChildren());
        self::assertNull($node->getValue());
    }

    public function testConstructorSetsValue(): void
    {
        $value = self::faker()->sentence();

        $node = new Node($value);

        self::assertSame($value, $node->getValue());
    }

    public function testConstructorSetsChildren(): void
    {
        $children = [
            new Node(),
            new Node(),
            new Node(),
        ];

        $node = new Node(
            null,
            $children,
        );

        self::assertSame($children, $node->getChildren());

        $parents = \array_map(static function (NodeInterface $child): ?NodeInterface {
            return $child->getParent();
        }, $children);

        $expected = \array_fill(0, \count($children), $node);

        self::assertSame($expected, $parents);
    }

    public function testSetValue(): void
    {
        $node = new Node();

        $node->setValue('string value');

        self::assertSame('string value', $node->getValue());

        $node->setValue($object = new \stdClass());
        $object->foo = 'bar';

        self::assertSame($object, $node->getValue());
    }

    public function testAddAndGetChildren(): void
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'));

        self::assertSame([$child1, $child2, $child3], $root->getChildren());
    }

    public function testAddChildSetParent(): void
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'));

        self::assertSame($root, $child1->getParent());
        self::assertSame($root, $child2->getParent());
    }

    public function testSetAndGetParent(): void
    {
        $root = new Node();
        $child = new Node('foo');

        $child->setParent($root);

        self::assertSame($root, $child->getParent());
    }

    public function testSetChildren(): void
    {
        $children = [new Node('child1'), new Node('child2'), new Node('child3')];

        $root = new Node();

        $root->setChildren($children);

        self::assertSame($children, $root->getChildren());
    }

    public function testSetChildrenSetParentsReferences(): void
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'));

        self::assertSame($root, $child1->getParent());
        self::assertSame($root, $child2->getParent());
    }

    public function testRemoveChild(): void
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
            ->removeChild($child2);

        self::assertSame([$child1, $child3], $root->getChildren());
    }

    public function testRemoveChildRemoveParentReference(): void
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->removeChild($child1);

        self::assertNull($child1->getParent());
    }

    public function testRemoveAllChildrenRemoveParentReferences(): void
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->removeAllChildren();

        self::assertNull($child1->getParent());
    }

    public function testRemoveAllChildren(): void
    {
        $root = new Node();
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
            ->removeAllChildren();

        self::assertEmpty($root->getChildren());
    }

    public function testGetAncestors(): void
    {
        $root = new Node('r');
        $root->addChild($a = new Node('a'));
        $a->addChild($b = new Node('b'));
        $b->addChild($c = new Node('c'));

        self::assertSame([$root, $a, $b], $c->getAncestors());
    }

    public function testGetAncestorsAndSelf(): void
    {
        $root = new Node('r');
        $root->addChild($a = new Node('a'));
        $a->addChild($b = new Node('b'));

        self::assertSame([$root, $a, $b], $b->getAncestorsAndSelf());
    }

    public function testGetNeighborsReturnsEmptyArrayWhenNodeDoesNotHaveParent(): void
    {
        $node = new Node(self::faker()->sentence());

        self::assertSame([], $node->getNeighbors());
    }

    public function testGetNeighbors(): void
    {
        $root = new Node('r');
        $root
            ->addChild($a = new Node('a'))
            ->addChild($b = new Node('b'))
            ->addChild($c = new Node('c'));

        self::assertSame([$b, $c], $a->getNeighbors());
    }

    public function testGetNeighborsAndSelfReturnsArrayWithNodeWhenNodeDoesNotHaveParent(): void
    {
        $node = new Node(self::faker()->sentence());

        $expected = [
            $node,
        ];

        self::assertSame($expected, $node->getNeighborsAndSelf());
    }

    public function testGetNeighborsAndSelf(): void
    {
        $root = new Node('r');
        $root
            ->addChild($a = new Node('a'))
            ->addChild($b = new Node('b'))
            ->addChild($c = new Node('c'));

        self::assertSame([$a, $b, $c], $a->getNeighborsAndSelf());
    }

    public function testIsLeaf(): void
    {
        $root = new Node();

        self::assertTrue($root->isLeaf());

        $root->addChild(new Node('child'));

        self::assertFalse($root->isLeaf());
    }

    public function testRoot(): void
    {
        $root = (new Node('root'))
            ->addChild(
                (new Node('child'))->addChild($grandchild = new Node('grandchild')),
            );

        self::assertSame($root, $grandchild->root());
    }

    public function testIsRoot(): void
    {
        $root = new Node('root');
        $root->addChild($child = new Node('child'));

        self::assertTrue($root->isRoot());
        self::assertFalse($child->isRoot());
    }

    public function testIsChild(): void
    {
        $root = new Node('root');
        $root->addChild($child = new Node('child'));

        self::assertTrue($child->isChild());
        self::assertFalse($root->isChild());
    }

    public function testGetDepth(): void
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

    public function testGetHeight(): void
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

    public function testGetSize(): void
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

    public function testAcceptLetsVisitorVisitNode(): void
    {
        $node = new Node();

        $value = self::faker()->sentence();

        $visitor = $this->createMock(Visitor::class);

        $visitor
            ->expects(self::once())
            ->method('visit')
            ->with(self::identicalTo($node))
            ->willReturn($value);

        $accepted = $node->accept($visitor);

        self::assertSame($value, $accepted);
    }
}

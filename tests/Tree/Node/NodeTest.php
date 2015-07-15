<?php
/*
 * This file is part of Tree.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tree\Test\Tree;

use Tree\Node\Node;

/**
 * Unit tests for class FirstClass
 */
class NodeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    public function testSetValue()
    {
        $node = new Node;

        $node->setValue('string value');

        $this->assertEquals('string value', $node->getValue());

        $node->setValue($object = new \stdClass());
        $object->foo = 'bar';

        $this->assertEquals($object, $node->getValue());
    }

    public function testAddAndGetChildren()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
        ;

        $this->assertEquals([$child1, $child2, $child3], $root->getChildren());
    }

    public function testAddChildSetParent()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
        ;

        $this->assertEquals($root, $child1->getParent());
        $this->assertEquals($root, $child2->getParent());
    }

    public function testSetAndGetParent()
    {
        $root = new Node;
        $child = new Node('foo');

        $child->setParent($root);

        $this->assertEquals($root, $child->getParent());
    }

    public function testSetChildren()
    {
        $children = [new Node('child1'), new Node('child2'), new Node('child3')];

        $root = new Node;

        $root->setChildren($children);

        $this->assertEquals($children, $root->getChildren());
    }

    public function testSetChildrenSetParentsReferences()
     {
         $root = new Node;
         $root
             ->addChild($child1 = new Node('child1'))
             ->addChild($child2 = new Node('child2'))
         ;

         $this->assertEquals($root, $child1->getParent());
         $this->assertEquals($root, $child2->getParent());
     }

    public function testRemoveChild()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
            ->removeChild($child2)
        ;

        $this->assertEquals([$child1, $child3], $root->getChildren());
    }

    public function testRemoveChildRemoveParentReference()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->removeChild($child1)
        ;

        $this->assertNull($child1->getParent());
    }

    public function testRemoveAllChildrenRemoveParentReferences()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->removeAllChildren()
        ;

        $this->assertNull($child1->getParent());
    }

    public function testRemoveAllChildren()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
            ->removeAllChildren()
        ;

        $this->assertEmpty($root->getChildren());
    }

    public function testGetAncestors()
    {
        $root = new Node('r');
        $root->addChild($a = new Node('a'));
        $a->addChild($b = new Node('b'));
        $b->addChild($c = new Node('c'));

        $this->assertEquals([$root, $a, $b], $c->getAncestors());
    }

    public function testGetAncestorsAndSelf()
    {
        $root = new Node('r');
        $root->addChild($a = new Node('a'));
        $a->addChild($b = new Node('b'));

        $this->assertEquals([$root, $a, $b], $b->getAncestorsAndSelf());
    }

    public function testGetNeighbors()
    {
        $root = new Node('r');
        $root
            ->addChild($a = new Node('a'))
            ->addChild($b = new Node('b'))
            ->addChild($c = new Node('c'));

        $this->assertEquals([$b, $c], $a->getNeighbors());
    }

    public function testGetNeighborsAndSelf()
    {
        $root = new Node('r');
        $root
            ->addChild($a = new Node('a'))
            ->addChild($b = new Node('b'))
            ->addChild($c = new Node('c'));

        $this->assertEquals([$a, $b, $c], $a->getNeighborsAndSelf());
    }

    public function testIsLeaf()
    {
        $root = new Node;

        $this->assertTrue($root->isLeaf());

        $root->addChild(new Node('child'));

        $this->assertFalse($root->isLeaf());
    }

    public function testRoot()
    {
        $root = (new Node('root'))
            ->addChild(
                (new Node('child'))->addChild($grandchild = new Node('grandchild'))
            );

        $this->assertSame($root, $grandchild->root());
    }

    public function testIsRoot()
    {
        $root = new Node('root');
        $root->addChild($child = new Node('child'));

        $this->assertTrue($root->isRoot());
        $this->assertFalse($child->isRoot());
    }

    public function testIsChild()
    {
        $root = new Node('root');
        $root->addChild($child = new Node('child'));

        $this->assertTrue($child->isChild());
        $this->assertFalse($root->isChild());
    }

    public function testGetDepth()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
        ;

        $child3
            ->addChild($child4 = new Node("a"))
            ->addChild(new Node("b"))
        ;

        $this->assertEquals(1, $child1->getDepth());
        $this->assertEquals(0, $root->getDepth());
        $this->assertEquals(2, $child4->getDepth());
    }

    public function testGetHeight()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
        ;

        $child3
            ->addChild(new Node("a"))
            ->addChild(new Node("b"))
        ;

        $this->assertEquals(0, $child1->getHeight());
        $this->assertEquals(2, $root->getHeight());
        $this->assertEquals(1, $child3->getHeight());
    }


    public function testGetSize()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
        ;

        $child3
            ->addChild(new Node("a"))
            ->addChild($child4 = new Node("b"))
        ;

        $child4->addChild($child5 = new Node("c"));
        $child5
            ->addChild(new Node("d"))
            ->addChild(new Node("f"))
        ;

        $this->assertEquals(9, $root->getSize());
        $this->assertEquals(3, $child5->getSize());
        $this->assertEquals(4, $child4->getSize());
        $this->assertEquals(6, $child3->getSize());
        $this->assertEquals(1, $child2->getSize());
    }
}
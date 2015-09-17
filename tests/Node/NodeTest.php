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
    public function testSetValue()
    {
        $node = new Node;

        $node->setValue('string value');

        $this->assertSame('string value', $node->getValue());

        $node->setValue($object = new \stdClass());
        $object->foo = 'bar';

        $this->assertSame($object, $node->getValue());
    }

    public function testAddAndGetChildren()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
            ->addChild($child3 = new Node('child3'))
        ;

        $this->assertSame([$child1, $child2, $child3], $root->getChildren());
    }

    public function testAddChildSetParent()
    {
        $root = new Node;
        $root
            ->addChild($child1 = new Node('child1'))
            ->addChild($child2 = new Node('child2'))
        ;

        $this->assertSame($root, $child1->getParent());
        $this->assertSame($root, $child2->getParent());
    }

    public function testSetAndGetParent()
    {
        $root = new Node;
        $child = new Node('foo');

        $child->setParent($root);

        $this->assertSame($root, $child->getParent());
    }

    public function testSetChildren()
    {
        $children = [new Node('child1'), new Node('child2'), new Node('child3')];

        $root = new Node;

        $root->setChildren($children);

        $this->assertSame($children, $root->getChildren());
    }

    public function testSetChildrenSetParentsReferences()
     {
         $root = new Node;
         $root
             ->addChild($child1 = new Node('child1'))
             ->addChild($child2 = new Node('child2'))
         ;

         $this->assertSame($root, $child1->getParent());
         $this->assertSame($root, $child2->getParent());
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

        $this->assertSame([$child1, $child3], $root->getChildren());
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

        $this->assertSame([$root, $a, $b], $c->getAncestors());
    }

    public function testGetAncestorsAndSelf()
    {
        $root = new Node('r');
        $root->addChild($a = new Node('a'));
        $a->addChild($b = new Node('b'));

        $this->assertSame([$root, $a, $b], $b->getAncestorsAndSelf());
    }

    public function testGetNeighbors()
    {
        $root = new Node('r');
        $root
            ->addChild($a = new Node('a'))
            ->addChild($b = new Node('b'))
            ->addChild($c = new Node('c'));

        $this->assertSame([$b, $c], $a->getNeighbors());
    }

    public function testGetNeighborsAndSelf()
    {
        $root = new Node('r');
        $root
            ->addChild($a = new Node('a'))
            ->addChild($b = new Node('b'))
            ->addChild($c = new Node('c'));

        $this->assertSame([$a, $b, $c], $a->getNeighborsAndSelf());
    }

    public function testIsLeaf()
    {
        $root = new Node;

        $this->assertFalse($root->isLeaf());

        $root->addChild($child = new Node('child'));

        $this->asserttrue($child->isLeaf());
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

    public function testIsInternalNode()
    {
        $root = new Node('root');

        $this->assertTrue($root->isInternalNode(), "A root without children is still an internal node");

        $subTree = new Node('subTree');
        $subTree->addChild($child = new Node('child'));

        $root->addChild($subTree);

        $this->assertTrue($subTree->isInternalNode(), "A sub-tree is an internal node");
        $this->assertFalse($child->isInternalNode(), "An empty sub-node (a leaf) is not an internal node");
        $this->assertFalse($subTree->isLeaf(), "An internal node is not a leaf");
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

        $this->assertSame(1, $child1->getDepth());
        $this->assertSame(0, $root->getDepth());
        $this->assertSame(2, $child4->getDepth());
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

        $this->assertSame(0, $child1->getHeight());
        $this->assertSame(2, $root->getHeight());
        $this->assertSame(1, $child3->getHeight());
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

        $this->assertSame(9, $root->getSize());
        $this->assertSame(3, $child5->getSize());
        $this->assertSame(4, $child4->getSize());
        $this->assertSame(6, $child3->getSize());
        $this->assertSame(1, $child2->getSize());
    }
}

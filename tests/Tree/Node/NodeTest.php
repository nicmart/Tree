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

        $this->assertEquals(array($child1, $child2, $child3), $root->getChildren());
    }

    public function testSetChildren()
    {
        $children = array(new Node('child1'), new Node('child2'), new Node('child3'));

        $root = new Node;

        $root->setChildren($children);

        $this->assertEquals($children, $root->getChildren());
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

        $this->assertEquals(array($child1, $child3), $root->getChildren());
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

    public function testIsLeaf()
    {
        $root = new Node;

        $this->assertTrue($root->isLeaf());

        $root->addChild(new Node('child'));

        $this->assertFalse($root->isLeaf());
    }
}
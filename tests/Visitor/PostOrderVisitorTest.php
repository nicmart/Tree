<?php

namespace Tree\Test\Visitor;

use Tree\Node\Node;
use Tree\Visitor\PostOrderVisitor;

class PostOrderVisitorTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsInterface()
    {
        $visitor = new PostOrderVisitor();

        $this->assertInstanceOf('Tree\Visitor\Visitor', $visitor);
    }

    /**
     * root
     */
    public function testWalkTreeWithOneNode()
    {
        $root = new Node('root');

        $visitor = new PostOrderVisitor();

        $expected = [
            $root,
        ];

        $this->assertSame($expected, $visitor->visit($root));
    }

    /**
     * root
     *  |
     *  a
     */
    public function testWalkTreeWithTwoNodes()
    {
        $root = new Node('root');

        $a = new Node('a');

        $root->addChild($a);

        $visitor = new PostOrderVisitor();

        $expected = [
            $a,
            $root,
        ];

        $this->assertSame($expected, $visitor->visit($root));
    }

    /**
     *    root
     *    /|\
     *   a b c
     *  /| |
     * d e f
     */
    public function testWalkTreeWithMoreNodes()
    {
        $root = new Node('root');

        $a = new Node('a');
        $b = new Node('b');
        $c = new Node('c');
        $d = new Node('d');
        $e = new Node('e');
        $f = new Node('f');

        $root->addChild($a);
        $root->addChild($b);
        $root->addChild($c);

        $a->addChild($d);
        $a->addChild($e);

        $b->addChild($f);

        $visitor = new PostOrderVisitor();

        $expected = [
            $d,
            $e,
            $a,
            $f,
            $b,
            $c,
            $root,
        ];

        $this->assertSame($expected, $visitor->visit($root));
    }

    /**
     *    root
     *    /|\
     *   a b c
     *  /| |
     * d e f
     */
    public function testWalkSubTree()
    {
        $root = new Node('root');

        $a = new Node('a');
        $b = new Node('b');
        $c = new Node('c');
        $d = new Node('d');
        $e = new Node('e');
        $f = new Node('f');

        $root->addChild($a);
        $root->addChild($b);
        $root->addChild($c);

        $a->addChild($d);
        $a->addChild($e);

        $b->addChild($f);

        $visitor = new PostOrderVisitor();

        $expected = [
            $d,
            $e,
            $a,
        ];

        $this->assertSame($expected, $visitor->visit($a));
    }
}

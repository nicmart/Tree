<?php

/*
 * This file is part of Tree.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tree\Test\Visitor;

use PHPUnit\Framework;
use Tree\Node\Node;
use Tree\Visitor\PreOrderVisitor;

/**
 * @internal
 *
 * @covers \Tree\Visitor\PreOrderVisitor
 */
final class PreOrderVisitorTest extends Framework\TestCase
{
    public function testImplementsInterface()
    {
        $visitor = new PreOrderVisitor();

        self::assertInstanceOf('Tree\Visitor\Visitor', $visitor);
    }

    /**
     * root.
     */
    public function testWalkTreeWithOneNode()
    {
        $root = new Node('root');

        $visitor = new PreOrderVisitor();

        $expected = [
            $root,
        ];

        self::assertSame($expected, $visitor->visit($root));
    }

    /**
     * root
     *  |
     *  a.
     */
    public function testWalkTreeWithTwoNodes()
    {
        $root = new Node('root');

        $a = new Node('a');

        $root->addChild($a);

        $visitor = new PreOrderVisitor();

        $expected = [
            $root,
            $a,
        ];

        self::assertSame($expected, $visitor->visit($root));
    }

    /**
     *    root
     *    /|\
     *   a b c
     *  /| |
     * d e f.
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

        $visitor = new PreOrderVisitor();

        $expected = [
            $root,
            $a,
            $d,
            $e,
            $b,
            $f,
            $c,
        ];

        self::assertSame($expected, $visitor->visit($root));
    }

    /**
     *    root
     *    /|\
     *   a b c
     *  /| |
     * d e f.
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

        $visitor = new PreOrderVisitor();

        $expected = [
            $a,
            $d,
            $e,
        ];

        self::assertSame($expected, $visitor->visit($a));
    }
}

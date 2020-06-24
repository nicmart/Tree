<?php

/**
 * Copyright (c) 2013-2020 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Test\Visitor;

use PHPUnit\Framework;
use Tree\Node\Node;
use Tree\Visitor\PostOrderVisitor;

/**
 * @internal
 *
 * @covers \Tree\Visitor\PostOrderVisitor
 */
final class PostOrderVisitorTest extends Framework\TestCase
{
    public function testImplementsInterface()
    {
        $visitor = new PostOrderVisitor();

        self::assertInstanceOf('Tree\Visitor\Visitor', $visitor);
    }

    /**
     * root.
     */
    public function testWalkTreeWithOneNode()
    {
        $root = new Node('root');

        $visitor = new PostOrderVisitor();

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

        $visitor = new PostOrderVisitor();

        $expected = [
            $a,
            $root,
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

        $visitor = new PostOrderVisitor();

        $expected = [
            $d,
            $e,
            $a,
        ];

        self::assertSame($expected, $visitor->visit($a));
    }
}

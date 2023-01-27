<?php

/**
 * Copyright (c) 2013-2023 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Test\Unit\Visitor;

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
    /**
     * root.
     */
    public function testWalkTreeWithOneNode(): void
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
    public function testWalkTreeWithTwoNodes(): void
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
    public function testWalkTreeWithMoreNodes(): void
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
    public function testWalkSubTree(): void
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

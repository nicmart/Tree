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
use Tree\Visitor\YieldVisitor;

/**
 * @internal
 * @coversNothing
 */
final class YieldVisitorTest extends Framework\TestCase
{
    /**
     *              root
     *              /  \
     *             A    B
     *            / \
     *           C   D
     *               |
     *               E.
     */
    public function testGetYield()
    {
        $root = new Node('root');
        $root
            ->addChild($a = new Node('A'))
            ->addChild($b = new Node('B'));

        $a
            ->addChild($c = new Node('C'))
            ->addChild($d = new Node('D', [$e = new Node('E')]));

        $visitor = new YieldVisitor();

        $yield = $root->accept($visitor);

        self::assertSame([$c, $e, $b], $yield);
    }

    public function testTheYieldOfALeafNodeIsTheNodeItself()
    {
        $node = new Node('node');
        $visitor = new YieldVisitor();

        self::assertSame([$node], $node->accept($visitor));
    }
}

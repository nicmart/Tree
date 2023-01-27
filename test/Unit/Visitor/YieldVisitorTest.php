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
use Tree\Visitor\YieldVisitor;

/**
 * @internal
 *
 * @covers \Tree\Visitor\YieldVisitor
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
    public function testGetYield(): void
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

    public function testTheYieldOfALeafNodeIsTheNodeItself(): void
    {
        $node = new Node('node');
        $visitor = new YieldVisitor();

        self::assertSame([$node], $node->accept($visitor));
    }
}

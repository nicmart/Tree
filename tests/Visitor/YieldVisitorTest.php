<?php
/**
 * This file is part of Tree
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Tree\Test\Visitor;

use Tree\Node\Node;
use Tree\Visitor\YieldVisitor;

class YieldVisitorTest extends \PHPUnit_Framework_TestCase
{
    /**
     *              root
     *              /  \
     *             A    B
     *            / \
     *           C   D
     *               |
     *               E
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

        $this->assertEquals([$c, $e, $b], $yield);
    }

    public function testTheYieldOfALeafNodeIsTheNodeItself()
    {
        $node = new Node('node');
        $visitor = new YieldVisitor;

        $this->assertEquals([$node], $node->accept($visitor));
    }
}
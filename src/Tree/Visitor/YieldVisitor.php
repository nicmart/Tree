<?php
/**
 * This file is part of Tree
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Tree\Visitor;


use Tree\Node\NodeInterface;

/**
 * Class YieldVisitor
 *
 * @package Tree\Visitor
 */
class YieldVisitor implements Visitor
{
    /**
     * {@inheritdoc}
     */
    public function visit(NodeInterface $node)
    {
        if ($node->isLeaf()) {
            return [$node];
        }

        $yield = [];

        foreach ($node->getChildren() as $child) {
            $yield = array_merge($yield, $child->accept($this));
        }

        return $yield;
    }
} 
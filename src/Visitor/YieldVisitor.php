<?php

/**
 * Copyright (c) 2013-2020 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Visitor;

use Tree\Node\NodeInterface;

class YieldVisitor implements Visitor
{
    public function visit(NodeInterface $node)
    {
        if ($node->isLeaf()) {
            return [$node];
        }

        $yield = [];

        foreach ($node->getChildren() as $child) {
            $yield = \array_merge($yield, $child->accept($this));
        }

        return $yield;
    }
}

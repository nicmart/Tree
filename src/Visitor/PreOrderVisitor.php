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

class PreOrderVisitor implements Visitor
{
    public function visit(NodeInterface $node)
    {
        $nodes = [
            $node,
        ];

        foreach ($node->getChildren() as $child) {
            $nodes = \array_merge(
                $nodes,
                $child->accept($this)
            );
        }

        return $nodes;
    }
}

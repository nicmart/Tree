<?php

/*
 * This file is part of Tree.
 *
 * (c) 2013-2015 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tree\Visitor;

use Tree\Node\NodeInterface;

class PostOrderVisitor implements Visitor
{
    public function visit(NodeInterface $node)
    {
        $nodes = [];

        foreach ($node->getChildren() as $child) {
            $nodes = array_merge(
                $nodes,
                $child->accept($this)
            );
        }

        $nodes[] = $node;

        return $nodes;
    }
}

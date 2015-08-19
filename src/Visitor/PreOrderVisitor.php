<?php

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
            $nodes = array_merge(
                $nodes,
                $child->accept($this)
            );
        }

        return $nodes;
    }
}

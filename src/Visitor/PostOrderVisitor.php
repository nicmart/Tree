<?php

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

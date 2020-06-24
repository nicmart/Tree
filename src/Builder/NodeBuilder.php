<?php

/**
 * Copyright (c) 2013-2020 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Builder;

use Tree\Node\Node;
use Tree\Node\NodeInterface;

/**
 * Main implementation of the NodeBuilderInterface.
 */
class NodeBuilder implements NodeBuilderInterface
{
    /**
     * @var NodeInterface[]
     */
    private $nodeStack = [];

    public function __construct(?NodeInterface $node = null)
    {
        $this->setNode($node ?: $this->nodeInstanceByValue());
    }

    public function setNode(NodeInterface $node)
    {
        $this
            ->emptyStack()
            ->pushNode($node);

        return $this;
    }

    public function getNode()
    {
        return $this->nodeStack[\count($this->nodeStack) - 1];
    }

    public function leaf($value = null)
    {
        $this->getNode()->addChild(
            $this->nodeInstanceByValue($value)
        );

        return $this;
    }

    public function leafs($value1 /*,  $value2, ... */)
    {
        foreach (\func_get_args() as $value) {
            $this->leaf($value);
        }

        return $this;
    }

    public function tree($value = null)
    {
        $node = $this->nodeInstanceByValue($value);
        $this->getNode()->addChild($node);
        $this->pushNode($node);

        return $this;
    }

    public function end()
    {
        $this->popNode();

        return $this;
    }

    public function nodeInstanceByValue($value = null)
    {
        return new Node($value);
    }

    public function value($value)
    {
        $this->getNode()->setValue($value);

        return $this;
    }

    private function emptyStack()
    {
        $this->nodeStack = [];

        return $this;
    }

    private function pushNode(NodeInterface $node)
    {
        \array_push($this->nodeStack, $node);

        return $this;
    }

    private function popNode()
    {
        return \array_pop($this->nodeStack);
    }
}

<?php
/*
 * This file is part of Tree.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tree\Builder;

use Tree\Node\NodeInterface;
use Tree\Node\Node;

/**
 * Main implementation of the NodeBuilderInterface
 */
class NodeBuilder implements NodeBuilderInterface
{
    /**
     * @var NodeInterface[]
     */
    private $nodeStack = [];

    /**
     * @param NodeInterface $node
     */
    public function __construct(NodeInterface $node = null)
    {
        $this->setNode($node ?: $this->nodeInstanceByValue());
    }

    /**
     * {@inheritdoc}
     */
    public function setNode(NodeInterface $node)
    {
        $this
            ->emptyStack()
            ->pushNode($node)
        ;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNode()
    {
        return $this->nodeStack[count($this->nodeStack) - 1];
    }

    /**
     * {@inheritdoc}
     */
    public function leaf($value = null)
    {
        $this->getNode()->addChild(
            $this->nodeInstanceByValue($value)
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function leafs($value1 /*,  $value2, ... */)
    {
        foreach (func_get_args() as $value) {
            $this->leaf($value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function tree($value = null)
    {
        $node = $this->nodeInstanceByValue($value);
        $this->getNode()->addChild($node);
        $this->pushNode($node);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function end()
    {
        $this->popNode();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function nodeInstanceByValue($value = null)
    {
        return new Node($value);
    }

    /**
     * {@inheritdoc}
     */
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
        array_push($this->nodeStack, $node);

        return $this;
    }

    private function popNode()
    {
        return array_pop($this->nodeStack);
    }
}

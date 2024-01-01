<?php

/**
 * Copyright (c) 2013-2024 Nicolò Martini
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
     * @var array<int, NodeInterface>
     */
    private array $nodeStack = [];

    public function __construct(?NodeInterface $node = null)
    {
        $this->setNode($node ?: $this->nodeInstanceByValue());
    }

    public function setNode(NodeInterface $node): static
    {
        $this
            ->emptyStack()
            ->pushNode($node);

        return $this;
    }

    public function getNode(): NodeInterface
    {
        $count = \count($this->nodeStack);

        if (0 === $count) {
            throw new \LogicException('The node builder currently does not manage any nodes.');
        }

        return $this->nodeStack[$count - 1];
    }

    public function leaf(mixed $value = null): static
    {
        $this->getNode()->addChild(
            $this->nodeInstanceByValue($value),
        );

        return $this;
    }

    public function leafs(mixed ...$values): static
    {
        foreach ($values as $value) {
            $this->leaf($value);
        }

        return $this;
    }

    public function tree(mixed $value = null): static
    {
        $node = $this->nodeInstanceByValue($value);
        $this->getNode()->addChild($node);
        $this->pushNode($node);

        return $this;
    }

    public function end(): ?static
    {
        $this->popNode();

        return $this;
    }

    public function nodeInstanceByValue(mixed $value = null): NodeInterface
    {
        return new Node($value);
    }

    public function value(mixed $value): static
    {
        $this->getNode()->setValue($value);

        return $this;
    }

    private function emptyStack(): static
    {
        $this->nodeStack = [];

        return $this;
    }

    private function pushNode(NodeInterface $node): static
    {
        $this->nodeStack[] = $node;

        return $this;
    }

    private function popNode(): void
    {
        \array_pop($this->nodeStack);
    }
}

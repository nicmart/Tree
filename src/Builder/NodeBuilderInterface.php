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

use Tree\Node\NodeInterface;

/**
 * Interface that allows a fluent tree building.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */
interface NodeBuilderInterface
{
    /**
     * Set the node the builder will manage.
     */
    public function setNode(NodeInterface $node): static;

    /**
     * Get the node the builder manages.
     *
     * @throws \LogicException
     */
    public function getNode(): NodeInterface;

    /**
     * Set the value of the underlaying node.
     */
    public function value(mixed $value): static;

    /**
     * Add a leaf to the node.
     */
    public function leaf(mixed $value = null): static;

    /**
     * Add several leafs to the node.
     */
    public function leafs(mixed ...$values): static;

    /**
     * Add a child to the node enter in its scope.
     */
    public function tree(mixed $value = null): static;

    /**
     * Goes up to the parent node context.
     */
    public function end(): ?static;

    /**
     * Return a node instance set with the given value. Implementation can follow their own logic
     * in choosing the NodeInterface implmentation taking into account the value.
     */
    public function nodeInstanceByValue(mixed $value = null): NodeInterface;
}

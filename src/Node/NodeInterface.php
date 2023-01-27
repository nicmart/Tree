<?php

/**
 * Copyright (c) 2013-2023 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Node;

use Tree\Visitor\Visitor;

/**
 * Interface for tree nodes.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */
interface NodeInterface
{
    /**
     * Set the value of the current node.
     *
     * @param mixed $value
     */
    public function setValue($value): static;

    /**
     * Get the current node value.
     */
    public function getValue(): mixed;

    /**
     * Add a child.
     *
     * @return mixed
     */
    public function addChild(self $child): static;

    /**
     * Remove a node from children.
     */
    public function removeChild(self $child): static;

    /**
     * Remove all children.
     */
    public function removeAllChildren(): static;

    /**
     * Return the array of children.
     *
     * @return NodeInterface[]
     */
    public function getChildren(): array;

    /**
     * Replace the children set with the given one.
     *
     * @param NodeInterface[] $children
     *
     * @return mixed
     */
    public function setChildren(array $children): static;

    /**
     * Set the parent node.
     *
     * @param NodeInterface $parent
     */
    public function setParent(?self $parent = null): void;

    /**
     * Return the parent node.
     */
    public function getParent(): ?static;

    /**
     * Retrieves all ancestors of node excluding current node.
     */
    public function getAncestors(): array;

    /**
     * Retrieves all ancestors of node as well as the node itself.
     *
     * @return Node[]
     */
    public function getAncestorsAndSelf(): array;

    /**
     * Retrieves all neighboring nodes, excluding the current node.
     */
    public function getNeighbors(): array;

    /**
     * Returns all neighboring nodes, including the current node.
     *
     * @return NodeInterface[]
     */
    public function getNeighborsAndSelf(): array;

    /**
     * Return true if the node is the root, false otherwise.
     */
    public function isRoot(): bool;

    /**
     * Return true if the node is a child, false otherwise.
     */
    public function isChild(): bool;

    /**
     * Return true if the node has no children, false otherwise.
     */
    public function isLeaf(): bool;

    /**
     * Find the root of the node.
     */
    public function root(): self;

    /**
     * Return the distance from the current node to the root.
     */
    public function getDepth(): int;

    /**
     * Return the height of the tree whose root is this node.
     */
    public function getHeight(): int;

    /**
     * Return the number of nodes in a tree.
     *
     * @return int
     */
    public function getSize();

    /**
     * Accept method for the visitor pattern (see http://en.wikipedia.org/wiki/Visitor_pattern).
     */
    public function accept(Visitor $visitor): mixed;
}

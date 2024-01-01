<?php

/**
 * Copyright (c) 2013-2024 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Node;

use Tree\Visitor\Visitor;

trait NodeTrait
{
    private mixed $value = null;
    private ?NodeInterface $parent = null;

    /**
     * @var array<int, NodeInterface>
     */
    private array $children = [];

    public function setValue(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function addChild(NodeInterface $child): static
    {
        $child->setParent($this);
        $this->children[] = $child;

        return $this;
    }

    public function removeChild(NodeInterface $child): static
    {
        foreach ($this->children as $key => $myChild) {
            if ($child === $myChild) {
                unset($this->children[$key]);
            }
        }

        $this->children = \array_values($this->children);

        $child->setParent(null);

        return $this;
    }

    public function removeAllChildren(): static
    {
        $this->setChildren([]);

        return $this;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function setChildren(array $children): static
    {
        foreach ($this->getChildren() as $child) {
            $child->setParent(null);
        }

        $this->children = [];

        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    public function setParent(?NodeInterface $parent = null): void
    {
        $this->parent = $parent;
    }

    public function getParent(): ?static
    {
        return $this->parent;
    }

    public function getAncestors(): array
    {
        $parents = [];
        $node = $this;

        while (($parent = $node->getParent()) instanceof NodeInterface) {
            \array_unshift($parents, $parent);
            $node = $parent;
        }

        return $parents;
    }

    public function getAncestorsAndSelf(): array
    {
        return \array_merge($this->getAncestors(), [$this]);
    }

    public function getNeighbors(): array
    {
        if (null === $this->parent) {
            return [];
        }

        $neighbors = $this->parent->getChildren();
        $that = $this;

        return \array_values(\array_filter($neighbors, static function (NodeInterface $node) use ($that): bool {
            return $node !== $that;
        }));
    }

    public function getNeighborsAndSelf(): array
    {
        if (null === $this->parent) {
            return [
                $this,
            ];
        }

        return $this->parent->getChildren();
    }

    public function isRoot(): bool
    {
        return null === $this->parent;
    }

    public function isChild(): bool
    {
        return null !== $this->parent;
    }

    public function isLeaf(): bool
    {
        return [] === $this->children;
    }

    public function root(): static
    {
        $node = $this;

        while (($parent = $node->getParent()) instanceof NodeInterface) {
            $node = $parent;
        }

        return $node;
    }

    /**
     * Return the distance from the current node to the root.
     *
     * Warning, can be expensive, since each descendant is visited
     */
    public function getDepth(): int
    {
        if ($this->isRoot()) {
            return 0;
        }

        return $this->getParent()->getDepth() + 1;
    }

    /**
     * Return the height of the tree whose root is this node.
     */
    public function getHeight(): int
    {
        if ($this->isLeaf()) {
            return 0;
        }

        $heights = [];

        foreach ($this->getChildren() as $child) {
            $heights[] = $child->getHeight();
        }

        return \max($heights) + 1;
    }

    public function getSize(): int
    {
        $size = 1;

        foreach ($this->getChildren() as $child) {
            $size += $child->getSize();
        }

        return $size;
    }

    public function accept(Visitor $visitor): mixed
    {
        return $visitor->visit($this);
    }
}

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

trait NodeTrait
{
    /**
     * @var mixed
     */
    private $value;
    private ?NodeInterface $parent = null;

    /**
     * @var NodeInterface[]
     */
    private array $children = [];

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function addChild(NodeInterface $child)
    {
        $child->setParent($this);
        $this->children[] = $child;

        return $this;
    }

    public function removeChild(NodeInterface $child)
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

    public function removeAllChildren()
    {
        $this->setChildren([]);

        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren(array $children)
    {
        $this->removeParentFromChildren();
        $this->children = [];

        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    public function setParent(?NodeInterface $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getAncestors()
    {
        $parents = [];
        $node = $this;

        while (($parent = $node->getParent()) instanceof NodeInterface) {
            \array_unshift($parents, $parent);
            $node = $parent;
        }

        return $parents;
    }

    public function getAncestorsAndSelf()
    {
        return \array_merge($this->getAncestors(), [$this]);
    }

    public function getNeighbors()
    {
        $neighbors = $this->getParent()->getChildren();
        $current = $this;

        return \array_values(
            \array_filter(
                $neighbors,
                static function ($item) use ($current) {
                    return $item !== $current;
                },
            ),
        );
    }

    public function getNeighborsAndSelf()
    {
        return $this->getParent()->getChildren();
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return null === $this->getParent();
    }

    public function isChild()
    {
        return null !== $this->getParent();
    }

    public function isLeaf()
    {
        return 0 === \count($this->children);
    }

    public function root()
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
     *
     * @return int
     */
    public function getDepth()
    {
        if ($this->isRoot()) {
            return 0;
        }

        return $this->getParent()->getDepth() + 1;
    }

    /**
     * Return the height of the tree whose root is this node.
     *
     * @return int
     */
    public function getHeight()
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

    public function getSize()
    {
        $size = 1;

        foreach ($this->getChildren() as $child) {
            $size += $child->getSize();
        }

        return $size;
    }

    public function accept(Visitor $visitor)
    {
        return $visitor->visit($this);
    }

    private function removeParentFromChildren()
    {
        foreach ($this->getChildren() as $child) {
            $child->setParent(null);
        }
    }
}

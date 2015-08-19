<?php
/**
 * This file is part of Tree
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Tree\Node;

use Tree\Visitor\Visitor;

trait NodeTrait
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * parent
     *
     * @var NodeInterface
     * @access private
     */
    private $parent;

    /**
     * @var NodeInterface[]
     */
    private $children = [];

    /**
     * @param mixed $value
     * @param NodeInterface[] $children
     */
    public function __construct($value = null, array $children = [])
    {
        $this->setValue($value);
        if (!empty($children)) {
            $this->setChildren($children);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(NodeInterface $child)
    {
        $child->setParent($this);
        $this->children[] = $child;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(NodeInterface $child)
    {
        foreach ($this->children as $key => $myChild) {
            if ($child == $myChild) {
                unset($this->children[$key]);
            }
        }

        $this->children = array_values($this->children);

        $child->setParent(null);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllChildren()
    {
        $this->setChildren([]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function setChildren(array $children)
    {
        $this->removeParentFromChildren();
        $this->children = [];

        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(NodeInterface $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getAncestors()
    {
        $parents = [];
        $node = $this;
        while ($parent = $node->getParent()) {
            array_unshift($parents, $parent);
            $node = $parent;
        }

        return $parents;
    }

    /**
     * {@inheritDoc}
     */
    public function getAncestorsAndSelf()
    {
        return array_merge($this->getAncestors(), [$this]);
    }

    /**
     * {@inheritdoc}
     */
    public function getNeighbors()
    {
        $neighbors = $this->getParent()->getChildren();
        $current = $this;

        // Uses array_values to reset indexes after filter.
        return array_values(
            array_filter(
                $neighbors,
                function ($item) use ($current) {
                    return $item != $current;
                }
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getNeighborsAndSelf()
    {
        return $this->getParent()->getChildren();
    }

    /**
     * {@inheritDoc}
     */
    public function isLeaf()
    {
        return count($this->children) === 0;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return $this->getParent() === null;
    }

    /**
     * {@inheritDoc}
     */
    public function isChild()
    {
        return $this->getParent() !== null;
    }

    /**
     * Find the root of the node
     *
     * @return NodeInterface
     */
    public function root()
    {
        $node = $this;

        while ($parent = $node->getParent())
            $node = $parent;

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
     * Return the height of the tree whose root is this node
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

        return max($heights) + 1;
    }

    /**
     * Return the number of nodes in a tree
     * @return int
     */
    public function getSize()
    {
        $size = 1;
        foreach ($this->getChildren() as $child) {
            $size += $child->getSize();
        }

        return $size;
    }

    /**
     * {@inheritdoc}
     */
    public function accept(Visitor $visitor)
    {
        return $visitor->visit($this);
    }

    private function removeParentFromChildren()
    {
        foreach ($this->getChildren() as $child)
            $child->setParent(null);
    }
} 

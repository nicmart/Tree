<?php
/*
 * This file is part of Tree.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tree\Node;

/**
 * Class Node
 */
class Node implements NodeInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var array[NodeInterface]
     */
    private $children = array();

    /**
     * @param mixed $value
     * @param array[NodeInterface] $children
     */
    public function __construct($value = null, array $children = array())
    {
        $this->setValue($value);
        $this->setChildren($children);
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
        $this->children[] = $child;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(NodeInterface $child)
    {
        foreach ($this->children as $key => $myChild) {
            if ($child == $myChild)
                unset($this->children[$key]);
        }

        $this->children = array_values($this->children);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllChildren()
    {
        $this->children = array();

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
        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isLeaf()
    {
        return count($this->children) == 0;
    }

}
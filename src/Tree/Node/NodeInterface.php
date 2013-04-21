<?php
/*
 * This file is part of library-template.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tree\Node;

/**
 * Interface for tree nodes
 *
 * @package    Tree
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
interface NodeInterface
{
    /**
     * Set the value of the current node
     *
     * @param mixed $value
     *
     * @return NodeInterface the current instance
     */
    public function setValue($value);

    /**
     * Get the current node value
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Add a child
     *
     * @param NodeInterface $child
     *
     * @return mixed
     */
    public function addChild(NodeInterface $child);

    /**
     * Remove a node from children
     *
     * @param NodeInterface $child
     *
     * @return NodeInterface the current instance
     */
    public function removeChild(NodeInterface $child);

    /**
     * Remove all children
     *
     * @return NodeInterface The current instance
     */
    public function removeAllChildren();

    /**
     * Return the array of children
     *
     * @return array[NodeInterface]
     */
    public function getChildren();

    /**
     * Replace the children set with the given one
     *
     * @param array[NodeInterface] $children
     *
     * @return mixed
     */
    public function setChildren(array $children);

    /**
     * Return true if the node has no children, false otherwise
     *
     * @return bool
     */
    public function isLeaf();
}
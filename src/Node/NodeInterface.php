<?php
/*
 * This file is part of Tree library.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tree\Node;

use Tree\Visitor\Visitor;

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
     * @return NodeInterface[]
     */
    public function getChildren();

    /**
     * Replace the children set with the given one
     *
     * @param NodeInterface[] $children
     *
     * @return mixed
     */
    public function setChildren(array $children);

    /**
     * setParent
     *
     * @param NodeInterface $parent
     * @return void
     */
    public function setParent(NodeInterface $parent = null);

    /**
     * getParent
     *
     * @return NodeInterface
     */
    public function getParent();

    /**
     * Retrieves all ancestors of node excluding current node.
     *
     * @return array
     */
    public function getAncestors();

    /**
     * Retrieves all ancestors of node as well as the node itself.
     *
     * @return Node[]
     */
    public function getAncestorsAndSelf();

    /**
     * Retrieves all neighboring nodes, excluding the current node.
     *
     * @return array
     */
    public function getNeighbors();

    /**
     * Returns all neighboring nodes, including the current node.
     *
     * @return Node[]
     */
    public function getNeighborsAndSelf();

    /**
     * Return true if the node is the root, false otherwise
     *
     * @return bool
     */
    public function isRoot();

    /**
     * Return true if the node is a child, false otherwise.
     *
     * @return bool
     */
    public function isChild();

    /**
     * Return true if the node has no children, false otherwise
     *
     * @return bool
     */
    public function isLeaf();

    /**
     * Return the distance from the current node to the root
     *
     * @return int
     */
    public function getDepth();

    /**
     * Return the height of the tree whose root is this node
     *
     * @return int
     */
    public function getHeight();

    /**
     * Accept method for the visitor pattern (see http://en.wikipedia.org/wiki/Visitor_pattern)
     *
     * @param Visitor $visitor
     * @return void
     */
    public function accept(Visitor $visitor);
}

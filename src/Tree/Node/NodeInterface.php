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
     * setParent
     *
     * @param NodeInterface $parent
     * @access public
     * @return void
     */
    public function setParent(NodeInterface $parent);

    /**
     * getParent
     *
     * @access public
     * @return NodeInterface
     */
    public function getParent();

    /**
     * getParents
     *
     * @access public
     * @return array
     */
    public function getParents();

    /**
     * Return true if the node has no children, false otherwise
     *
     * @return bool
     */
    public function isLeaf();

    /**
     * Accept method for the visitor pattern (see http://en.wikipedia.org/wiki/Visitor_pattern)
     *
     * @param Visitor $visitor
     * @return void
     */
    public function accept(Visitor $visitor);
}

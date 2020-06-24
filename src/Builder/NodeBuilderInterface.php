<?php

/**
 * Copyright (c) 2013-2020 Nicolò Martini
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
     *
     * @param NodeInterface $node
     *
     * @return NodeBuilderInterface The current instance
     */
    public function setNode(NodeInterface $node);

    /**
     * Get the node the builder manages.
     *
     * @return NodeInterface
     */
    public function getNode();

    /**
     * Set the value of the underlaying node.
     *
     * @param mixed $value
     *
     * @return NodebuilderInterface The current instance
     */
    public function value($value);

    /**
     * Add a leaf to the node.
     *
     * @param mixed $value The value of the leaf node
     *
     * @return NodeBuilderInterface The current instance
     */
    public function leaf($value = null);

    /**
     * Add several leafs to the node.
     *
     * @param $value, ... An arbitrary long list of values
     *
     * @return NodeBuilderInterface The current instance
     */
    public function leafs($value);

    /**
     * Add a child to the node enter in its scope.
     *
     * @param null $value
     *
     * @return NodeBuilderInterface A NodeBuilderInterface instance linked to the child node
     */
    public function tree($value = null);

    /**
     * Goes up to the parent node context.
     *
     * @return null|NodeBuilderInterface A NodeBuilderInterface instanced linked to the parent node
     */
    public function end();

    /**
     * Return a node instance set with the given value. Implementation can follow their own logic
     * in choosing the NodeInterface implmentation taking into account the value.
     *
     * @param mixed $value
     *
     * @return NodeInterface
     */
    public function nodeInstanceByValue($value = null);
}

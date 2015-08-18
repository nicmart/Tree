<?php
/*
 * This file is part of Tree library.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tree\Visitor;

use Tree\Node\NodeInterface;

/**
 * Visitor interface for Nodes
 *
 * @package    Tree
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
interface Visitor
{
    /**
     * @param NodeInterface $node
     * @return mixed
     */
    public function visit(NodeInterface $node);
}
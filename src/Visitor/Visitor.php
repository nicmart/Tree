<?php

/**
 * Copyright (c) 2013-2024 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Visitor;

use Tree\Node\NodeInterface;

/**
 * Visitor interface for Nodes.
 *
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
interface Visitor
{
    public function visit(NodeInterface $node): mixed;
}

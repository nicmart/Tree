<?php

/**
 * Copyright (c) 2013-2020 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Node;

class Node implements NodeInterface
{
    use NodeTrait;

    /**
     * @param mixed           $value
     * @param NodeInterface[] $children
     */
    public function __construct($value = null, array $children = [])
    {
        $this->setValue($value);

        if (!empty($children)) {
            $this->setChildren($children);
        }
    }
}

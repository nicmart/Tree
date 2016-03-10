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
    use NodeTrait;

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
}

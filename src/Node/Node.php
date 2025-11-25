<?php

/**
 * Copyright (c) 2013-2025 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

namespace Tree\Node;

/**
 * @template TValue
 *
 * @template-implements NodeInterface<TValue>
 */
class Node implements NodeInterface
{
    /** @use NodeTrait<null|TValue> */
    use NodeTrait;

    /**
     * @param null|TValue               $value
     * @param array<int, NodeInterface> $children
     */
    public function __construct(
        $value = null,
        array $children = [],
    ) {
        $this->setValue($value);

        if ([] === $children) {
            return;
        }

        $this->setChildren($children);
    }
}

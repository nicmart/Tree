# Tree

[![Integrate](https://github.com/nicmart/Tree/workflows/Integrate/badge.svg?branch=master)](https://github.com/nicmart/Tree/actions)
[![Release](https://github.com/nicmart/Tree/workflows/Release/badge.svg?branch=master)](https://github.com/nicmart/Tree/actions)

[![Code Coverage](https://codecov.io/gh/nicmart/tree/branch/master/graph/badge.svg)](https://codecov.io/gh/nicmart/tree)
[![Type Coverage](https://shepherd.dev/github/nicmart/tree/coverage.svg)](https://shepherd.dev/github/nicmart/tree)

[![Latest Stable Version](https://poser.pugx.org/nicmart/tree/v/stable)](https://packagist.org/packages/nicmart/tree)
[![Total Downloads](https://poser.pugx.org/nicmart/tree/downloads)](https://packagist.org/packages/nicmart/tree)
[![Monthly Downloads](http://poser.pugx.org/nicmart/tree/d/monthly)](https://packagist.org/packages/nicmart/tree)

In Tree you can find a basic but flexible tree data structure for php together with and an handful Builder class, that enables you to build tree in a fluent way.

## The tree data structure

The `Tree\Node\NodeInterface` interface abstracts the concept of a tree node. In `Tree` a Node has essentially two things:
a set of children (that implements the same `NodeInterface` interface) and a value.

On the other hand, the `Tree\Node\Node` gives a straight implementation for that interface.

### Creating a node

```php
use Tree\Node\Node;

$node = new Node('foo');
```

### Getting and setting the value of a node

Each node has a value property, that can be any php value.
```php
$node->setValue('my value');
echo $node->getValue(); //Prints 'my value'
```

### Adding one or more children

```php
$child1 = new Node('child1');
$child2 = new Node('child2');

$node
    ->addChild($child1)
    ->addChild($child2);
```

### Removing a child

```php
$node->removeChild($child1);
```

### Getting the array of all children

```php
$children = $node->getChildren();
```

### Overwriting the children set

```php
$node->setChildren([new Node('foo'), new Node('bar')]);
```

### Removing all children

```php
$node->removeAllChildren();
```

### Getting if the node is a leaf or not

A leaf is a node with no children.

```php
$node->isLeaf();
```

### Getting if the node is a child or not

A child is a node that has a parent.

```php
$node->isChild();
```

### Getting the parent of a node

Reference to the parent node is automatically managed by child-modifiers methods

```php
$root->addChild($node = new Node('child'));
$node->getParent(); // Returns $root
```

### Getting the ancestors of a node

```php
$root = (new Node('root'))
    ->addChild($child = new Node('child'))
    ->addChild($grandChild = new Node('grandchild'))
;

$grandchild->getAncestors(); // Returns [$root, $child]
```

#### Related Methods

- `getAncestorsAndSelf` retrieves ancestors of a node with the current node included.

### Getting the root of a node

```php
$root = $node->root();
```

### Getting the neighbors of a node

```php
$root = (new Node('root'))
    ->addChild($child1 = new Node('child1'))
    ->addChild($child2 = new Node('child2'))
    ->addChild($child3 = new Node('child3'))
;

$child2->getNeighbors(); // Returns [$child1, $child3]
```

#### Related Methods

- `getNeighborsAndSelf` retrieves neighbors of current node and the node itself.

### Getting the number of nodes in the tree

```php
$node->getSize();
```

### Getting the depth of a node

```php
$node->getDepth();
```

### Getting the height of a node

```php
$node->getHeight();
```

## The Builder

The builder provides a convenient way to build trees. It is provided by the ```Builder``` class,
but you can implement your own builder making an implementation of the ```BuilderInterface```class.

### Example

Let's see how to build the following tree, where the nodes label are represents nodes values:

```
       A
      / \
     B   C
        /|\
       D E F
      /|
     G H
```

And here is the code:

```php
$builder = new Tree\Builder\NodeBuilder;

$builder
    ->value('A')
    ->leaf('B')
    ->tree('C')
        ->tree('D')
            ->leaf('G')
            ->leaf('H')
            ->end()
        ->leaf('E')
        ->leaf('F')
        ->end()
;

$nodeA = $builder->getNode();
```

The example should be self-explanatory, but here you are a brief description of the methods used above.

### Builder::value($value)

Set the value of the current node to ```$value```

### Builder::leaf($value)

Add to the current node a new child whose value is ```$value```.

### Builder::tree($value)

Add to the current node a new child whose value is ```$value```, and set the new node as the builder current node.

### Builder::end()

Returns to the context the builder was before the call to ```tree```method,
i.e. make the builder go one level up.

### Builder::getNode()

Returns the current node.

## Traversing a tree

### Yield

You can obtain the yield of a tree (i.e. the list of leaves in a pre-order traversal) using
the YieldVisitor.

For example, if `$node` is the tree built above, then

```php
use Tree\Visitor\YieldVisitor;

$visitor = new YieldVisitor;

$yield = $node->accept($visitor);
// $yield will contain nodes B, G, H, E, F
```

### Pre-order Traversal

You can walk a tree in pre-order:

```php
use Tree\Visitor\PreOrderVisitor;

$visitor = new PreOrderVisitor;

$yield = $node->accept($visitor);
// $yield will contain nodes A, B, C, D, G, H, E, F
```

### Post-order Traversal

You can walk a tree in post-order:

```php
use Tree\Visitor\PostOrderVisitor;

$visitor = new PostOrderVisitor;

$yield = $node->accept($visitor);
// $yield will contain nodes B, G, H, D, E, F, C, A
```

## Install

Run

```
$ composer require nicmart/tree
```

# Tests

```
phpunit
```

## Changelog

Please have a look at [`CHANGELOG.md`](CHANGELOG.md).

## Contributing

Please have a look at [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## License

This package is licensed using the MIT License.

Please have a look at [`LICENSE.md`](LICENSE.md).

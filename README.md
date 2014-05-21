# Tree [![Build Status](https://travis-ci.org/nicmart/Tree.png?branch=master)](https://travis-ci.org/nicmart/Tree)

In Tree you can find a basic but flexible tree data structure for php together with and an handful Builder class, that enables you to build tree in a fluent way.

## Changelog
 - 0.2.3 Node::getAncestors now does not return the current node ([Issue 4](https://github.com/nicmart/Tree/issues/4))
 - 0.2.2 Fixed a bug in the builder ([Issue 3](https://github.com/nicmart/Tree/issues/3))
 - 0.2.1 root() and isRoot() methods
 - 0.2.0 Dropped php 5.3 support. Node implemented as a trait.
 - 0.1.2 Added YieldVisitor, to get the yield of the tree
 - 0.1.1 Parent and neighbors methods (thanks to https://github.com/jdeniau)

## The tree data structure
The `Tree\NodeInterface` interface abstracts the concept of a tree node. In `Tree` a Node has essentially two things: 
a set of children (that implements the same `NodeInterface` interface) and a value.

On the other hand, the `Tree\Node` gives a straight implementation for that interface.

### Creating a node
```php
use Tree\Node;

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

$grandchild->getAncestors(); // Returns [$child, $root]
```

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

## Yield of a tree
You can obtain the yield of a tree (i.e. the list of leaves in a preorder traversal) using
the YieldVisitor.
For example, if `$node` is the tree builded above, then
 ```php
 use Tree\Visitor\YieldVisitor;
 $visitor = new YieldVisitor;

 $yield = $node->accept($visitor);
 // $yield will contain nodes B, G, H, E, F
 ```

## Install

The best way to install Tree is [through composer](http://getcomposer.org).

Just create a composer.json file for your project:

```JSON
{
    "require": {
        "nicmart/tree": "~0.2"
    }
}
```

Then you can run these two commands to install it:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install

or simply run `composer install` if you have have already [installed the composer globally](http://getcomposer.org/doc/00-intro.md#globally).

Then you can include the autoloader, and you will have access to the library classes:

```php
<?php
require 'vendor/autoload.php';
```

# Tests
```
phpunit
```

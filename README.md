# Tree

In Tree you can find a basic but flexible tree data structure for php together with and an handful Builder class, that enables you to build tree in a fluent way.

[![Build Status](https://travis-ci.org/nicmart/Tree.png?branch=master)](https://travis-ci.org/nicmart/Tree)

## Install

The best way to install Tree is [through composer](http://getcomposer.org).

Just create a composer.json file for your project:

```JSON
{
    "require": {
        "nicmart/tree": "dev-master"
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

## The Builder

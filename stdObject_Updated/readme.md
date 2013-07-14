stdObject Updated
=================
####Date : 14th Jul, 2013

This is the updated version of <code>stdObject</code> requires <code>PHP 5.4+</code>. This can inherit other <code>stdObjects</code> by reference and also supports cloning using <code>Clone</code> like old one.

### Some Examples are given below
```PHP
$cls = new Std\Std;
$cls->runTest = function(){
  //...
};
  
//Call Method
$cls->runTest();
```
Create an instance with some properties/methods using an array
```PHP
$args = array(
  'property' => 'SomeText',
  'testMethod' => function(){
	  return $this->property;
});

$anotherCls = new Std\Std($args);
echo $anotherCls->property; // SomeText
echo $anotherCls->testMethod(); // SomeText

// Add another method
$anotherCls->anotherTestMethod = function(){
    $this->property = 'New text';
 	return $this->property;
};

echo $anotherCls->property; // 'New text'
echo $anotherCls->anotherTestMethod(); // 'New text'
```
Create another object from <code>$anotherCls</code> and inherit (by reference) all it's functionalities and change/use.
```PHP
$newRef = new Std\Std($anotherCls);
$newRef->properties = 'Some newtext'

echo $newRef->testMethod(); // 'Some newtext'
echo $anotherCls->testMethod(); // 'Some newtext'
 ```
Copy/Clone a new one from old one (used Clone)
```PHP
$copiedobj = new Std($anotherCls. true);
$copiedobj->property = 'New value only for this';

// Changed in current instance
echo $copiedobj->property; // 'New value only for this'

// Not changed in current parent instance
echo $anotherCls->property; // 'Some newtext'
```
___
© 2013 Sheikh Heera. Licensed under MIT.
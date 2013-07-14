stdObject
=========

Php stdObject to add dynamic properties and methods

Just from my random thoughts and ideas I've created this class as stdObject. Using this it's possible to write code like javaScript in Php. For example, it allows to add properties and methods dynamically just like JavaScript. Examples given below :

```PHP
$array = array(
    'name' => 'Sheikh Heera',
		'age' => 35,
		'sex' => 'Male',
		'getInfo' => function() {
			  $info = '';
			  if(isset($this->name)) $info = 'Name : ' . $this->name;
			  if(isset($this->age))  $info .= 'Age : ' . $this->age;
			  if(isset($this->sex)) $info .= 'Sex : ' . $this->sex;
			  return $info;
		}
	);

	$obj = new stdObject($array);
	$obj->address = 'My Sweet Home!';
	echo $obj->getInfo();
	echo 'Address : ' . $obj->address;
```

Another Example  
```PHP
  $objNew = new stdObject($obj);
  $objNew->name = 'Robot';
	$objNew->getAge = function() {
		return $this->age;
	};
  
	echo 'New name : ' . $objNew->name;
	$objNew->address = "The Earth";
	echo 'Old Age : ' . $objNew->getAge();
	$objNew->age = 30;
	echo 'New Age : ' . $objNew->getAge();
	echo 'New Address : ' . $objNew->address;
```

Another Example
```PHP
  $foo = new stdObject();
  $foo->name = "Foo";
	echo 'Name of Foo : ' . $foo->name;
```

Example using stdObject as a trait
```PHP
  // Class stdObject
  class stdObject {
		use MethodBuilder;
	}

	// Class bar
	class Bar {
		use MethodBuilder;

		public function foo()
		{
			echo "I'm new foo !";
		}
	}
  
  
  $newFoo = new Bar;
  $newFoo->baz = "Hello World!";
	$newFoo->showBaz = function(){
		return $this->baz;
	};
  
  
  echo $newFoo->foo();
  echo $newFoo->showBaz();
```
stdObject Updated
=================
This is the updated version of <code>stdObject</code> required <code>PHP 5.4+</code>. This can inherit other <code>stdObjects</code> by reference and also supports cloning too.

### Some Examples are given below
```PHP
$cls = new Std\Std;
$cls->runTest = function(){
  //...
};
  
//Call Method
$cls->runTest();
```
### Create an instance with some properties/methods using an array
```PHP
$args = array(
  'property' => 'SomeText',
  'testMethod' => function(){
	  return $this->property;
});

$anotherCls = new Std\Std($args);
echo $anotherCls->property; // SomeText
echo $anotherCls->testMethod(); // SomeText

// Add another methopd
$anotherCls->anotherTestMethod = function(){
    $this->property = 'New text';
 	return $this->property;
};
```
### Create another object from <code>$anotherCls</code> and inherit (by reference) all it's functionalities and change/use.
```PHP
$newRef = new Std\Std($anotherCls);
$newRef->properties = 'Some newtext'

echo $newRef->testMethod(); // 'Some newtext'
echo $anotherCls->testMethod(); // 'Some newtext'
 ```
### Copy/Clone a new one from old one (used Clone)
```PHP
$copiedobj = new Std($anotherCls. true);
$copiedobj->property = 'New value only for this';

// Changed in current instance
echo $copiedobj->property; // 'New value only for this'

// Not changed in current parent instance
echo $anotherCls->property; // 'Some newtext'
```
stdObject
=========

Php stdObject to add dynamic properties and methods

Just from my random thoughts and ideas I've created this class as stdObject. Using this it's possible to write code like javaScript in Php. For example, it allows to add properties and methods dynamically just like JavaScript. Examples given below :


<<<<<<< HEAD
=======

>>>>>>> 95cd8770c3ef6b016e9b8841fc7d3e8d91d9e6a2
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
<<<<<<< HEAD

stdObject Updated
=================
=======
>>>>>>> 95cd8770c3ef6b016e9b8841fc7d3e8d91d9e6a2
  
  

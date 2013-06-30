<?php

// Trait MethodBuilder
trait MethodBuilder {

	/**
      * The prototype array to hold properties.
      *
      * @var array
      */

    private $prototype = array();

    /**
      * Create a new stdObject instance.
      *
      * @param  array|object (instance of stdObject)
      * @return void
      */

    public function __construct($param = null)
    {
        try{
            if(!is_null($param) && is_array($param)) {
                foreach ($param as $key => $value) {
                    if(is_callable($value)) {
                        $this->prototype[$key] = $value->bindTo($this);
                    }
                    elseif(is_scalar($value) || is_array($value)) {
                        $this->prototype[$key] = $value;
                    }
                }
            }
            elseif (is_object($param)) {
                foreach ($param->prototype as $key => $value) {
                    if(is_callable($value)) {
                        $this->prototype[$key] = $value->bindTo($this);
                    }
                    elseif(is_scalar($value) || is_array($value)) {
                        $this->prototype[$key] = $value;
                    }
                }
            }
        }
	catch(Exception $e) {
            echo $e->getMessage() . '<br />';
            var_dump($e->getTraceAsString());
            exit;
        }
    }

    /**
      * Check if a property/method is set in the prototype array.
      *
      * @param  string $key
      * @return void
      */
    
    public function __isset($key)
    {
        return isset($key);
    }

    /**
      * Set a property/method in the prototype array using $key => $value.
      *
      * @param  string $key
      * @param  mixed $value
      * @return void
      */
    
    public function __set($key, $value)
    {
        try{
            if(is_callable($value)) {
                $this->prototype[$key] = $value->bindTo($this);
            }
            elseif(is_scalar($value) || is_array($value)) {
                $this->prototype[$key] = $value;
            }
            else {
                throw new RunTimeException("Invalid data type <strong>{$value}</strong> given!");
            }
        }
        catch(RunTimeException $e) {
            echo $e->getMessage() . '<br />';
            var_dump($e->getTraceAsString());
            exit;
        }
    }

    /**
      * Retrieve a property/method from the prototype array using $key.
      *
      * @param  string $key
      * @return mixed
      */

    public function __get($key)
    {
        try{
            if(isset($this->prototype[$key])) {
                return $this->prototype[$key];
            }
            else {
                throw new RunTimeException("Property '{$key}' doesn't exist !");
            }
        }
        catch(RunTimeException $e) {
            echo $e->getMessage() . '<br />';
            var_dump($e->getTraceAsString());
            exit;
        }
    }

    /**
      * Call a method that is available in the prototype array.
      *
      * @param  string $methodname
      * @param  array $args
      * @return mixed
      */

    public function __call($methodName, array $args)
    {
        try{
            if (isset($this->prototype[$methodName])) {
                return call_user_func_array($this->prototype[$methodName], $args);
            }
            else{
                throw new RunTimeException("Method <strong>{$methodName}</strong> doesn't exist !");
            }
        }
        catch(RunTimeException $e) {
            echo $e->getMessage() . '<br />';
            var_dump($e->getTraceAsString());
            exit;
        }
    }
}

	
// Examples :

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


	
	$array = array(
		'name' => 'Sheikh Heera',
		'age' => 35,
		'sex' => 'Male',
		'getInfo' => function() {
			$info = '';
			if(isset($this->name)) $info = 'Name : ' . $this->name .'<br />';
			if(isset($this->age))  $info .= 'Age : ' . $this->age . '<br />';
			if(isset($this->sex)) $info .= 'Sex : ' . $this->sex . '<br />';
			return $info;
		}
	);

	$obj = new stdObject($array);
	$obj->address = 'My Sweet Home!';
	echo $obj->getInfo();
	echo 'Address : ' . $obj->address;

	echo '<br />';
	
	$objNew = new stdObject($obj);
	$objNew->name = 'Robot';
	$objNew->getAge = function() {
		return $this->age;
	};
	echo '<br />';
	echo 'New name : ' . $objNew->name;
	echo '<br />';
	$objNew->address = "The Earth";
	echo 'Old Age : ' . $objNew->getAge();
	echo '<br />';
	$objNew->age = 30;
	echo 'New Age : ' . $objNew->getAge();
	echo '<br />';
	echo 'New Address : ' . $objNew->address;
	
	echo '<br /><br />';

	$foo = new stdObject();
	$foo->name = "Foo";
	echo 'Name of Foo : ' . $foo->name;
	echo '<br />';

	$newFoo = new Bar;
	$newFoo->baz = "Hello World!";
	$newFoo->showBaz = function(){
		return $this->baz;
	};

	$anStdObj = new stdObject(array('greet'=>'Hello!'));
	echo $anStdObj->greet;
	echo '<br />';

	echo $newFoo->foo();
	echo '<br />';
	echo $newFoo->showBaz();
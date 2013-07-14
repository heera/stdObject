<?php namespace StdObject;

/**
 * [MIT Licensed](http://www.opensource.org/licenses/mit-license.php)
 * Copyright (c) 2013 Sheikh Heera
 * 
 * Implements a dynamic configuration manager for any php application.
 *  
 * Compatible with PHP 5.3.0+
 * 
 * @author Sheikh Heera <mail@heera.it>
 */

/**
 * This class gives the ability to add
 * methods and properties on the runtime.
 *
 * Simple examples below :
 * 
 * $cls = new Std\Std;
 * $cls->runTest = function(){
 * 	  //...
 * };
 * 
 * //Call Method
 * $cls->runTest();
 * 
 * //Create an instance with some
 * //properties/methods using an array
 * 
 * $args = array(
 * 	  'property' => 'SomeText',
 * 	  'testMethod' => function(){
 *    	  return $this->property;
 * });
 * 
 * $anotherCls = new Std\Std($args);
 * echo $anotherCls->property; // SomeText
 * echo $anotherCls->testMethod(); // SomeText
 * 
 * // Add another methopd
 * $anotherCls->anotherTestMethod = function(){
 * 	  $this->property = 'New text';
 * 	  return $this->property;
 * };
 *
 * echo $anotherCls->property; // 'New text'
 * echo $anotherCls->anotherTestMethod(); // 'New text'
 * 
 * // Create another object from $anotherCls
 * // and inherit (by reference) all it's
 * // functionalities and change/use.
 * 
 * $newRef = new Std\Std($anotherCls);
 * $newRef->properties = 'Some newtext'
 * 
 * echo $newRef->testMethod(); // 'Some newtext'
 * echo $anotherCls->testMethod(); // 'Some newtext'
 *
 * // Copy/Clone a new one from old one (used Clone)
 * $copiedobj = new Std($anotherCls. true);
 * $copiedobj->property = 'New value only for this';
 *
 * // Changed in current instance
 * echo $copiedobj->property; // 'New value only for this'
 * 
 * // Not changed in current parent instance
 * echo $anotherCls->property; // 'Some newtext'
 * 
 * Class Std
 *
 */

class Std {

	/**
	 * $prototype Main properties/methods
	 * holder, an  instanse of StdClass
	 * @var [stdClass]
	 */
	public $prototype = null;
	
	/**
	 * [$_name  Obejct's internal private property]
	 * @var [string]
	 */
	private $_name = null;
	
	/**
	 * Constructor, construct the Std object with array/Std object
	 * $clone false by default, it determines whether to extend or
	 * clone an object to create a new Std object, true for cloning
	 * 
	 * @param [string]  $instanceName [A name for the current instance]
	 * @param [mixed]   $array        [An array or Std object]
	 * @param boolean   $clone        [Default FALSE, TRUE if want to copy an existing instance]
	 */
	public function __construct($instanceName = null, $array = null, $clone = false)
	{
		//ini_set('display_errors', -1);
		set_exception_handler(array($this, '__exceptionHandler'));

		if(is_null($instanceName)){
			exit($instanceName);
		}

		$this->_name = $instanceName;
		$this->prototype = new \stdClass;

		if(!is_null($array) && is_array($array)){
			foreach ($array as $key => $value) {
				$this->prototype->$key = $value;
			}
		}
		elseif (is_object($array) && $array instanceof Std) {
			if(!$clone){
				$this->prototype = &$array->prototype;
			}
			else{
				$this->prototype = clone $array->prototype;
			}
		}
	}

	/**
	 * [__set Setter, Sets properties and methods]
	 * @param [string] $key   [Namne for the property]
	 * @param [mixed]  $value [Value for the property]
	 */
	public function __set($key, $value)
	{
		if(substr($key, 0, 1) == '_') {
			$this->$key = $value;
		}
		else {
			$this->prototype->$key = $value;
		}
	}

	/**
	 * __get Returns a property either from
	 * prototype property (stdobject) or from
	 * this when private properties, all private
	 * properties should have (_) as prefix
	 * 
	 * @param  @param [string] $key   [Namne for the property]
	 * @return [mixed]      
	 */
	public function __get($key)
	{
		if(isset($this->prototype->$key)){
			return $this->prototype->$key;
		}
		elseif(isset($this->{'_'. $key})) {
				return $this->{'_'. $key};
		}
		else{
        	throw new \Exception("Property :$key: doesn't exist", 1);
        }
    }

	/**
	 * [__call This method calls all methods]
	 * @param  [string] $method [Name of the method]
	 * @param  [array] $args    [Arguments for the method]
	 * @return [mixed]
	 */
	public function __call($method, $args)
	{
		if (isset($this->prototype->$method)) {
			$func = $this->prototype->$method->bindTo($this);
            return call_user_func_array($func, $args);
        }
        else{
        	throw new \Exception("Method :$method:<strong>()</strong> doesn't exist", 1);
        	
        }
	}


	/**
	 * Unset an item (property/method)
	 * from prototype, when unset called
	 * @param [string] $key [Key name to unset]
	 */
	public function __unset($key)
	{
		unset($this->prototype->$key);
	}

	/**
	 * [__exceptionHandler Custom Exception Handler for this class]
	 * @param  [object] $e [Exception object]
	 * @return [string]    [Prints the error and terminates the execution]
	 */
	public function __exceptionHandler($e)
	{
		$trace = $e->getTrace();
	    $result = ' Exception : <span style="color:red">';
	    $result .=  preg_replace_callback("/:.*:/is", function($m) { return "<strong>" . str_replace(':', '', $m[0]) . "</strong>"; }, $e->getMessage());
	    $result .= '</span> in file "';
	    if($trace[0]['file'] != '') {
	      $result .= $trace[0]['file'];
	    }
	    $result .= '" at line : <strong>' . $trace[0]['line'] . '</strong>';
	    echo $result;
	    exit;
	}

	/**
	 * getInstanceName Returns the name of the current
	 * that was given during the instance initialization
	 * @return [string] [Name of the current instance]
	 */
	public function getInstanceName()
	{
		return $this->_name;
	}

	/**
	 * [getInstanceLength Returns the total
	 * number of the members of the object
	 * @return [int] [count of properties/methods]
	 */
	public function getInstanceLength()
	{
		return count((Array)$this->prototype);
	}

	/**
	 * [__toString magic method]
	 * @return string [Name of thr current instance]
	 */
	public function  __toString()
	{
		return $this->_name;
	}
}


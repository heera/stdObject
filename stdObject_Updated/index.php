<?php

/**
 * Some Tests
 */

// Include the Class
include "StdObject.php";
use StdObject\Std;


// First Instance
$arr = array('firstName' => 'Sheikh', 'lastName' => 'Heera');
$std = new Std('stdOne', $arr);
$std->prop = '<br />Hello';
$std->getName = function() {
	return $this->prop . ' ' . $this->firstName . ' ' . $this->lastName;
};
echo $std->getName();

// Second Instance derived from first instance
$newStd = new Std('stdtwo', $std);
$newStd->lastName = 'Hero<br />';
$newStd->name = 'Mr. Hero';
echo $std->getName();
echo $std->name;
$std->prop = '<br />Hellos<br />';
echo $newStd->prop;
$newStd->prop = '--<br />';
echo $newStd->prop;
echo $std->prop; 

$newStd->another = 'Another<br />';
echo $std->another;

$std->another = 'New Another<br />';
echo $newStd->another;
echo $newStd->getName();

// Third Instance derived from second instance
$anObj = new Std('stdthree', $newStd);

echo $anObj->getName();
$anObj->prop = '===<br />';
echo $anObj->prop;
echo $std->prop;
$anObj->pop = 'Pop<br />';
echo $anObj->pop;
echo $std->pop;

// Fourth Instance derived from third instance
$x = new Std('stdFour', $anObj);
$x->firstName = 'Ansar Uddin Heera';
$x->lastName = 'Heera Lal<br />';
echo $x->getName();
echo $std->getName();
echo $std->lastName;

// cloning, true for cloning, default false
$cls = new Std($std, true);
$cls->firstName = 'Mr';
$cls->lastName = 'Sheikh<br />';
$cls->prop = 'Howdy ';
$cls->getName = function(){
	return $this->prop . $this->firstName . ' ' . $this->lastName;
};
echo $cls->getName();
echo $std->getName();

// Derive from cloned object
echo '<br />';
$clsNew = new Std('stdSix', $cls);
echo $clsNew->getName();

$clsNew->firstName = 'Muhammad';
$clsNew->lastName = ' Usman<br />';
echo $clsNew->getName();

$clsNew->prop = 'Hey ';
$clsNew->getName = function(){
	$this->prop = 'Halo ';
	$this->firstName = 'Sir ';
	return $this->prop . $this->firstName . ' ' . $this->lastName;
};

echo $cls->getName();
$clsNew->run = function(){
	echo 'Running...<br />';
};

$cls->run();
$x->run = $cls->run;
$std->run();
$x->run = function(){
	echo 'Running from X<br />';
};

$std->run();
$cls->run();

unset($cls->prop);

echo "<br />";
echo $cls->getName();
echo "<br />";
echo $cls->getInstanceName();
echo "<br />";
echo $cls->getInstanceLength();
echo "<br />";
var_dump($clsNew);
echo "<br />";
echo $clsNew->getName();
echo "<br />";
echo $clsNew->getInstanceName();
echo "<br />";
echo $clsNew->getInstanceLength();
echo "<br />";
$clsNew->_privateProp = 'privateprop';
echo "<br />";
var_dump($clsNew);
echo "<br />";
echo $clsNew->privateProp;
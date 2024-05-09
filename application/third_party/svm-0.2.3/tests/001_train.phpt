--TEST--
Load training data from a file. 
--SKIPIF--
<?php
if (!extension_loaded('svm')) die('skip');
?>
--FILE--
<?php
$svm = new svm();
$result = $svm->train(dirname(__FILE__) . '/australian.scale');

try {
	$result->save(dirname(__FILE__) . '/australian.model');
	echo "ok";
} catch (SvmException $e) {
	echo $e->getMessage();
}

?>
--EXPECT--
ok

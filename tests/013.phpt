--TEST--
Object-Array test
--SKIPIF--
--FILE--
<?php
if(!extension_loaded('msgpack')) {
    dl('msgpack.' . PHP_SHLIB_SUFFIX);
}

function test($type, $variable, $test) {
    $serialized = msgpack_serialize($variable);
    $unserialized = msgpack_unserialize($serialized);

    echo $type, PHP_EOL;
    echo bin2hex($serialized), PHP_EOL;
    var_dump($unserialized);
    echo $test || $unserialized == $variable ? 'OK' : 'ERROR', PHP_EOL;
}

class Obj {
    var $a;
    var $b;

    function __construct($a, $b) {
        $this->a = $a;
        $this->b = $b;
    }
}

$o = array(new Obj(1, 2), new Obj(3, 4));


test('object', $o, false);
?>
--EXPECTF--
object
9283c0a34f626aa16101a1620283c0a34f626aa16103a16204
array(2) {
  [0]=>
  object(Obj)#%d (2) {
    ["a"]=>
    int(1)
    ["b"]=>
    int(2)
  }
  [1]=>
  object(Obj)#%d (2) {
    ["a"]=>
    int(3)
    ["b"]=>
    int(4)
  }
}
OK

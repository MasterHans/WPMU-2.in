<?php

/**
 * Class MyClass
 * @author
 *
 */
class MyClass
{
    public $prop1 = "I'm a class property!";

    public static $count = 0;

    public $count_public = 0;

    public function __construct()
    {
        echo 'The class "', __CLASS__, '" was initiated!<br />';
    }

    public function __destruct()
    {
        echo 'The class "', __CLASS__, '" was destroyed.<br />';
    }

    public function __toString()
    {
        echo "Using the toString method: ";
        return $this->getProperty();
    }

    public function setProperty($newval)
    {
        $this->prop1 = $newval;
    }

    private function getProperty()
    {
        return $this->prop1 . "<br />";
    }

    public static function plusOne()
    {
        return "The count is " . ++self::$count . ".<br />";
    }

    public function plusOnePublic()
    {
        return "The count is " . ++$this->count_public . ".<br />";
    }
}

/**
 * Class MyOtherClass
 */
class MyOtherClass extends MyClass
{
    public function __construct()
    {
        parent::__construct();
        echo "A new constructor in " . __CLASS__ . ".<br />";
    }

    public function newMethod()
    {
        echo "From a new method in " . __CLASS__ . ".<br />";
    }

    public function callProtected()
    {
        return $this->getProperty();
    }
}

$obj = new MyClass();
do {
// Call plusOne without instantiating MyClass
    echo $obj->plusOnePublic();
} while ($obj->count_public < 10);

/**
 * "One of the major benefits to using static properties is that they keep their stored values for the duration of the script."
 * TODO ask in discussion
 */

?>
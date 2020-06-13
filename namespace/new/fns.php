<?php
namespace App\newfns;
class A{
    private $name='';
    public function __construct($name)
    {
        $this->name=$name;
        echo "New/fns class A".$this->name;
    }
}

?>
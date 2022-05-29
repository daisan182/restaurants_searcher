<?php
class Human
{
    static $class_name = "Human";
    
    function init(){
        $this->name = "大泉";
    }
    
    public function show() {
        print($this->name."/n");
    }
}
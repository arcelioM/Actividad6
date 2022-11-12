<?php

namespace model;

class Status{
    private int $idStatus;

    private String $name;

    public function __construct(int $idStatus, String $name)
    {
        $this->idStatus = $idStatus;
        $this->name = $name;
    }

    public function __get($name){
        if(property_exists($this,$name)){
           return $this->$name;
        }
     }
 
     public function __set($name,$value){
        if(property_exists($this,$name)){
           return $this->$name=$value;
        }
     }

    
}

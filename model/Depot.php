<?php

namespace model;

use model\Status;
class Depot{
    private ?int $idDepot;

    private ?String $branchName;

    private ?String $location;

    private ?Status $status;

    public function __construct(int $idDepot=0,String $branchName="",String $location="", Status $Status=null){
        $this->idDepot = $idDepot;
        $this->branchName = $branchName;
        $this->location = $location;
        $this->Status = $Status;
    }

    public function &__get($name){
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

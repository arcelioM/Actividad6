<?php

namespace model;

use model\Status;
class Depot{
    private int $idDepot;

    private String $branchName;

    private String $location;

    private Status $Status;

    public function __construct(int $idDepot,String $branchName,String $location, Status $Status){
        $this->idDepot = $idDepot;
        $this->branchName = $branchName;
        $this->location = $location;
        $this->Status = $Status;
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

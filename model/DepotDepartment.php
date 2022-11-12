<?php

namespace model;

use model\Status;
use model\Deparment;
use model\Depot;

class DepotDepartment{
    private ?int $idDepotDepartment;

    private ?Depot $depot;

    private ?Deparment $deparment;

    private ?int $maxCapacity;

    private $creationDate;

    private ?Status $status;

    public function __construct(int $idDepotDepartment=0,Depot $depot=null,Deparment $deparment=null,int $maxCapacity=0, $creationDate=null,Status $status=null)
    {
        $this->idDepotDepartment = $idDepotDepartment;
        $this->depot = $depot;
        $this->deparment = $deparment;
        $this->maxCapacity = $maxCapacity;
        $this->creationDate = $creationDate;
        $this->status = $status;
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

<?php

namespace model;

class Deparment{
    private ?int $idDepartment;

    private ?String $name;

    private ?Status $status;

    private  $creationDate;

    public function __construct(int $idDepartment=0, String $name="",Status $status=null, $creationDate=null)
    {
        $this->idDepartment = $idDepartment;
        $this->name = $name;
        $this->status = $status;
        $this->creationDate = $creationDate;
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

<?php

namespace model;

use DateTime;

class Deparment{
    private int $idDepartment;

    private String $name;

    private Status $status;

    private  $creationDate;

    public function __construct(int $idDepartment, String $name,Status $status, $creationDate)
    {
        $this->idDepartment = $idDepartment;
        $this->name = $name;
        $this->status = $status;
        $this->creationDate = $creationDate;
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

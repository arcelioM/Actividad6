<?php

namespace model;

use model\Status;
class TypeProduct{
    private ?int $idTypeProduct;

    private ?String $name;

    private ?Status $status;

    private $creationDate;

    public function __construct(int $idTypeProduct=0, String $name="",Status $status=null, $creationDate=null)
    {
        $this->idTypeProduct = $idTypeProduct;
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

<?php

namespace model;

use model\Status;
use model\TypeProduct;

class Product{
    private int $idProduct;

    private String $name;

    private TypeProduct $typeProduct;

    private float $price;

    private $experationDate;

    private $creationDate;

    private Status $status;

    public function __construct(int $idProduct,String $name,TypeProduct $typeProduct,float $price, $experationDate, $creationDate,Status $status)
    {
        $this->idProduct = $idProduct;
        $this->name = $name;
        $this->typeProduct = $typeProduct;
        $this->price = $price;
        $this->experationDate = $experationDate;
        $this->creationDate = $creationDate;
        $this->status = $status;
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

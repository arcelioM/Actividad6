<?php

namespace model;

use model\Status;
use model\DepotDepartment;
use model\Product;
class DepotProduct{
    private int $idDepotProduct;

    private Product $product;

    private DepotDepartment $depotDepartment;

    private Status $status;

    private int $quantity;

    private $creationDate;

    public function __construct(int $idDepotProduct, $product, $depotDepartment, $status, $quantity, $creationDate)
    {
        $this->idDepotProduct = $idDepotProduct;
        $this->product = $product;
        $this->depotDepartment = $depotDepartment;
        $this->status = $status;
        $this->quantity = $quantity;
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

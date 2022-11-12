<?php

namespace model;

use model\Status;
class TypeProduct{
    private int $idTypeProduct;

    private String $name;

    private Status $status;

    private $creationDate;

    public function __construct(int $idTypeProduct, String $name,Status $status, $creationDate)
    {
        $this->idTypeProduct = $idTypeProduct;
        $this->name = $name;
        $this->status = $status;
        $this->creationDate = $creationDate;
    }


}

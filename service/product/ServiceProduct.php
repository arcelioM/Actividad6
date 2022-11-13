<?php

namespace service\product;

use dao\product\IDaoProduct;
use model\Product;
use model\Status;
use model\TypeProduct;
use service\product\IServiceProduct;
class ServiceProduct implements IServiceProduct{

    private IDaoProduct $dao;

    public function __construct(IDaoProduct $dao){
        $this->dao=$dao;
    }


    public function getAll(): array{

        $products=$this->dao->getAll();

        $productsReturn=array(
            "Info"=>"Datos de Product",
            "values"=>$products  
        );

        return $productsReturn;
    }

    /**
     * *DEVOLVERA EL Product QUE SE BUSCA POR ID
     * *Verifica que el ID tenga un valor correcto para la busqueda
     * *Si no tiene un ID valido, devolvera un array de error
     * *Converti el resultado de busqueda a array asociativo, para que no se mostrar como un array de un objeto, sino como solo un objeto json
     */
    public function getByID($id):array{

        if($id==null || $id<=0){
            $responseError = array(
                "Info"=>"Product",
                "value"=>"ID no valido"
            );
            return $responseError;
        }

        $product = $this->dao->getByID($id);

        $productOne=array();
        foreach($product as $value){
            $productOne=array(
                "ID_PRODUCT"=> $value["ID_PRODUCT"],
                "name"=>$value["name"],
                "idTypeProduct"=>$value["idTypeProduct"],
                "price"=>$value["price"],
                "experationDate"=>$value["experationDate"],
                "idStatus"=>$value["idStatus"]
            );
        }

        $productReturn = array(
            "Info"=>"Product",
            "values"=>$productOne
        );

        return $productReturn;
    }

    /**
     * @param  array $entidad Array con la informacion necesaria para guardar datos status
     * @return int 1  insercion es exitosa
     * @return int 0  fallo de insercion
     */
    public function save($entidad): array{

        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["name"]) || empty($entidad["idTypeProduct"]) || empty($entidad["price"]) || empty($entidad["experationDate"]) || empty($entidad["idStatus"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $product = new Product();
        $product->name = $entidad["name"];
        $product->typeProduct = new TypeProduct(idTypeProduct:$entidad["idTypeProduct"]);
        $product->price = $entidad["price"];
        $product->experationDate = $entidad["experationDate"];
        $product->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->save($product);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }

    }

    /**
     * @param  array $entidad Array con la informacion necesaria para actualizar datos status
     * @return int 1  actualizacion es exitosa
     * @return int 0  fallo de actualizacion
     */
    public function update($entidad): array{

        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["idProduct"]) || empty($entidad["name"]) || empty($entidad["idTypeProduct"]) || empty($entidad["price"]) || empty($entidad["experationDate"]) || empty($entidad["idStatus"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $product = new Product(idProduct:$entidad["idProduct"]);
        $product->name = $entidad["name"];
        $product->typeProduct = new TypeProduct(idTypeProduct:$entidad["idTypeProduct"]);
        $product->price = $entidad["price"];
        $product->experationDate = $entidad["experationDate"];
        $product->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->update($product);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }

    public function changeStatus( $entidad): array{
        
        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["idProduct"]) || empty($entidad["idStatus"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $product = new Product(idProduct:$entidad["idProduct"]);
        $product->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->changeStatus($product);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }

}

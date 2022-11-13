<?php

namespace service\typeProduct;

use dao\typeProduct\IDaoTypeProduct;
use model\Status;
use model\TypeProduct;
use service\typeProduct\IServiceTypeProduct;

class ServiceTypeProductImpl implements IServiceTypeProduct{

    private IDaoTypeProduct $dao;

    public function __construct(IDaoTypeProduct $dao){
        $this->dao = $dao;
    }


    public function getAll(): array{

        $typeProducts=$this->dao->getAll();

        $typeProductsReturn=array(
            "Info"=>"Datos de TypeProduct",
            "values"=>$typeProducts  
        );

        return $typeProductsReturn;
    }

    /**
     * *DEVOLVERA EL TYPEPRODUCT QUE SE BUSCA POR ID
     * *Verifica que el ID tenga un valor correcto para la busqueda
     * *Si no tiene un ID valido, devolvera un array de error
     * *Converti el resultado de busqueda a array asociativo, para que no se mostrar como un array de un objeto, sino como solo un objeto json
     */
    public function getByID($id):array{

        if($id==null || $id<=0){
            $responseError = array(
                "Info"=>"TypeProduct",
                "value"=>"ID no valido"
            );
            return $responseError;
        }

        $typeProduct = $this->dao->getByID($id);

        $typeProductOne=array();
        foreach($typeProduct as $value){
            $typeProductOne=array(
                "ID_TYPE_PRODUCT"=> $value["ID_TYPE_PRODUCT"],
                "name"=>$value["name"],
                "idStatus"=>$value["idStatus"],
                "creationDate"=>$value["creationDate"]
            );
        }

        $typeProductReturn = array(
            "Info"=>"Department",
            "values"=>$typeProductOne
        );

        return $typeProductReturn;
    }

    /**
     * @param  array $entidad Array con la informacion necesaria para guardar datos typeProduct
     * @return int 1  insercion es exitosa
     * @return int 0  fallo de insercion
     */
    public function save($entidad): array{

        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["name"]) || empty($entidad["idStatus"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $typeProduct = new TypeProduct();
        $typeProduct->name = $entidad["name"];
        $typeProduct->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->save($typeProduct);

        

        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }

    }

    /**
     * @param  array $entidad Array con la informacion necesaria para actualizar datos typeProduct
     * @return int 1  actualizacion es exitosa
     * @return int 0  fallo de actualizacion
     */
    public function update($entidad): array{

        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["name"]) || empty($entidad["idStatus"]) || empty($entidad["idTypeProduct"])){
            
            $response["value"]="datos no validos";
            return $response;
        }



        $typeProduct = new TypeProduct();
        $typeProduct->idTypeProduct=$entidad["idTypeProduct"];
        $typeProduct->name = $entidad["name"];
        $typeProduct->status = new Status(idStatus:$entidad["idStatus"]);
        

        $rowAffected=$this->dao->update($typeProduct);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }

    /**
     * @param  array $entidad Array con la informacion necesaria para cambiar estado  typeProduct
     * @return int 1  actualizacion es exitosa
     * @return int 0  fallo de actualizacion
     */
    public function changeStatus($entidad): array{
        
        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["idStatus"]) || empty($entidad["idTypeProduct"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $typeProduct = new TypeProduct();
        $typeProduct->idDepartment=$entidad["idTypeProduct"];
        $typeProduct->status = new Status(idStatus:$entidad["idStatus"]);
        

        $rowAffected=$this->dao->changeStatus($typeProduct);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }
}

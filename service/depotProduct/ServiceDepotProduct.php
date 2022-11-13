<?php

namespace service\depotProduct;

use dao\depotProduct\IDaoDepotProduct;
use model\DepotDepartment;
use model\DepotProduct;
use model\Product;
use model\Status;
use service\depotProduct\IServiceDepotProduct;

class ServiceDepotProduct implements IServiceDepotProduct{


    private IDaoDepotProduct $dao;

    public function __construct(IDaoDepotProduct $dao){
        $this->dao=$dao;
    }


    public function getAll(): array{

        $depotProducts=$this->dao->getAll();

        $statusReturn=array(
            "Info"=>"Datos de DepotProduct",
            "values"=>$depotProducts  
        );

        return $statusReturn;
    }

    /**
     * *DEVOLVERA EL DepotProduct QUE SE BUSCA POR ID
     * *Verifica que el ID tenga un valor correcto para la busqueda
     * *Si no tiene un ID valido, devolvera un array de error
     * *Converti el resultado de busqueda a array asociativo, para que no se mostrar como un array de un objeto, sino como solo un objeto json
     */
    public function getByID($id):array{

        if($id==null || $id<=0){
            $responseError = array(
                "Info"=>"DepotProduct",
                "value"=>"ID no valido"
            );
            return $responseError;
        }

        $depotProduct = $this->dao->getByID($id);

        $depotProductOne=array();
        foreach($depotProduct as $value){
            $depotProductOne=array(
                "ID_DEPOT_PRODUCT"=> $value["ID_DEPOT_PRODUCT"],
                "idProduct"=>$value["idProduct"],
                "idDepotDepartment"=>$value["idDepotDepartment"],
                "quantiy"=>$value["quantity"],
                "idStatus"=>$value["idStatus"],
                "creationDate"=>$value["creationDate"]
            );
        }

        $depotProductReturn = array(
            "Info"=>"DepotProduct",
            "values"=>$depotProductOne
        );

        return $depotProductReturn;
    }

    /**
     * 
     * *Values : null si la insercion fallo, o no queda espacio
     * *Values : 0 si fue exitoso
     * *Value : ? cantidad de espacio disponible
     */
    public function save($entidad): array{

        $response = array(
            "Info"=> "Respuesta"
        );

        if($entidad==null || empty($entidad["idProduct"]) || empty($entidad["idDepotDepartment"]) || empty($entidad["quantity"]) || empty($entidad["idStatus"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $depotProduct = new DepotProduct();
        $depotProduct->product = new Product(idProduct:$entidad["idProduct"]);
        $depotProduct->depotDepartment = new DepotDepartment(idDepotDepartment:$entidad["idDepotDepartment"]);
        $depotProduct->quantity = $entidad["quantity"];
        $depotProduct->status = new Status(idStatus:$entidad["idStatus"]);
        $rowResponse=$this->dao->save($depotProduct);


        if($rowResponse==null){
            $response["value"]=null;
            return $response;
        }else{
            $response["value"]=$rowResponse;
            return $response;
        }

    }

    /**
     * @param  array $entidad Array con la informacion necesaria para actualizar datos depotProduct
     * @return int 1  actualizacion es exitosa
     * @return int 0  fallo de actualizacion
     */
    public function update($entidad): array{

        $response = array(
            "Info"=> "Respuesta"
        );

        if($entidad==null || empty($entidad["idProduct"]) || empty($entidad["idDepotDepartment"]) || empty($entidad["quantity"]) || empty($entidad["idStatus"]) || empty($entidad["idDepotProduct"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $depotProduct = new DepotProduct(idDepotProduct:$entidad["idDepotProduct"]);
        $depotProduct->product = new Product(idProduct:$entidad["idProduct"]);
        $depotProduct->depotDepartment = new DepotDepartment(idDepotDepartment:$entidad["idDepotDepartment"]);
        $depotProduct->quantity = $entidad["quantity"];
        $depotProduct->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->update($depotProduct);



        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }

    /**
     * @param  array $entidad Array con la informacion necesaria para cambiar status
     * @return int 1  actualizacion es exitosa
     * @return int 0  fallo de actualizacion
     */
    public function changeStatus($entidad): array{
        
        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["idStatus"]) || empty($entidad["idDepotProduct"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $depotProduct = new DepotProduct();
        $depotProduct->idDepotProduct=$entidad["idDepotProduct"];
        $depotProduct->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->changeStatus($depotProduct);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }
}

?>
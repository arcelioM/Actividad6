<?php

namespace service\depot;

use dao\depot\IDaoDepot;
use model\Depot;
use model\Status;

class ServiceDepotImpl{

    private IDaoDepot $dao;

    public function __construct(IDaoDepot $dao){
        $this->dao=$dao;
    }


    public function getAll(): array{

        $depots=$this->dao->getAll();

        $depotsReturn=array(
            "Info"=>"Datos de Depot",
            "values"=>$depots  
        );

        return $depotsReturn;
    }

    /**
     * *DEVOLVERA EL DEPOT QUE SE BUSCA POR ID
     * *Verifica que el ID tenga un valor correcto para la busqueda
     * *Si no tiene un ID valido, devolvera un array de error
     * *Converti el resultado de busqueda a array asociativo, para que no se mostrar como un array de un objeto, sino como solo un objeto json
     */
    public function getByID($id):array{

        if($id==null || $id<=0){
            $responseError = array(
                "Info"=>"Depot",
                "value"=>"ID no valido"
            );
            return $responseError;
        }

        $depot = $this->dao->getByID($id);

        $depotOne=array();
        foreach($depot as $value){
            $depotOne=array(
                "ID_DEPOT"=> $value["ID_DEPOT"],
                "branchName"=>$value["branchName"],
                "idStatus"=>$value["idStatus"],
                "location"=>$value["location"]
            );
        }

        $depotReturn = array(
            "Info"=>"Depot",
            "values"=>$depotOne
        );

        return $depotReturn;
    }

    /**
     * @param  array $entidad Array con la informacion necesaria para guardar datos depot
     * @return int 1  insercion es exitosa
     * @return int 0  fallo de insercion
     */
    public function save($entidad): array{

        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["branchName"]) || empty($entidad["idStatus"]) || empty($entidad["location"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $depot = new Depot();
        $depot->branchName = $entidad["branchName"];
        $depot->Status = new Status(idStatus:$entidad["idStatus"]);
        $depot->location=$entidad["location"];
        $rowAffected=$this->dao->save($depot);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }

    }

    /**
     * @param  array $entidad Array con la informacion necesaria para actualizar datos depot
     * @return int 1  actualizacion es exitosa
     * @return int 0  fallo de actualizacion
     */
    public function update($entidad): array{

        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["branchName"]) || empty($entidad["idStatus"]) || empty($entidad["location"]) || empty($entidad["idDepot"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $depot = new Depot();
        $depot->idDepot=$entidad["idDepot"];
        $depot->branchName = $entidad["branchName"];
        $depot->Status = new Status(idStatus:$entidad["idStatus"]);
        $depot->location=$entidad["location"];
        $rowAffected=$this->dao->update($depot);


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

        if($entidad==null || empty($entidad["idStatus"]) || empty($entidad["idDepot"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $depot = new Depot();
        $depot->idDepot=$entidad["idDepot"];
        $depot->Status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->changeStatus($depot);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }
}

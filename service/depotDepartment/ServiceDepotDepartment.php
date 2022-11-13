<?php

namespace service\depotDepartment;

use dao\depotDepartment\IDaoDepotDepartment;
use model\Deparment;
use model\Depot;
use model\DepotDepartment;
use model\Status;
use service\depotDepartment\IServiceDepotDepartment;

class ServiceDepotDepartment implements IServiceDepotDepartment{


    private IDaoDepotDepartment $dao;

    public function __construct(IDaoDepotDepartment $dao){
        $this->dao=$dao;
    }


    public function getAll(): array{

        $depotDepartments=$this->dao->getAll();

        $statusReturn=array(
            "Info"=>"Datos de DepotDepartment",
            "values"=>$depotDepartments  
        );

        return $statusReturn;
    }

    /**
     * *DEVOLVERA EL DepotDepartment QUE SE BUSCA POR ID
     * *Verifica que el ID tenga un valor correcto para la busqueda
     * *Si no tiene un ID valido, devolvera un array de error
     * *Converti el resultado de busqueda a array asociativo, para que no se mostrar como un array de un objeto, sino como solo un objeto json
     */
    public function getByID($id):array{

        if($id==null || $id<=0){
            $responseError = array(
                "Info"=>"DepotDepartment",
                "value"=>"ID no valido"
            );
            return $responseError;
        }

        $depotDepartment = $this->dao->getByID($id);

        $depotDepartmentOne=array();
        foreach($depotDepartment as $value){
            $depotDepartmentOne=array(
                "ID_DEPOT_DEPARTMENT"=> $value["ID_DEPOT_DEPARTMENT"],
                "idDepot"=>$value["idDepot"],
                "idDepartment"=>$value["idDepartment"],
                "maxCapacity"=>$value["maxCapacity"],
                "idStatus"=>$value["idStatus"],
                "creationDate"=>$value["creationDate"]
            );
        }

        $depotDepartmentReturn = array(
            "Info"=>"Status",
            "values"=>$depotDepartmentOne
        );

        return $depotDepartmentReturn;
    }

    /**
     * @param  array $entidad Array con la informacion necesaria para guardar datos depotDepartment
     * @return int 1  insercion es exitosa
     * @return int 0  fallo de insercion, o si un department no puede se asignado a un depot ya que existe un registro disonible
     */
    public function save($entidad): array{

        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["idDepot"]) || empty($entidad["idDepartment"]) || empty($entidad["maxCapacity"]) || empty($entidad["idStatus"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $depotDepartment = new DepotDepartment();
        $depotDepartment->depot = new Depot(idDepot:$entidad["idDepot"]);
        $depotDepartment->deparment = new Deparment(idDepartment:$entidad["idDepartment"]);
        $depotDepartment->maxCapacity = $entidad["maxCapacity"];
        $depotDepartment->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->save($depotDepartment);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }

    }

    /**
     * @param  array $entidad Array con la informacion necesaria para actualizar datos depotDepartment
     * @return int 1  actualizacion es exitosa
     * @return int 0  fallo de actualizacion
     */
    public function update($entidad): array{

        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["idDepot"]) || empty($entidad["idDepartment"]) || empty($entidad["maxCapacity"]) || empty($entidad["idStatus"]) || empty($entidad["idDepotDepartment"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $depotDepartment = new DepotDepartment(idDepotDepartment:$entidad["idDepotDepartment"]);

        $depotDepartment->depot = new Depot(idDepot:$entidad["idDepot"]);
        $depotDepartment->deparment = new Deparment(idDepartment:$entidad["idDepartment"]);
        $depotDepartment->maxCapacity = $entidad["maxCapacity"];
        $depotDepartment->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->update($depotDepartment);


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

        if($entidad==null || empty($entidad["idStatus"]) || empty($entidad["idDepotDepartment"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $depotDepartment = new DepotDepartment();
        $depotDepartment->idDepotDepartment=$entidad["idDepotDepartment"];
        $depotDepartment->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->dao->changeStatus($depotDepartment);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }
}

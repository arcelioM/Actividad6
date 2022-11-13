<?php

namespace service\status;

use dao\status\IDaoStatus;
use model\Status;
use service\status\IServiceStatus;
class ServiceStatusImpl implements IServiceStatus{

    private IDaoStatus $dao;

    public function __construct(IDaoStatus $dao){
        $this->dao=$dao;
    }


    public function getAll(): array{

        $status=$this->dao->getAll();

        $statusReturn=array(
            "Info"=>"Datos de Status",
            "values"=>$status  
        );

        return $statusReturn;
    }

    /**
     * *DEVOLVERA EL Status QUE SE BUSCA POR ID
     * *Verifica que el ID tenga un valor correcto para la busqueda
     * *Si no tiene un ID valido, devolvera un array de error
     * *Converti el resultado de busqueda a array asociativo, para que no se mostrar como un array de un objeto, sino como solo un objeto json
     */
    public function getByID($id):array{

        if($id==null || $id<=0){
            $responseError = array(
                "Info"=>"Status",
                "value"=>"ID no valido"
            );
            return $responseError;
        }

        $status = $this->dao->getByID($id);

        $statusOne=array();
        foreach($status as $value){
            $statusOne=array(
                "ID_STATUS"=> $value["ID_STATUS"],
                "name"=>$value["name"]
            );
        }

        $statusReturn = array(
            "Info"=>"Status",
            "values"=>$statusOne
        );

        return $statusReturn;
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

        if($entidad==null || empty($entidad["name"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $status = new Status();
        $status->name = $entidad["name"];
        $rowAffected=$this->dao->save($status);


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

        if($entidad==null || empty($entidad["name"]) || empty($entidad["idStatus"]) ){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $status = new Status();
        $status->name = $entidad["name"];
        $status->idStatus=$entidad["idStatus"];
        $rowAffected=$this->dao->update($status);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }

    
}

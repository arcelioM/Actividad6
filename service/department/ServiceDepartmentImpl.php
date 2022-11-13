<?php

namespace service\department;

use dao\department\IDaoDepartment;
use model\Deparment;
use model\Status;

class ServiceDepartmentImpl implements IServiceDepartment{
    private IDaoDepartment $IDaoDepartment;

    public function __construct(IDaoDepartment $IDaoDepartment){
        $this->IDaoDepartment = $IDaoDepartment;
    }


    public function getAll(): array{

        $departments=$this->IDaoDepartment->getAll();

        $departmentsReturn=array(
            "Info"=>"Datos de Department",
            "values"=>$departments  
        );

        return $departmentsReturn;
    }

    /**
     * *DEVOLVERA EL DEPARTMENT QUE SE BUSCA POR ID
     * *Verifica que el ID tenga un valor correcto para la busqueda
     * *Si no tiene un ID valido, devolvera un array de error
     * *Converti el resultado de busqueda a array asociativo, para que no se mostrar como un array de un objeto, sino como solo un objeto json
     */
    public function getByID($id):array{

        if($id==null || $id<=0){
            $responseError = array(
                "Info"=>"Department",
                "value"=>"ID no valido"
            );
            return $responseError;
        }

        $department = $this->IDaoDepartment->getByID($id);

        $departmentOne=array();
        foreach($department as $value){
            $departmentOne=array(
                "ID_DEPARTMENT"=> $value["ID_DEPARTMENT"],
                "name"=>$value["name"],
                "idStatus"=>$value["idStatus"],
                "creationDate"=>$value["creationDate"]
            );
        }

        $departmentReturn = array(
            "Info"=>"Department",
            "values"=>$departmentOne
        );

        return $departmentReturn;
    }

    /**
     * @param  array $entidad Array con la informacion necesaria para guardar datos department
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

        $deparment = new Deparment();
        $deparment->name = $entidad["name"];
        $deparment->status = new Status(idStatus:$entidad["idStatus"]);
        $rowAffected=$this->IDaoDepartment->save($deparment);

        

        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }

    }

    /**
     * @param  array $entidad Array con la informacion necesaria para actualizar datos department
     * @return int 1  actualizacion es exitosa
     * @return int 0  fallo de actualizacion
     */
    public function update($entidad): array{

        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["name"]) || empty($entidad["idStatus"]) || empty($entidad["idDepartment"])){
            
            $response["value"]="datos no validos";
            return $response;
        }



        $deparment = new Deparment();
        $deparment->idDepartment=$entidad["idDepartment"];
        $deparment->name = $entidad["name"];
        $deparment->status = new Status(idStatus:$entidad["idStatus"]);
        

        $rowAffected=$this->IDaoDepartment->update($deparment);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }

    /**
     * @param  array $entidad Array con la informacion necesaria para cambiar estado  department
     * @return int 1  actualizacion es exitosa
     * @return int 0  fallo de actualizacion
     */
    public function changeStatus($entidad): array{
        
        $response = array(
            "Info"=> "Filas afectadas"
        );

        if($entidad==null || empty($entidad["idStatus"]) || empty($entidad["idDepartment"])){
            
            $response["value"]="datos no validos";
            return $response;
        }

        $deparment = new Deparment();
        $deparment->idDepartment=$entidad["idDepartment"];
        $deparment->status = new Status(idStatus:$entidad["idStatus"]);
        

        $rowAffected=$this->IDaoDepartment->changeStatus($deparment);


        if($rowAffected==null){
            $response["value"]=0;
            return $response;
        }else{
            $response["value"]=$rowAffected;
            return $response;
        }
    }
}

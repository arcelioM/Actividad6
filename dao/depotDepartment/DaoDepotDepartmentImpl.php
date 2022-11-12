<?php

namespace dao\depotDepartment;

use dao\depotDepartment\IDaoDepotDepartment;
use dao\connection\IConnection;
use model\DepotDepartment;
use PDOException;
use util\Log;
use PDO;

class DaoDepotDepartmentImpl implements IDaoDepotDepartment{

    private IConnection $connection;

    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(){

        try {
            Log::write("INICIO DE CONSULTA DE BUSQUEDA | ".__NAMESPACE__." | ".basename(__FILE__), "SELECT");
            $query = "SELECT ID_DEPOT_DEPARTMENT,idDepot,idDepartment,maxCapacity,idStatus,creationDate FROM depotdepartment ORDER BY ID_DEPOT_DEPARTMENT DESC";
            $execute = $this->connection->getConnection()->prepare($query);
            $execute->execute();
            $result = $execute->fetchAll(PDO::FETCH_ASSOC);
            Log::write("CONSULTA EXITOSA", "INFO");
            return $result;
        } catch (PDOException $e) {
            Log::write("dao\depotDepartment\DaoDepotDepartmentImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return array();
        }
    }
    public function getByID($id){

        try {
            Log::write("INICIO DE CONSULTA POR ID | ".__NAMESPACE__." | ".basename(__FILE__), "SELECT");
            $query = "SELECT ID_DEPOT_DEPARTMENT,idDepot,idDepartment,maxCapacity,idStatus,creationDate FROM depotdepartment WHERE ID_DEPOT_DEPARTMENT = ?";
            $args=array($id);

            $execute = $this->connection->getConnection()->prepare($query);
            $execute->execute($args);

            $result = $execute->fetchAll(PDO::FETCH_ASSOC);
            Log::write("CONSULTA REALIZADA CON EXITO","INFO");
            return $result;
        }catch (PDOException $e) {
            Log::write("dao\depotDepartment\DaoDepotDepartmentImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return array();
        }
    }
    public function save($entidad): ?int{
        
        try{
            Log::write("INICIO DE INSERCION","INSERT");
            $query = "CALL sp_insert_depot_department(@result,?,?,?,?)";
            $execute = $this->connection->getConnection()->prepare($query);

            $execute->bindParam(1,$entidad->depot->idDepot,PDO::PARAM_INT,6);
            $execute->bindParam(2,$entidad->deparment->idDepartment,PDO::PARAM_INT,6);
            $execute->bindParam(3,$entidad->maxCapacity,PDO::PARAM_INT,6);
            $execute->bindParam(4,$entidad->status->idStatus,PDO::PARAM_INT,6);
            
            $execute->execute();
            $execute->closeCursor();

            $result=$this->connection->getConnection()->query("SELECT @result as result")->fetchAll(PDO::FETCH_ASSOC);
            $result=$result[0]["result"];


            if($result==1){
                Log::write("INSERCION EXITOSA","INFO");
            }else{
                Log::write("INSERCION HA FRACASADO","INFO");
            }

            
            return $result;

        }catch(PDOException $e){
            Log::write("dao\depotDepartment\DaoDepotDepartmentImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return null;
        }
    }
    public function update($entidad): ?int{
        

        try{

            Log::write("INICIO DE ACTUALIZACION","UPDATE");
            $query = "UPDATE depotdepartment SET idDepot=?, idDepartment=?,idStatus=?,maxCapacity=? WHERE ID_DEPOT_DEPARTMENT=?";
            $args=array(
                $entidad->depot->idDepot,
                $entidad->deparment->idDepartment,
                $entidad->status->idStatus,
                $entidad->maxCapacity,
                $entidad->idDepotDepartment
            );

            $execute = $this->connection->getConnection()->prepare($query);

            
            $resultRowAffect=$execute->execute($args);
            if($resultRowAffect){
                Log::write("REGISTRO ACTUALIZADO CORRECTAMENTE","INFO");
                return 1;
            }else{
                Log::write("FALLO DE ACTUALIZACION", "ERROR");
                return 0;
            }

        }catch(PDOException $e){
            Log::write("dao\depotDepartment\DaoDepotDepartmentImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return null;
        }
    }

    public function changeStatus(DepotDepartment $entidad): ?int{

        try{

            Log::write("INICIO DE ACTUALIZACION STATUS","UPDATE");
            $query = "UPDATE depotdepartment SET idStatus=? WHERE ID_DEPOT_DEPARTMENT=?";
            $args=array(
                $entidad->status->idStatus,
                $entidad->idDepotDepartment
            );

            $execute = $this->connection->getConnection()->prepare($query);

            
            $resultRowAffect=$execute->execute($args);
            if($resultRowAffect){
                Log::write("REGISTRO ACTUALIZADO CORRECTAMENTE","INFO");
                return 1;
            }else{
                Log::write("FALLO DE ACTUALIZACION", "ERROR");
                return 0;
            }

        }catch(PDOException $e){
            Log::write("dao\depotDepartment\DaoDepotDepartmentImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return null;
        }
    }
}

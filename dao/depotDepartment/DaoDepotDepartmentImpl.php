<?php

namespace dao\depotDepartment;

use dao\depotDepartment\IDaoDepotDepartment;
use dao\connection\IConnection;
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
        return 0;
    }
    public function update($entidad): ?int{
        return 0;
    }
}

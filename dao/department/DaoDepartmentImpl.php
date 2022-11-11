<?php

namespace dao\department;

use dao\connection\IConnection;
use PDOException;
use util\Log;
use PDO;

class DaoDepartmentImpl implements IDaoDepartment{

    private IConnection $connection;

    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(){

        try {
            Log::write("INICIO DE CONSULTA DE BUSQUEDA", "SELECT");
            $query = "SELECT ID_DEPARTMENT,name,idStatus,creationDate FROM deparment ORDER BY ID_DEPARTMENT DESC";
            $execute = $this->connection->getConnection()->prepare($query);
            $execute->execute();
            $result = $execute->fetchAll(PDO::FETCH_ASSOC);
            Log::write("CONSULTA EXITOSA", "INFO");
            return $result;
        } catch (PDOException $e) {
            Log::write("dao\department\DaoDepartmentImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return array();
        }
    }
    public function getByID($id){

    }
    public function save($entidad):int{
        return 0;
    }
    public function update($entidad):int{
        return 0;
    }
}

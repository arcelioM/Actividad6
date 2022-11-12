<?php

namespace dao\depotProduct;

use dao\depotProduct\IDaoDepotProduct;
use dao\connection\IConnection;
use PDOException;
use util\Log;
use PDO;


class DaoDepotProductImpl implements IDaoDepotProduct{

    private IConnection $connection;

    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(){

        try {
            Log::write("INICIO DE CONSULTA DE BUSQUEDA | ".__NAMESPACE__." | ".basename(__FILE__), "SELECT");
            $query = "SELECT ID_DEPOT_PRODUCT,idProduct,idDepotDepartment,quantity,idStatus,creationDate FROM depotproduct ORDER BY ID_DEPOT_PRODUCT DESC";
            $execute = $this->connection->getConnection()->prepare($query);
            $execute->execute();
            $result = $execute->fetchAll(PDO::FETCH_ASSOC);
            Log::write("CONSULTA EXITOSA", "INFO");
            return $result;
        } catch (PDOException $e) {
            Log::write("dao\depotProduct\DaoDepotProductImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return array();
        }
    }
    public function getByID($id){

        try {
            Log::write("INICIO DE CONSULTA POR ID | ".__NAMESPACE__." | ".basename(__FILE__), "SELECT");
            $query = "SELECT ID_DEPOT_PRODUCT,idProduct,idDepotDepartment,quantity,idStatus,creationDate FROM depotproduct WHERE ID_DEPOT_PRODUCT = ?";
            $args=array($id);

            $execute = $this->connection->getConnection()->prepare($query);
            $execute->execute($args);

            $result = $execute->fetchAll(PDO::FETCH_ASSOC);
            Log::write("CONSULTA REALIZADA CON EXITO","INFO");
            return $result;
        }catch (PDOException $e) {
            Log::write("dao\depotProduct\DaoDepotProductImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return array();
        }
    }
    public function save($entidad):int{

        try{
            Log::write("INICIO DE INSERCION","INSERT");
            $result=0;
            $query = "CALL sp_insert_depot_product(?,?,?,?,?)";
            $execute = $this->connection->getConnection()->prepare($query);

            $execute->bindParam(1,$result,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT,6);
            $execute->bindParam(2,$entidad->idProduct,PDO::PARAM_INT,6);
            $execute->bindParam(3,$entidad->depotDepartment->idDepotDepartment,PDO::PARAM_INT,6);
            $execute->bindParam(4,$entidad->status->idStatus,PDO::PARAM_INT,6);
            $execute->bindParam(5,$entidad->quantity,PDO::PARAM_INT,6);

            $execute->execute();

            return $result;

        }catch(PDOException $e){
            Log::write("dao\depotProduct\DaoDepotProductImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return null;
        }
    }
    public function update($entidad):int{
        return 0;
    }
}

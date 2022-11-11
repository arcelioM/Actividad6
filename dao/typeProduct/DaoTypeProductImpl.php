<?php

namespace dao\typeProduct;

use dao\connection\IConnection;
use dao\typeProduct\IDaoTypeProduct;
use PDOException;
use util\Log;
use PDO;

class DaoTypeProductImpl implements IDaoTypeProduct{
    private IConnection $connection;

    public function __construct(IConnection $IConnection)
    {
        $this->connection = $IConnection;
    }



    public function getAll(){

        try {
            Log::write("INCIANDO CONSULTA DE TYPO PRODUCTO | ".__NAMESPACE__." | ".basename(__FILE__),"SELECT");
            $query = "SELECT ID_TYPE_PRODUCT,name,idStatus,creationDate FROM typeProduct ORDER BY ID_TYPE_PRODUCT DESC";
            $execute = $this->connection->getConnection()->prepare($query);
            $execute->execute();
            $result = $execute->fetchAll(PDO::FETCH_ASSOC);
            Log::write("CONSULTA REALIZADA CON EXITO","INFO");
            return $result;

        } catch (PDOException $e) {
            Log::write("dao\type_product\DaoTypeProductImpl","ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return null;
        }
    }
    public function getByID($id){

        try{

            Log::write("INICIANDO CONSULTA DE TYPE PRODUCT | ".__NAMESPACE__." | ".basename(__FILE__),"SELECT");
            $query = "SELECT ID_TYPE_PRODUCT,name,idStatus,creationDate FROM typeProduct WHERE ID_TYPE_PRODUCT=?";
            $args=array($id);
            $execute = $this->connection->getConnection()->prepare($query);
            $execute->execute($args);
            $result = $execute->fetchAll(PDO::FETCH_ASSOC);
            Log::write("TERMINO CONSULTA EXITOSAMENTE","INFO");
            return $result;
        }catch(PDOException $e){
            Log::write("dao\type_product\DaoTypeProductImpl","ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return null;
        }

    }
    public function save($entidad):int{
        return 0;
    }
    public function update($entidad):int{
        return 0;
    }

}

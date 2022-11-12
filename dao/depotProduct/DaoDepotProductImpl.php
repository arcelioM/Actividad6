<?php

namespace dao\depotProduct;

use dao\depotProduct\IDaoDepotProduct;
use dao\connection\IConnection;
use model\DepotProduct;
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

    /**
     * *METODO SE ENCARGAR DE VALIDAR LA INFORMACION NECESARIA PARA GUARDAR PRODUCTOS EN UN DEPOSITO
     * @param DepotProduct $entidad : Infoormacion que se guardara
     * @return null : Devolvera si los datos no estan corrector
     * @return int 1: Si se hace correctamenta devolvera
     * @return int: Devolvara el espacio disponible, si la cantidad sobrepasa a este
     * @return  int 0: Devolvera  si no hay espacio disponible 
     * 
     */
    public function save($entidad): ?int{

        try{
            Log::write("INICIO DE INSERCION","INSERT");
            $query = "CALL sp_insert_depot_product(@result,?,?,?,?)";
            $execute = $this->connection->getConnection()->prepare($query);

            $execute->bindParam(1,$entidad->product->idProduct,PDO::PARAM_INT,6);
            $execute->bindParam(2,$entidad->depotDepartment->idDepotDepartment,PDO::PARAM_INT,6);
            $execute->bindParam(3,$entidad->status->idStatus,PDO::PARAM_INT,6);
            $execute->bindParam(4,$entidad->quantity,PDO::PARAM_INT,6);

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
            Log::write("dao\depotProduct\DaoDepotProductImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return null;
        }
    }
    public function update($entidad): ?int{

        try{

            Log::write("INICIO DE ACTUALIZACION","UPDATE");
            $query = "UPDATE depotproduct SET idProduct=?, idDepotDepartment=?,idStatus=?,quantity=? WHERE ID_DEPOT_PRODUCT=?";
            $args=array(
                $entidad->product->idProduct,
                $entidad->depotDepartment->idDepotDepartment,
                $entidad->status->idStatus,
                $entidad->quantity,
                $entidad->idDepotProduct
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
            Log::write("dao\depotProduct\DaoDepotProductImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return null;
        }

        
    }

    public function changeStatus(DepotProduct $entidad): ?int{
        
        try{

            Log::write("INICIO DE ACTUALIZACION STATUS","UPDATE");
            $query = "UPDATE depotproduct SET idStatus=? WHERE ID_DEPOT_PRODUCT=?";
            $args=array(
                $entidad->status->idStatus,
                $entidad->idDepotProduct
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
            Log::write("dao\depotProduct\DaoDepotProductImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return null;
        }
    }
}

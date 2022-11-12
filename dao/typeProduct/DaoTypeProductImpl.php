<?php

namespace dao\typeProduct;

use dao\connection\IConnection;
use dao\typeProduct\IDaoTypeProduct;
use model\TypeProduct;
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
    public function save($entidad): ?int{

        try{
            Log::write("INICIANDO GUARDADO DE DATOS | ".basename(__FILE__), "INSERT");
            $query = "INSERT INTO typeproduct (name,idStatus) VALUES(?,?)";
            $args = array(
                $entidad->name,
                $entidad->status->idStatus
            );
            $execute = $this->connection->getConnection()->prepare($query);

            if($execute->execute($args)){
                Log::write("DATOS GUARDADOS","INFO");
                $idNewRow = $this->connection->getConnection()->lastInsertId();
                return $idNewRow;
            }else{
                Log::write("FALLO DE INSERCION", "ERROR");
            }

            Log::write("OPERACION DE INSERCION TERMINADA","INFO");

            return 0;
            
        }catch(PDOException $e){
            Log::write("dao\typeproduct\DaoTypeProductImp", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
	}

	public function update($entidad): ?int{
		
        try{

            Log::write("ACTUALIZACION DE DATOS | ".basename(__FILE__),"UPDATE");
            $query = "UPDATE typeproduct SET name = ?, idStatus=? WHERE ID_TYPE_PRODUCT = ?";
            $args = array(
                $entidad->name,
                $entidad->status->idStatus,
                $entidad->idTypeProduct
            );
            $execute = $this->connection->getConnection()->prepare($query);
            $rowAffected = $execute->execute($args);

            if($rowAffected){
                Log::write("REGISTRO ACTUALIZADO CORRECTAMENTE","INFO");
                return 1;
            }else{
                Log::write("FALLO DE ACTUALIZACION", "ERROR");
            }

            Log::write("FIN DE OPERACION DE ACTUALIZACION","INFO");
            return 0;

        }catch(PDOException $e){
            Log::write("dao\typeproduct\DaoTypeProductImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
	}

    public function changeStatus(TypeProduct $entidad): ?int{

        try{

            Log::write("ACTUALIZACION DE STATUS | ".basename(__FILE__),"UPDATE");
            $query = "UPDATE typeproduct SET idStatus=? WHERE ID_TYPE_PRODUCT = ?";
            $args = array(
                $entidad->status->idStatus,
                $entidad->idTypeProduct
            );
            $execute = $this->connection->getConnection()->prepare($query);
            $rowAffected = $execute->execute($args);

            if($rowAffected){
                Log::write("REGISTRO ACTUALIZADO CORRECTAMENTE","INFO");
                return 1;
            }else{
                Log::write("FALLO DE ACTUALIZACION", "ERROR");
            }

            Log::write("FIN DE OPERACION DE ACTUALIZACION","INFO");
            return 0;

        }catch(PDOException $e){
            Log::write("dao\typeproduct\DaoTypeProductImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
    }

}

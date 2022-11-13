<?php

namespace dao\product;

use dao\connection\IConnection;
use dao\product\IDaoProduct;
use model\Product;
use PDOException;
use util\Log;
use PDO;

class DaoProductImpl implements IDaoProduct
{

	private IConnection $connection;
	public function __construct(IConnection $connection)
	{
		$this->connection = $connection;
	}
	public function getAll()
	{
		try {
			Log::write("INICIANDO CONSULTA DE PRODUCTOS | ".__NAMESPACE__." | ".basename(__FILE__), "SELECT");
			$query = "SELECT ID_PRODUCT,name,idTypeProduct,price,experationDate,creationDate,idStatus from product order by ID_PRODUCT desc";
			$execute = $this->connection->getConnection()->prepare($query);
			$execute->execute();

			$result = $execute->fetchAll(PDO::FETCH_ASSOC);

			Log::write("CONSULTA REALIZADA EXITOSAMENTE","INFO");
			return $result;
		} catch (PDOException $e) {

			Log::write("dao\product\DaoProductImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return array();
		}
	}

	public function getByID($id){
		Log::write("Iniciando busqueda | ".__NAMESPACE__." | ".basename(__FILE__),"SELECT");
		try{
			$query = "SELECT ID_PRODUCT,name,idTypeProduct,price,experationDate,creationDate,idStatus from product WHERE ID_PRODUCT=?";
			$args=array($id);
			$execute=$this->connection->getConnection()->prepare($query);
			$execute->execute($args);
			$result=$execute->fetchAll(PDO::FETCH_ASSOC);
			Log::write("CONSULTA REALIZADA EXITOSAMENTE","INFO");
			return $result;

		}catch(PDOException $e){
			Log::write("dao\product\DaoProductImpl","ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return array();
		}
	}

	public function save($entidad): ?int{

        try{
            Log::write("INICIANDO GUARDADO DE DATOS | ".basename(__FILE__), "INSERT");
            $query = "INSERT INTO product (name,idTypeProduct,price,experationDate,idStatus) VALUES(?,?,?,?,?)";

            $args = array(
				$entidad->name,
				$entidad->typeProduct->idTypeProduct,
				$entidad->price,
				$entidad->experationDate,
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
            Log::write("dao\product\DaoProductImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
	}

	public function update($entidad): ?int{
		
        try{

            Log::write("ACTUALIZACION DE DATOS | ".basename(__FILE__),"UPDATE");
            $query = "UPDATE product SET name = ?,idTypeProduct=?,price=?,experationDate=?,idStatus=? WHERE ID_PRODUCT = ?";
            $args = array(
				$entidad->name,
				$entidad->typeProduct->idTypeProduct,
				$entidad->price,
				$entidad->experationDate,
				$entidad->status->idStatus,
				$entidad->idProduct
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
            Log::write("dao\product\DaoProductImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
	}

	public function changeStatus(Product $entidad): ?int{

		try{

            Log::write("ACTUALIZACION DE DATOS PRODUCT STATUS | ".basename(__FILE__),"UPDATE");
            $query = "UPDATE product SET idStatus=? WHERE ID_PRODUCT = ?";
            $args = array(
				$entidad->status->idStatus,
				$entidad->idProduct
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
            Log::write("dao\product\DaoProductImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
	}


}

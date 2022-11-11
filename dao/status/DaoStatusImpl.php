<?php

namespace dao\status;

use dao\connection\IConnection;
use dao\status\IDaoStatus;
use PDOException;
use util\Log;
use PDO;

class DaoStatusImpl implements IDaoStatus{

    private IConnection $connection;
	public function __construct(IConnection $connection)
	{
		$this->connection = $connection;
	}
	public function getAll()
	{
		try {
			Log::write("INICIANDO CONSULTA DE PRODUCTOS", "SELECT");
			$query = "SELECT ID_STATUS,name from status order by ID_STATUS desc";
			$execute = $this->connection->getConnection()->prepare($query);
			$execute->execute();

			$result = $execute->fetchAll(PDO::FETCH_ASSOC);

			Log::write("CONSULTA REALIZADA EXITOSAMENTE","INFO");
			return $result;
		} catch (PDOException $e) {

			Log::write("dao\status\DaoStatusImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return array();
		}
	}

	public function getByID($id){
		
		try{
            Log::write("INICIANDO BUSQUEDA POR ID","SELECT");
			$query = "SELECT ID_STATUS,name from product WHERE ID_STATUS=?";
			$args=array($id);
			$execute=$this->connection->getConnection()->prepare($query);
			$execute->execute($args);
			$result=$execute->fetchAll(PDO::FETCH_ASSOC);
			Log::write("CONSULTA REALIZADA EXITOSAMENTE","INFO");
			return $result;

		}catch(PDOException $e){
			Log::write("dao\status\DaoStatusImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return array();
		}
	}

	public function save($entidad): int{

        try{
            Log::write("INICIANDO GUARDADO DE DATOS", "INSERT");
            $query = "INSERT INTO status (name) VALUES(?)";
            $args = array($entidad->name);
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
            Log::write("dao\status\DaoStatusImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
	}

	public function update($entidad): int{
		
        try{

            Log::write("ACTUALIZACION DE DATOS","UPDATE");
            $query = "UPDATE status SET name = ? WHERE ID_STATUS = ?";
            $args = array($entidad->name,$entidad->idProducto);
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
            Log::write("dao\status\DaoStatusImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
	}
}

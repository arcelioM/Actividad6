<?php

namespace dao\product;

use dao\connection\IConnection;
use dao\product\IDaoProduct;
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
			Log::write("INICIANDO CONSULTA DE PRODUCTOS", "SELECT");
			$query = "SELECT name,idTypeProduct,price,experationDate,creationDate,status from product order by ID_PRODUCT desc";
			$execute = $this->connection->getConnection()->prepare($query);
			$execute->execute();

			$result = $execute->fetchAll(PDO::FETCH_ASSOC);

			Log::write("CONSULTA REALIZADA EXITOSAMENTE","INFO");
			return $result;
		} catch (PDOException $e) {

			Log::write("dao\product\DaoProductImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return "DATOS NO DISPONIBLE";
		}
	}

	public function getByID($id){
		Log::write("Iniciando busqueda","SELECT");
		try{
			$query = "SELECT name,idTypeProduct,price,experationDate,creationDate,status from product WHERE ID_PRODUCT=?";
			$args=array($id);
			$execute=$this->connection->getConnection()->prepare($query);
			$execute->execute($args);
			$result=$execute->fetchAll(PDO::FETCH_ASSOC);
			Log::write("CONSULTA REALIZADA EXITOSAMENTE","INFO");
			return $result;

		}catch(PDOException $e){
			Log::write("dao\product\DaoProductImpl","ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return null;
		}
	}

	public function save($entidad): int
	{
		return 0;
	}

	public function update($entidad): int
	{
		return 0;
	}
}

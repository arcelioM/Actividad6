<?php

namespace dao\depot;

use dao\connection\IConnection;
use model\Depot;
use PDOException;
use util\Log;
use PDO;

class DaoDepotImpl implements IDaoDepot
{

    private IConnection $connection;

    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
    }
    public function getAll()
    {
        try {
            Log::write("INICIO DE CONSULTA DE BUSQUEDA | ".__NAMESPACE__." | ".basename(__FILE__), "SELECT");
            $query = "SELECT ID_DEPOT,branchName,location,idStatus FROM depot ORDER BY ID_DEPOT DESC";
            $execute = $this->connection->getConnection()->prepare($query);
            $execute->execute();
            $result = $execute->fetchAll(PDO::FETCH_ASSOC);
            Log::write("CONSULTA EXITOSA", "INFO");
            return $result;
        } catch (PDOException $e) {
            Log::write("dao\depot\DaoDepotImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return array();
        }
    }
    public function getByID($id)
    {

        try {
            Log::write("INICIO DE CONSULTA POR ID | ".__NAMESPACE__." | ".basename(__FILE__), "SELECT");
            $query = "SELECT ID_DEPOT,branchName,location,idStatus FROM depot WHERE ID_DEPOT=?";
            $args=array($id);

            $execute = $this->connection->getConnection()->prepare($query);
            $execute->execute($args);

            $result = $execute->fetchAll(PDO::FETCH_ASSOC);
            Log::write("CONSULTA REALIZADA CON EXITO","INFO");
            return $result;
        } catch (PDOException $e) {
            Log::write("dao\depot\DaoDepotImpl", "ERROR");
            Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
            return array();
        }
    }
    public function save($entidad): ?int{

        try{
            Log::write("INICIANDO GUARDADO DE DATOS | ".basename(__FILE__), "INSERT");
            $query = "INSERT INTO depot (branchName,location,idStatus) VALUES(?,?,?)";
            $args = array(
                $entidad->branchName,
                $entidad->location,
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
            Log::write("dao\depot\DaoDepotImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
	}

	public function update($entidad): ?int{
		
        try{

            Log::write("ACTUALIZACION DE DATOS | ".basename(__FILE__),"UPDATE");
            $query = "UPDATE depot SET branchName=?,location=?,idStatus=? WHERE ID_DEPOT = ?";
            $args = array(
                $entidad->branchName,
                $entidad->location,
                $entidad->status->idStatus,
                $entidad->idDepot
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
            Log::write("dao\depot\DaoDepotImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
	}

    public function changeStatus(Depot $entidad): ?int{

        try{

            Log::write("ACTUALIZACION STATUS DE DATOS | ".basename(__FILE__),"UPDATE");
            $query = "UPDATE depot SET idStatus=? WHERE ID_DEPOT = ?";
            $args = array(
                $entidad->status->idStatus,
                $entidad->idDepot
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
            Log::write("dao\depot\DaoDepotImpl", "ERROR");
			Log::write("ARCHIVO: " . $e->getFile() . " | lINEA DE ERROR: " . $e->getLine() . " | MENSAJE" . $e->getMessage(), "ERROR");
			return 0;
        }
    }
}

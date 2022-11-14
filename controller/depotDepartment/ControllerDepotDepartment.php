<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\depotDepartment\DaoDepotDepartmentImpl;
    use service\depotDepartment\ServiceDepotDepartmentImpl;

    $con = Connection::getInstance();
    $dao = new DaoDepotDepartmentImpl( $con);
    $service =  new ServiceDepotDepartmentImpl($dao);

    $server = new nusoap_server(); 
    $server->configureWSDL("DepotPdepartment","urn:DepotDepartment"); 

        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        $server->register(
            "getAll", 
            array(), 
            array("return"=>"xsd:string"), 
            'urn:depotDepartment',   
            'urn:depotDepartment#getAll' 
        );

        #----------------------------------------------

        function getById($id):String{
            global $service;
            
            return json_encode($service->getByID($id));
            
        }

        $server->register(
            "getById",
            array("id"=>"xsd:integer"), 
            array("return"=>"xsd:string"),
            'urn:depotDepartment',  
            'urn:depotDepartment#getById'   
        );

        #-----------------------------------------------------------------------

        function save($idDepot,$idDepartment,$maxCapacity,$idStatus){
            global $service;

            $entidad = array(
                "idDepot"=>$idDepot,
                "idDepartment"=>$idDepartment,
                "maxCapacity"=>$maxCapacity,
                "idStatus"=>$idStatus
            );

            return json_encode($service->save($entidad));
        }

        $server->register(
            "save", 
            array(
                "idDepot"=>"xsd:integer",
                "idDepartment"=>"xsd:integer",
                "maxCapacity"=>"xsd:integer",
                "idStatus"=>"xsd:integer"
            ),  
            array("return"=>"xsd:string"), 
            'urn:depotDepartment',  
            'urn:depotDepartment#save'
        );
        #------------------------------------------------------
        
    
    $server->service(file_get_contents("php://input"));
?>
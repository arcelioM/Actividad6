<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\depotProduct\DaoDepotProductImpl;
    use service\depotProduct\ServiceDepotProductImpl;
use util\Log;

     $con = Connection::getInstance();
     $dao = new DaoDepotProductImpl( $con);
    $service =  new ServiceDepotProductImpl($dao);

    $server = new nusoap_server(); // Create a instance for nusoap server

        #const  CONNECTION = Connection::getInstance();
        #const DAO = new DaoDepotProductImpl(ControllerDepotProductImpl::CONNECTION);
        #const SERVICE = new ServiceDepotProductImpl($dao);
        function getAll(){
            Log::write("getAll","Controller");
            global $service;
            
            return json_encode($service->getAll());
        }

        function getById($id):String{
            Log::write("getById","Controller");
            global $service;
            #Log::write(json_encode($service->getByID($id)),"RESPONSE");
            
            return json_encode($service->getByID($id));
            
        }

        function save($idProduct,$idDepotDepartment,$quantity,$idStatus){
            global $service;

            $entidad = array(
                "idProduct"=>$idProduct,
                "idDepotDepartment"=>$idDepotDepartment,
                "quantity"=>$quantity,
                "idStatus"=>$idStatus
            );

            return json_encode($service->save($entidad));
        }

    $server->configureWSDL("DepotProduct","urn:soapdemo"); // Configure WSDL file

    
    $server->register(
        "getById", // name of function
        array("id"=>"xsd:integer"),  // inputs
        array("return"=>"xsd:string"), // outputs
        'urn:depotProduct',   //namespace
        'urn:depotProduct#getById' //soapaction
    );

    $server->register(
        "getAll", // name of function
        array(),  // inputs
        array("return"=>"xsd:string"), // outputs
        'urn:depotProduct',   //namespace
        'urn:depotProduct#getAll' //soapaction
    );
    
    $server->service(file_get_contents("php://input"));
?>
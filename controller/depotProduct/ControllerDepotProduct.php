<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\depotProduct\DaoDepotProductImpl;
    use service\depotProduct\ServiceDepotProductImpl;

     $con = Connection::getInstance();
     $dao = new DaoDepotProductImpl( $con);
    $service =  new ServiceDepotProductImpl($dao);

    $server = new nusoap_server(); // Create a instance for nusoap server

        #const  CONNECTION = Connection::getInstance();
        #const DAO = new DaoDepotProductImpl(ControllerDepotProductImpl::CONNECTION);
        #const SERVICE = new ServiceDepotProductImpl($dao);
        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        function getById($id):String{
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

    $server->configureWSDL("DepotProduct","urn:depotProduct"); // Configure WSDL file

    
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

    $server->register(
        "save", // name of function
        array(
            "idProduct"=>"xsd:integer",
            "idDepotDepartment"=>"xsd:integer",
            "quantity"=>"xsd:integer",
            "idStatus"=>"xsd:integer"
        ),  // inputs
        array("return"=>"xsd:string"), // outputs
        'urn:depotProduct',   //namespace
        'urn:depotProduct#save' //soapaction
    );
    
    $server->service(file_get_contents("php://input"));
?>
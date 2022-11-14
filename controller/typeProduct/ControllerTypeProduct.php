<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\typeProduct\DaoTypeProductImpl;
    use service\typeProduct\ServiceTypeProductImpl;

     $con = Connection::getInstance();
     $dao = new DaoTypeProductImpl( $con);
    $service =  new ServiceTypeProductImpl($dao);

    $server = new nusoap_server(); // Create a instance for nusoap server


        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        function getById($id):String{
            global $service;            
            return json_encode($service->getByID($id));
            
        }

        function save($name,$idStatus){
            global $service;

            $entidad = array(
                "name"=>$name,
                "idStatus"=>$idStatus
            );

            return json_encode($service->save($entidad));
        }

    $server->configureWSDL("TypeProduct","urn:TypeProduct"); // Configure WSDL file

    
    $server->register(
        "getById", // name of function
        array("id"=>"xsd:integer"),  // inputs
        array("return"=>"xsd:string"), // outputs
        'urn:typeProduct',   //namespace
        'urn:typeProduct#getById' //soapaction
    );

    $server->register(
        "getAll", // name of function
        array(),  // inputs
        array("return"=>"xsd:string"), // outputs
        'urn:typeProduct',   //namespace
        'urn:typeProduct#getAll' //soapaction
    );

    $server->register(
        "save", // name of function
        array(
            "name"=>"xsd:string",
            "idStatus"=>"xsd:integer"
        ),  // inputs
        array("return"=>"xsd:string"), // outputs
        'urn:typeProduct',   //namespace
        'urn:typeProduct#save' //soapaction
    );
    
    $server->service(file_get_contents("php://input"));
?>
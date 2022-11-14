<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\product\DaoProductImpl;
    use service\product\ServiceProductImpl;

     $con = Connection::getInstance();
     $dao = new DaoProductImpl( $con);
    $service =  new ServiceProductImpl($dao);

    $server = new nusoap_server(); // Create a instance for nusoap server


        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        function getById($id):String{
            global $service;            
            return json_encode($service->getByID($id));
            
        }

        function save($name,$idTypeProduct,$price,$experationDate,$idStatus){
            global $service;

            $entidad = array(
                "name"=>$name,
                "idTypeProduct"=>$idTypeProduct,
                "price"=>$price,
                "experationDate"=>$experationDate,
                "idStatus"=>$idStatus
            );

            return json_encode($service->save($entidad));
        }

    $server->configureWSDL("Product","urn:product"); // Configure WSDL file

    
    $server->register(
        "getById", // name of function
        array("id"=>"xsd:integer"),  // inputs
        array("return"=>"xsd:string"), // outputs
        'urn:product',   //namespace
        'urn:product#getById' //soapaction
    );

    $server->register(
        "getAll", // name of function
        array(),  // inputs
        array("return"=>"xsd:string"), // outputs
        'urn:product',   //namespace
        'urn:product#getAll' //soapaction
    );

    $server->register(
        "save", // name of function
        array(
            "name"=>"xsd:string",
            "idTypeProduct"=>"xsd:integer",
            "price"=>"xsd:decimal",
            "experationDate"=>"xsd:string",
            "idStatus"=>"xsd:integer"
        ),  // inputs
        array("return"=>"xsd:string"), // outputs
        'urn:product',   //namespace
        'urn:product#save' //soapaction
    );
    
    $server->service(file_get_contents("php://input"));
?>
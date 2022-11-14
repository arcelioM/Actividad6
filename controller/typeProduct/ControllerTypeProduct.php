<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\typeProduct\DaoTypeProductImpl;
    use service\typeProduct\ServiceTypeProductImpl;

     $con = Connection::getInstance();
     $dao = new DaoTypeProductImpl( $con);
    $service =  new ServiceTypeProductImpl($dao);

    $server = new nusoap_server(); 
    $server->configureWSDL("TypeProduct","urn:TypeProduct"); 


        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        $server->register(
            "getAll", 
            array(),
            array("return"=>"xsd:string"), 
            'urn:typeProduct', 
            'urn:typeProduct#getAll' 
        );

        #------------------------------------------------------------

        function getById($id):String{
            global $service;            
            return json_encode($service->getByID($id));
            
        }

        $server->register(
            "getById", 
            array("id"=>"xsd:integer"),  
            array("return"=>"xsd:string"), 
            'urn:typeProduct',   
            'urn:typeProduct#getById' 
        );

        #-----------------------------------------------------------------

        function save($name,$idStatus){
            global $service;

            $entidad = array(
                "name"=>$name,
                "idStatus"=>$idStatus
            );

            return json_encode($service->save($entidad));
        }

        $server->register(
            "save", 
            array(
                "name"=>"xsd:string",
                "idStatus"=>"xsd:integer"
            ),  // inputs
            array("return"=>"xsd:string"), 
            'urn:typeProduct',   
            'urn:typeProduct#save'
        );

        #-------------------------------------------------------------


    
    
    $server->service(file_get_contents("php://input"));
?>
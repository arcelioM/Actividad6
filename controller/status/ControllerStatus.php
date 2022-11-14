<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");

    use dao\connection\Connection;
    use dao\status\DaoStatusImpl;
    use service\status\ServiceStatusImpl;

    $con = Connection::getInstance();
    $dao = new DaoStatusImpl( $con);
    $service =  new ServiceStatusImpl($dao);

    $server = new nusoap_server(); 
    $server->configureWSDL("Status","urn:Status");

        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        $server->register(
            "getAll", 
            array(),  
            array("return"=>"xsd:string"), 
            'urn:status',  
            'urn:status#getAll'
        );

        #------------------------------------------------------
        function getById($id):String{
            global $service;            
            return json_encode($service->getByID($id));
            
        }

        $server->register(
            "getById", 
            array("id"=>"xsd:integer"),  
            array("return"=>"xsd:string"), 
            'urn:status',  
            'urn:status#getById' 
        );

        #-----------------------------------------------------
        function save($name){
            global $service;

            $entidad = array(
                "name"=>$name
            );

            return json_encode($service->save($entidad));
        }

        $server->register(
            "save", 
            array(
                "name"=>"xsd:string"
            ),  
            array("return"=>"xsd:string"), 
            'urn:status',  
            'urn:status#save'
        );

        #-----------------------------------------------------------
    
    $server->service(file_get_contents("php://input"));
?>
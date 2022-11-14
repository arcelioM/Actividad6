<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\depot\DaoDepotImpl;
    use service\depot\ServiceDepotImpl;

     $con = Connection::getInstance();
     $dao = new DaoDepotImpl( $con);
    $service =  new ServiceDepotImpl($dao);

    $server = new nusoap_server(); 
    $server->configureWSDL("Depot","urn:Depot"); 


        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        $server->register(
            "getAll", 
            array(),
            array("return"=>"xsd:string"), 
            'urn:depot', 
            'urn:depot#getAll' 
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
            'urn:depot',   
            'urn:depot#getById' 
        );

        #-----------------------------------------------------------------

        function save($branchName,$location,$idStatus){
            global $service;

            $entidad = array(
                "branchName"=>$branchName,
                "location"=>$location,
                "idStatus"=>$idStatus
            );

            return json_encode($service->save($entidad));
        }

        $server->register(
            "save", 
            array(
                "branchName"=>"xsd:string",
                "location"=>"xsd:string",
                "idStatus"=>"xsd:integer"
            ),  // inputs
            array("return"=>"xsd:string"), 
            'urn:depot',   
            'urn:depot#save'
        );

        #-------------------------------------------------------------


    
    
    $server->service(file_get_contents("php://input"));
?>
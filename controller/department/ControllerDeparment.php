<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\department\DaoDepartmentImpl;
    use service\department\ServiceDepartmentImpl;

     $con = Connection::getInstance();
     $dao = new DaoDepartmentImpl( $con);
    $service =  new ServiceDepartmentImpl($dao);

    $server = new nusoap_server(); 
    $server->configureWSDL("department","urn:department"); 


        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        $server->register(
            "getAll", 
            array(),
            array("return"=>"xsd:string"), 
            'urn:department', 
            'urn:department#getAll' 
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
            'urn:department',   
            'urn:department#getById' 
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
            'urn:department',   
            'urn:department#save'
        );

        #-------------------------------------------------------------


    
    
    $server->service(file_get_contents("php://input"));
?>
<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\product\DaoProductImpl;
    use service\product\ServiceProductImpl;

     $con = Connection::getInstance();
     $dao = new DaoProductImpl( $con);
    $service =  new ServiceProductImpl($dao);

    $server = new nusoap_server(); 
    $server->configureWSDL("Product","urn:product");


        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        $server->register(
            "getAll", 
            array(), 
            array("return"=>"xsd:string"), 
            'urn:product',  
            'urn:product#getAll' 
        );

        #----------------------------------------------------------

        function getById($id):String{
            global $service;            
            return json_encode($service->getByID($id));
            
        }

        
        $server->register(
            "getById", 
            array("id"=>"xsd:integer"), 
            array("return"=>"xsd:string"), 
            'urn:product',  
            'urn:product#getById' 
        );
        #----------------------------------------------------------------
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

        $server->register(
            "save", 
            array(
                "name"=>"xsd:string",
                "idTypeProduct"=>"xsd:integer",
                "price"=>"xsd:decimal",
                "experationDate"=>"xsd:string",
                "idStatus"=>"xsd:integer"
            ),  
            array("return"=>"xsd:string"), 
            'urn:product',   
            'urn:product#save' 
        );

        #-----------------------------------------------------------------

   
    
    $server->service(file_get_contents("php://input"));
?>
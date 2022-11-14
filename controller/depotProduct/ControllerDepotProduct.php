<?php 
    require_once("../../autoloads.php");
    require_once("../../vendor/econea/nusoap/src/nusoap.php");
    use dao\connection\Connection;
    use dao\depotProduct\DaoDepotProductImpl;
    use service\depotProduct\ServiceDepotProductImpl;

    $con = Connection::getInstance();
    $dao = new DaoDepotProductImpl( $con);
    $service =  new ServiceDepotProductImpl($dao);

    $server = new nusoap_server(); # Creando Instancia de NuSoap
    $server->configureWSDL("DepotProduct","urn:depotProduct"); # Configuracion de archivo WSDL

        function getAll(){
            global $service;
            
            return json_encode($service->getAll());
        }

        $server->register(
            "getAll", 
            array(), 
            array("return"=>"xsd:string"), 
            'urn:depotProduct',   
            'urn:depotProduct#getAll' 
        );

        #----------------------------------------------

        function getById($id):String{
            global $service;
            
            return json_encode($service->getByID($id));
            
        }

        $server->register(
            "getById", # nombre de funcion
            array("id"=>"xsd:integer"),  # valores de entrada
            array("return"=>"xsd:string"), // valores para retorno
            'urn:depotProduct',   #nameSpace
            'urn:depotProduct#getById' #SoapAction
        );

        #-----------------------------------------------------------------------

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

        $server->register(
            "save", 
            array(
                "idProduct"=>"xsd:integer",
                "idDepotDepartment"=>"xsd:integer",
                "quantity"=>"xsd:integer",
                "idStatus"=>"xsd:integer"
            ),  // inputs
            array("return"=>"xsd:string"), 
            'urn:depotProduct',  
            'urn:depotProduct#save'
        );
        #------------------------------------------------------
        
    
    $server->service(file_get_contents("php://input"));
?>
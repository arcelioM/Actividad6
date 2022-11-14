<?php 

    /**
     * cuando el código intente crear una instancia que PHP desconoce todavía, PHP llamará automáticamente a la función 'autLoad', pasándole el nombre de la clase que está intentando instanciar. El objetivo de la función es localizar e incluir el archivo de la clase. PHP ahora podrá entonces cargar la clase que antes desconocía, y crear el objeto
     * 
     */
    function autLoads(String $class):void{

        $url= "".str_replace("\\","/",$class.".php"); 
        //if(file_exists(($url))){
            require_once($url);
        //}else{
          //  die("EL archivo $url no se ha podido encontrar o no existe");
        //}

    }
    spl_autoload_register('autLoads');
?>
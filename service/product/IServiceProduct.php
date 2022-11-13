<?php

namespace service\product;

use service\IServiceTemplate;

interface IServiceProduct extends IServiceTemplate{
    public function changeStatus( $entidad): array;

}
?>
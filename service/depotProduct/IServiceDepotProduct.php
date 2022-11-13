<?php

namespace service\depotProduct;
use service\IServiceTemplate;

interface IServiceDepotProduct extends IServiceTemplate{

    public function changeStatus( $entidad): array;
}
<?php

namespace service\depotDepartment;
use service\IServiceTemplate;

interface IServiceDepotDepartment extends IServiceTemplate{

    public function changeStatus( $entidad): array;
}

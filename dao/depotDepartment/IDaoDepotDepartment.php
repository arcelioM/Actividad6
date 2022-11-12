<?php

namespace dao\depotDepartment;
use dao\IDaoTemplate;
use model\DepotDepartment;

interface IDaoDepotDepartment extends IDaoTemplate{

    public function changeStatus(DepotDepartment $depotDepartment): ?int;
}

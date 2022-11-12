<?php

namespace dao\department;
use dao\IDaoTemplate;
use model\Deparment;

interface IDaoDepartment extends IDaoTemplate{ 
    
    public function changeStatus(Deparment $entidad): ?int;
}

<?php

namespace dao\depot;
use dao\IDaoTemplate;
use model\Depot;

interface IDaoDepot extends IDaoTemplate{

    public function changeStatus(Depot $entidad): ?int;
}

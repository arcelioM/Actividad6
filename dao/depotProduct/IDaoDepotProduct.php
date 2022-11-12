<?php

namespace dao\depotProduct;
use dao\IDaoTemplate;
use model\DepotProduct;

interface IDaoDepotProduct extends IDaoTemplate{

    public function changeStatus(DepotProduct $depotProduct): ?int;
}

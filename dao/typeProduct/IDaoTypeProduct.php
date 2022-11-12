<?php

namespace dao\typeProduct;

use dao\IDaoTemplate;
use model\TypeProduct;

interface IDaoTypeProduct extends IDaoTemplate{

    public function changeStatus(TypeProduct $typeProduct): ?int;
}

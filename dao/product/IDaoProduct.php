<?php

	namespace dao\product;

use dao\IDaoTemplate;
use model\Product;

interface IDaoProduct extends IDaoTemplate{

	public function changeStatus(Product $depotProduct): ?int;
}
?>

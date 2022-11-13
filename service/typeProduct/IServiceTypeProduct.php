<?php

namespace service\typeProduct;
use service\IServiceTemplate;

interface IServiceTypeProduct extends IServiceTemplate{

    public function changeStatus($entidad): array;
}

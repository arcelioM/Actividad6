<?php

namespace service\depot;
use service\IServiceTemplate;

interface IServiceDepot extends IServiceTemplate{

    public function changeStatus($entidad):array;
}

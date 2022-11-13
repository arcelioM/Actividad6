<?php

namespace service\department;
use service\IServiceTemplate;

interface IServiceDepartment extends IServiceTemplate{

    public function changeStatus($entidad): array;
}

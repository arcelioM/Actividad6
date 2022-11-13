<?php

namespace service;

interface IServiceTemplate{

    public function getAll(): ?array;
    public function getByID($id): array;
    public function save($entidad): array;
    public function update($entidad): array;
}

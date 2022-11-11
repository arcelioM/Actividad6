<?php

namespace dao;

interface IDaoTemplate{

    public function getAll();
    public function getByID($id);
    public function save($entidad):int;
    public function update($entidad):int;
}

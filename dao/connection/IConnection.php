<?php

namespace dao\connection;

use PDO;
interface IConnection{

    public function getConnection():PDO;
    public static function getInstance():IConnection;
    public function closeConnection():void;
}

<?php

namespace util;
use DateTime;
class Log{

    private  $fileLog;

    private function __construct()
    {
        $this->fileLog = fopen(__DIR__."/../log.txt","a");
    }

    public static function  write(String $message, String $mode){
        $log=new Log();
        $date = new DateTime(); 
        fputs($log->fileLog,"[".$mode."] [".$date->format('Y-m-d | H:i:s')."] | ".$message." \n");
        fclose($log->fileLog);
    }
}

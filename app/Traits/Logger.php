<?php

namespace App\Traits;

trait Logger
{
    public function log(string $message): void
    {
        $logFile = fopen('log.txt', 'a');
        $timestamp = '['.date("Y-m-d H:i:s",time()).'] ';
        fwrite($logFile, $timestamp.$message."\r\n");
        fclose($logFile);
    }
}

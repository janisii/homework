<?php

class Logger
{
    private $logFileName = 'application.log';

    public function __construct()
    {
        $this->createLogFile();
    }

    public static function get()
    {
        return new self();
    }

    public function logError($message)
    {
        $logFile = fopen('application.log', 'w');
        fwrite($logFile, 'ERROR: ' . $message);
        fclose($logFile);
    }

    public function logSuccess($msg)
    {
        $logFile = fopen('application.log', 'a');
        fwrite($logFile, 'SUCCESS: ' . $msg);
    }

    /**
     * Create log file
     */
    public function createLogFile()
    {
        // check if file exists, return if file found
        if (file_exists($this->logFileName)) {
            return false;
        }
        // create empty file
        if (file_put_contents($this->logFileName, '') === false) {
            return false;
        }

        // Completed
        return true;
    }
}

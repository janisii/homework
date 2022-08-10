<?php

class Logger
{
    const MESSAGE_ERROR = 'ERROR';
    const MESSAGE_SUCCESS = 'SUCCESS';

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
        return $this->writeMessageToFile(self::MESSAGE_ERROR, $message);
    }

    public function logSuccess($message)
    {
        return $this->writeMessageToFile(self::MESSAGE_SUCCESS, $message);
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

        // file is created
        return true;
    }

    /**
     * Write log message to file
     */
    private function writeMessageToFile(string $type, string $message)
    {
        // check if file is writebale
        if (!is_writable($this->logFileName)) {
            return false;
        }

        // avoid to log empty messages
        if (empty(trim($message))) {
            return false;
        }

        // prepare log message
        $logMessage = $type . ': ' . $message . "\n";

        // open log file
        $logFile = fopen($this->logFileName, 'a');

        // could not open the file
        if ($logFile === false) {
            return false;
        }

        // write to file
        $fWriteResult = fwrite($logFile, $logMessage);

        // could not write to file
        if ($fWriteResult === false) {
            return false;
        }

        // close file
        fclose($logFile);

        // return logged message
        return trim($logMessage);
    }
}

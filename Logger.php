<?php

/**
 * Logger
 */
class Logger
{
    // logger message types
    const MESSAGE_ERROR = 'ERROR';
    const MESSAGE_SUCCESS = 'SUCCESS';

    // logger data file
    const LOG_FILE = 'application.log';

    // log to console
    private $console = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createLogFile();
        $this->enableConsole();
    }

    /**
     * Return self instance
     */
    public static function get(): Logger
    {
        return new self();
    }

    /**
     * Log success message
     *
     * @param  mixed $message
     * @return string|boolean
     */
    public function logError($message): string|bool
    {
        return $this->writeMessageToFile(self::MESSAGE_ERROR, $message);
    }

    /**
     * Log success message
     *
     * @param  mixed $message
     * @return string|boolean
     */
    public function logSuccess($message): string|bool
    {
        return $this->writeMessageToFile(self::MESSAGE_SUCCESS, $message);
    }

    /**
     * Create log file
     *
     * @return boolean
     */
    public function createLogFile(): bool
    {
        // check if file exists, return if file found
        if (file_exists(self::LOG_FILE)) {
            return true;
        }

        // create empty file
        if (file_put_contents(self::LOG_FILE, '') === false) {
            return false;
        }

        // file is created
        return true;
    }

    /**
     * Write log message to file
     *
     * @param  mixed $type
     * @param  mixed $message
     * @return string|boolean
     */
    private function writeMessageToFile(string $type, string $message): string|bool
    {
        // check if file is writebale
        if (!is_writable(self::LOG_FILE)) {
            return false;
        }

        // avoid to log empty messages
        if (empty(trim($message))) {
            return false;
        }

        // prepare log message
        $logMessage = $type . ': ' . $message . "\n";

        // open log file
        $logFile = fopen(self::LOG_FILE, 'a');

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

        // log message to console
        if ($this->console) {
            echo $logMessage;
        }

        // return logged message
        return trim($logMessage);
    }

    /**
     * Enable console if first argv param is --console
     *
     * @return boolean
     */
    private function enableConsole(): bool
    {
        // no params
        if (!isset($_SERVER["argv"][1])) {
            return false;
        }

        // check if first param is --console
        if (trim($_SERVER["argv"][1]) !== '--console') {
            return false;
        }

        // enable console
        return $this->console = true;
    }
}

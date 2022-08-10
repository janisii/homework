<?php

namespace Janis\Homework;

require_once 'Logger.php';

use Logger;
use PHPUnit\Framework\TestCase;

final class LoggerTest extends TestCase
{
    // Test logError
    public function testLogError()
    {
        $logger = Logger::get();
        $errorMessage = 'Testing Error message';
        $this->assertSame($logger::MESSAGE_ERROR . ': ' . $errorMessage, $logger->logError($errorMessage));
    }

    // Test logSuccess
    public function testLogSuccess()
    {
        $logger = Logger::get();
        $successMessage = 'Testing Success message';
        $this->assertSame($logger::MESSAGE_SUCCESS . ': ' . $successMessage, $logger->logSuccess($successMessage));
    }

    // Test logger data file creation
    public function testCreateLogFile()
    {
        $logger = Logger::get();
        $this->assertTrue($logger->createLogFile());
    }
}

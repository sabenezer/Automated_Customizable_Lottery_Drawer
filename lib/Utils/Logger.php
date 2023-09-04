<?php

/**
 * Logger class to log erros actions.
 * @author Bantayehu Fikadu <bantayehuf@gmail.com>
 * @package Lib\Utils
 */

namespace Lib\Utils;

class Logger
{
    /**
     * Logs errors
     * @var string $context Context of actions performed.
     */
    public static function Log($context): bool
    {
        $log_file = self::GetLogFile();

        if (self::LogToFile($log_file, $context)) // 
            return true;
        return false;
    }

    public static function LogFileCreated(): bool
    {
        $log_store_directory = APP_DIR .  "/logs";
        if (!is_dir($log_store_directory)) {
            mkdir($log_store_directory, 0777, true);
        }

        return file_exists(LOG_FILE_PATH);
    }

    public static function GetLogFile()
    {
        if (!self::LogFileCreated()) {
            $log_file = fopen(LOG_FILE_PATH, 'w');
            return $log_file;
        }

        $log_file = fopen(LOG_FILE_PATH, 'a');
        return $log_file;
    }


    protected static function LogToFile($log_file, $context): bool
    {
        if (!is_writable(LOG_FILE_PATH))
            return false;

        $created_date = date("D-M-Y h:m:s A", date('now'));
        fwrite($log_file, "$created_date - {$context}" . PHP_EOL);
        fclose($log_file);
        return true;
    }
}

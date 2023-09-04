<?php

/**
 * Database controller.
 * @author Bantayehu Fikadu <bantayehuf@gmail.com>
 * 
 *There are 6 public functions that accept 2 parameters (query, value)
 * baseQuery() - For basic queries INSERT, UPDATE, and DELETE
 * baseSelect() - To select a single row (SELECT).
 * multiSelect() - To select multiple rows (SELECT)
 * countAffectedRows() - To get the affected rows for the given query
 * countNumberOfRows() - To found number of rows existing in the database;
 * customQueryExecute() - To execute custom query
 */

namespace Lib\Config;

use Lib\Utils\Logger;
use PDO;
use PDOException;

class DBController
{

    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PASS = '';
    private const DB_NAME = 'abay_lottery_draws';

    public $conn = null;
    private $statement = null;

    //Intialize database connection.
    public function __construct()
    {
        try {
            $this->conn = $this->connectDB();
        } catch (PDOException $exc) {
            require_once APP_DIR . '/includes/template/database_crush_error.php';
            Logger::Log($exc->getMessage());
            die();
        }
    }

    //PDO database connection
    private function connectDB()
    {
        $conn = new PDO("mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME, self::DB_USER, self::DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    /**
     * Clean unwanted spaces and characters from the values
     *
     * @param string $value
     * @return string
     */
    private function cleanValue($value)
    {
        return empty(trim($value)) ? $value : htmlentities(trim($value));
    }

    /**
     * For bind values into the current executing query statement
     *
     * @param array $value
     * @return void
     */
    private function bindQueryParams(array $value): void
    {
        $num = count($value);
        $colCount = 1;
        for ($i = 0; $i < $num; $i++) {
            $this->statement->bindParam($colCount, $this->cleanValue($value[$i]), PDO::PARAM_STR);
            $colCount = $colCount + 1;
        }
    }

    /**
     * For retrieve a single row.
     *
     * @param string $query
     * @param array $value
     * @return array
     */
    public function baseSelect(string $query, array $value): array
    {
        try {
            $this->statement = $this->conn->prepare($query);
            if (!empty($value)) {
                $this->bindQueryParams($value);
            }
            $this->statement->execute();
            $row = $this->statement->fetch(PDO::FETCH_OBJ);
            return array('Success', $row);
        } catch (PDOException $exc) {
            return array('Error', $exc->getMessage());
        }
    }

    /**
     * For retrieve multiple rows
     *
     * @param string $query
     * @param array $value
     * @return array
     */
    public function multiSelect(string $query, array $value): array
    {
        try {
            $this->statement = $this->conn->prepare($query);
            if (!empty($value)) {
                $this->bindQueryParams($value);
            }
            $this->statement->execute();
            $rows = $this->statement->fetchAll(PDO::FETCH_OBJ);
            return array('Success', $rows);
        } catch (PDOException $exc) {
            return array('Error', $exc->getMessage());
        }
    }

    /**
     * For execute queries (INSERT, UPDATE, DELETE)
     *
     * @param string $query
     * @param array $value
     * @return array
     */
    public function baseQuery(string $query, array $value): array
    {
        try {
            $this->statement = $this->conn->prepare($query);
            if (!empty($value)) {
                $this->bindQueryParams($value);
            }
            $this->statement->execute();

            if ($this->statement->rowCount() > 0) {
                return array('Success', $this->statement->rowCount());
            } else {
                return array('Failed', 'Action has not completed successfully.');
            }
        } catch (PDOException $exc) {
            return array('Error', $exc->getMessage());
        }
    }

    /**
     * Count number of rows affected for the given queary
     *
     * @param [string] $query
     * @param [array] $value
     * @return array
     */
    public function countAffectedRows(string $query, array $value): array
    {
        try {
            $this->statement = $this->conn->prepare($query);
            if (!empty($value)) {
                $this->bindQueryParams($value);
            }
            $this->statement->execute();
            return array('Success', $this->statement->rowCount());
        } catch (PDOException $exc) {
            return array('Error', $exc->getMessage());
        }
    }

    /**
     * Count number of rows found in the table
     *
     * @param string $query
     * @param array $value
     * @return array
     */
    public function countNumberOfRows(string $query, array $value): array
    {
        try {
            $this->statement = $this->conn->prepare($query);
            if (!empty($value)) {
                $this->bindQueryParams($value);
            }
            $this->statement->execute();
            return array('Success', $this->statement->fetchColumn());
        } catch (PDOException $exc) {
            return array('Error', $exc->getMessage());
        }
    }

    /**
     * Executes custom query and returns db connection and query statment.
     * To control affected
     *
     * @param string $query
     * @param array $value
     * @return array
     */
    public function customQueryExecute(string $query, array $value)
    {
        try {
            $this->statement = $this->conn->prepare($query);
            if (!empty($value)) {
                $this->bindQueryParams($value);
            }
            $this->statement->execute();
            return array('Success', $this->conn, $this->statement);
        } catch (PDOException $exc) {
            return array('Error', $exc->getMessage());
        }
    }
}

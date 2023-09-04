<?php
ini_set('max_execution_time', 0); // unlimited execution time.
ini_set('memory_limit', -1); // unlimited memory size allocation.

use Lib\Config\DBController;
use Lib\Utils\TextGenerator;

require_once __DIR__ . '/lib/bootstrap.php';

class MockData
{
    private $db;

    function __construct()
    {
        $this->db = new DBController;
    }

    /**
     * Inserts data into coupons table.
     *
     * @param integer $coupon
     * @param integer $phone
     * @return void
     */
    private function insertCoupons(int $coupon, int $phone)
    {
        $query = <<<SQL
            INSERT INTO coupons
            SET coupon=?, phone=?
        SQL;

        $values = [$coupon, $phone];

        $this->db->baseQuery($query, $values);
    }

    /**
     * Generat random values
     *
     * @param integer $count
     * @return void
     */
    public function importRandom(int $count)
    {
        for ($i = 1; $i <= $count; $i++) {
            $rand = mt_rand(3, 8);
            $coupon =  TextGenerator::generateNumber($rand);
            $phone =  '2519' . TextGenerator::generateNumber(8);

            $this->insertCoupons($coupon, $phone);
        }
    }

    /**
     * Import from CSV file.
     *
     * @return void
     */
    public function importFromCsv()
    {
        $lines = file('D:\export.csv', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line) {
            $values = explode(',', $line);

            $coupon = intval(trim($values[0], "\""));
            $phone = intval(trim($values[1], "\""));

            if(!$coupon || !$phone)
                continue;

            $this->insertCoupons($coupon, $phone);
        }
    }
}


$flag = trim($argv[1]);
$mock = new MockData;

switch ($flag) {
    case 'csv':
        $mock->importFromCsv();
        break;
    case 'rand':
        $mock->importRandom(10);
        break;
    default:
        echo "\nrequired flag: csv --- to import from CSV OR rand -- to import random values\n\n";
}

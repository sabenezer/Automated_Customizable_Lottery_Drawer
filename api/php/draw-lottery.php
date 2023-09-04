<?php
session_start();
set_time_limit(600); // script execution timeout for 10 minutes or 600 seconds

require_once __DIR__ . "/../../lib/bootstrap.php";

use Lib\Config\DBController as Database;
use Lib\Utils\Logger;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: allow");
header("Access-Control-Allow-Method: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-type:application/json;charset=utf-8");

if (!isset($_GET['draw']) || htmlentities($_GET['draw']) !== 'abay-lottery') {
    http_response_code(400);
    echo "Bad Request.";
    die();
}


$coupon_possible_length = 8;

try {
    $db = new Database;

    /**
     * Counting number of coupons to check the availability of coupons to be draw.
     */
    $query = <<<SQL
        SELECT COUNT(id) num FROM coupons
    SQL;
    $values = [];

    $coupons_num = $db->baseSelect($query, $values);

    if (strtolower($coupons_num[0]) !== 'success') {
        Logger::Log($coupons_num[1]);
        throw new Exception('Failed to Proceed');
    }

    if ($coupons_num[1]->num <= 0) {
        http_response_code(404);
        die('Coupons Not Found to Draw');
    }

    /**
     * Fetches maximum and minimum coupon from the ranger.
     */
    $query = <<<SQL
        SELECT MIN(id) as min_coupon, Max(id) as max_coupon FROM coupons;
    SQL;
    $values = [];

    $coupon_range = $db->baseSelect($query, $values);

    if (strtolower($coupon_range[0]) !== 'success') {
        Logger::Log($coupon_range[1]);
        throw new Exception('Failed to Proceed');
    }

    /**
     * Fetches already selected coupons
     */
    $query = <<<SQL
        SELECT coupon_id FROM winners
    SQL;
    $values = [];

    $winners = $db->multiSelect($query, $values);

    if (strtolower($winners[0]) !== 'success') {
        Logger::Log($winners[1]);
        throw new Exception('Failed to Proceed');
    }

    $coupons_already_selected = [];
    if (!empty($winners[1])) {
        foreach ($winners[1] as $winner) {
            array_push($coupons_already_selected, intval($winner->coupon_id));
        }
    }

    /**
     * Selecting random coupon
     */
    $query = <<<SQL
        SELECT * FROM coupons WHERE id=?;
    SQL;
    $current_winner;
    while (true) {
        $random_coupon = mt_rand($coupon_range[1]->min_coupon, $coupon_range[1]->max_coupon);
        // $random_coupon = $coupon_range[1]->min_coupon;

        // If randomly generated coupon founds in already selected coupons, 
        // skipps the current operation and regenerate another coupon.
        if (in_array($random_coupon, $coupons_already_selected)) {
            // die('Coupon ' . $random_coupon . ' already selected.');
            continue;
        }

        $values = [$random_coupon];

        $result = $db->baseSelect($query, $values);

        if (strtolower($result[0]) !== 'success') {
            Logger::Log($result[1]);
            throw new Exception('Failed to Proceed');
        }

        // If the generated coupon is valid and found in coupons (probability)
        // mark it as the current winner and break the loop.
        if (!empty($result[1])) {
            $current_winner = $result[1];
            break;
        }
    }

    if (!$current_winner) {
        throw new Exception('Failed to Proceed');
    }

    $draw_rounds = ['1st', '2nd', '3rd', '4th', '5th'];
    $record_round = '';
    $lmt_1 = 1;
    $lmt_2 = $lmt_3 = $lmt_4 = 10;
    $lmt_5 = 20;

    foreach ($draw_rounds as $draw_round) {
        $query = <<<SQL
            SELECT COUNT(id) num FROM winners
            WHERE draw_round=?
        SQL;
        $values = [$draw_round];

        $num_result = $db->baseSelect($query, $values);

        if (strtolower($num_result[0]) !== 'success') {
            Logger::Log($num_result[1]);
            throw new Exception('Failed to Proceed');
        }

        $draw_count = $num_result[1]->num;

        switch ($draw_round) {
            case '1st':
                if ($draw_count < $lmt_1)
                    $record_round = '1st';
                break;
            case '2nd':
                if ($draw_count < $lmt_2)
                    $record_round = '2nd';
                break;
            case '3rd':
                if ($draw_count <  $lmt_3)
                    $record_round = '3rd';
                break;
            case '4th':
                if ($draw_count <  $lmt_4)
                    $record_round = '4th';
                break;
            case '5th':
                if ($draw_count <  $lmt_5)
                    $record_round = '5th';
                break;
        }

        if ($record_round)
            break;
    }


    if (!$record_round) {
        http_response_code(409);
        die('Draw already completed');
    }

    /**
     * Inserting the seleted coupon as a winner
     */
    $query = <<<SQL
        INSERT INTO winners SET coupon_id=?, draw_round=?
    SQL;
    $values = [$current_winner->id, $record_round];

    $res = $db->baseQuery($query, $values);

    if (strtolower($res[0]) !== 'success') {
        Logger::Log($res[1]);
        throw new Exception('Failed to Proceed');
    }

    $winner_coupon = $current_winner->coupon;

    /**
     * If coupon lenth is not meet the given possibe length,
     * append zero as a prefix.
     */
    if (strlen($winner_coupon) < $coupon_possible_length) {
        $winner_coupon = appedZero($winner_coupon, $coupon_possible_length);
    }

    $query = <<<SQL
        SELECT 
            winners.id, winners.draw_round, coupons.coupon
        FROM winners
        INNER JOIN coupons ON coupons.id = winners.coupon_id
        ORDER BY draw_round
    SQL;
    $values = [];

    $all_winners = $db->multiSelect($query, $values);

    if (strtolower($all_winners[0]) !== 'success') {
        Logger::Log($all_winners[1]);
        throw new Exception('Failed to Proceed');
    }

    $lot_1st = localArrayFilter($all_winners[1], '1st');
    $lot_2nd = localArrayFilter($all_winners[1], '2nd');
    $lot_3rd = localArrayFilter($all_winners[1], '3rd');
    $lot_4th = localArrayFilter($all_winners[1], '4th');
    $lot_5th = localArrayFilter($all_winners[1], '5th');

    $rounds_in_amharic = [
        '1st' => '1ኛ ዕጣ',
        '2nd' => '2ኛ ዕጣ',
        '3rd' => '3ኛ ዕጣ',
        '4th' => '4ኛ ዕጣ',
        '5th' => '5ኛ ዕጣ',
    ];

    $response = array(
        'current_winner' => [
            'coupon' => $winner_coupon,
            'draw_round' => $rounds_in_amharic[$record_round],
            'draw_count' => $draw_count+1
        ],
        'all_winners' => [
            'lot_1st' => $lot_1st,
            'lot_2nd' => $lot_2nd,
            'lot_3rd' => $lot_3rd,
            'lot_4th' => $lot_4th,
            'lot_5th' => $lot_5th,
        ],
    );

    // Finally send response
    echo json_encode($response);
    http_response_code(200);
} catch (Exception  $e) {
    http_response_code(500);
    echo 'Internal Server Error';
}


/**
 * Append zero to string to achive the given zero
 *
 * @param string $value
 * @param integer $length | lenth to achive
 * @return void
 */
function appedZero(string $value, int $length)
{
    if (strlen($value) < $length) {
        $value = '0' . $value;
        return appedZero($value, $length);
    }

    return $value;
}

function localArrayFilter(array $array, string|int $flag)
{
    global  $coupon_possible_length;

    $new_array = [];
    foreach ($array as $value) {
        if ($value->draw_round === $flag) {
            $cpn = $value->coupon;

            if (strlen($cpn) < $coupon_possible_length) {
                $cpn = appedZero($cpn, $coupon_possible_length);
            }

            $value->coupon = $cpn;

            array_push($new_array, $value);
        }
    }

    return $new_array;
}

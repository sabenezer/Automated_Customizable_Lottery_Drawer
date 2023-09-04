<?php
require_once __DIR__ . '/includes/template/header.php';

use Lib\Config\DBController as Database;
use Lib\Utils\Logger;

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
    $coupon_possible_length = 8;

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

$db = new Database;

$query = <<<SQL
        SELECT 
            winners.id, 
            winners.draw_round, 
            coupons.coupon,
            coupons.phone
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

$all_draws = array(
    'lot_1st' => $lot_1st,
    'lot_2nd' => $lot_2nd,
    'lot_3rd' => $lot_3rd,
    'lot_4th' => $lot_4th,
    'lot_5th' => $lot_5th,
);

require_once __DIR__ . '/includes/functions/table-builder.php';
?>

<div class="container py-3">
    <div class="row">
        <div class="col-12" id="printAreaHeader">
            <?php require_once __DIR__ . '/includes/template/print-area-header.php'; ?>
        </div>

        <div class="col-12 mt-2">
            <?php

            $print_1_and_2 = '';
            $print_others = '';

            foreach ($all_draws as $index => $winners) :
                if (count($winners) <= 0)
                    continue;

                $html = tableBuilder($index, $winners);
                if ($index === 'lot_1st' || $index === 'lot_2nd') {
                    $print_1_and_2 .= <<<HTML
                        <div class='mt-2'>$html</div>
                    HTML;
                } else {
                    $print_others .= <<<HTML
                        <div id="{$index}">
                            $html
                        </div>

                        <button onclick="printTable('{$index}')" class="btn btn-primary btn-sm mt-1 mb-4">Print table</button>
                    HTML;
                }
            endforeach;

            $print_1_and_2 = <<<HTML
                 <div id="print_1_and_2">
                    $print_1_and_2
                </div>

                <button onclick="printTable('print_1_and_2')" class="btn btn-primary btn-sm mt-1 mb-4">Print table</button>
            HTML;

            echo $print_1_and_2;
            echo $print_others;
            ?>
        </div>

        <div class="mt-3 mb-5" id="printAreaFooter">
            <?php require_once __DIR__ . '/includes/template/print-area-footer.php'; ?>
        </div>
    </div>
</div>

<?php require_once  __DIR__ . '/includes/template/footer.php'; ?>
<script src="./assets/js/print_this.js"></script>

<script>
    function printTable(printArea) {
        console.log(printArea);
        $(`#${printArea}`).printThis({
            header: $('#printAreaHeader').html(),
            footer: $('#printAreaFooter').html(),
        });
    }
</script>
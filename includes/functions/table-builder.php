<?php
function tableBuilder($index, $winners)
{
    $num = count($winners);
    if ($num <= 0)
        return;

    $lot_order = '';
    $gitf_type = '';
    switch ($index) {
        case 'lot_1st';
            $lot_order = '1ኛ';
            $gitf_type = 'ሱዚኪ ዲዛየር';
            break;
        case 'lot_2nd';
            $lot_order = '2ኛ';
            $gitf_type = 'ማቀዝቀዣ ማሽን';
            break;
        case 'lot_3rd';
            $lot_order = '3ኛ';
            $gitf_type = 'ላፕቶፕ ኮሚፕዩተር';
            break;
        case 'lot_4th';
            $lot_order = '4ኛ';
            $gitf_type = 'ሳምሰንግ ቴለቪዥን';
            break;
        case 'lot_5th';
            $lot_order = '5ኛ';
            $gitf_type = 'ሳምሰንግ ሞባይል ስልክ';
            break;
    }

    $rowspan =  'rowspan="' . $num + 1 . '"';
    $winns_v  = buildWinners($winners);

    $result_r = <<<HTML
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align:center;vertical-align: middle;">ዕጣ</th>
                    <th rowspan="2" style="text-align:center;vertical-align: middle;">የሽልማቱ ዓይነት</th>
                    <th colspan="2" style="text-align:center;">አሸናፊዎች</th>
                </tr>
                <tr>
                    <th style="text-align:center;vertical-align: middle;">የአሸናፊ ዕጣ ቁጥር</th>
                    <th style="text-align:center;">ስልክ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th $rowspan>$lot_order</th>
                    <td $rowspan>$gitf_type</td>
                </tr>

                $winns_v
            </tbody>
        </table>
    HTML;

    return  $result_r;
}

function buildWinners($winners)
{
    $winns = '';

    foreach ($winners as $winner) :
        $winns .= <<<HTML
            <tr>
                <td>$winner->coupon</td>
                <td>$winner->phone</td>
            </tr>
        HTML;
    endforeach;

    return $winns;
}

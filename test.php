<?php
$money_total = 100;
$personal_num = 10;
$min_money = 0.01;
$money_right = $money_total;
$randMoney = [];
for ($i = 1; $i <= $personal_num; $i++) {
    if ($i == $personal_num) {
        $money = $money_right;
    } else {
        $max = $money_right * 100 - ($personal_num - $i) * $min_money * 100;
        $money = rand($min_money * 100, $max) / 100;
        $money = sprintf("%.2f", $money);
    }
    $randMoney[] = $money;
    $money_right = $money_right - $money;
    $money_right = sprintf("%.2f", $money_right);
}

<?php

# 设置默认小数位数
bcscale(4);

# 指定长度数组填充
$array = array_fill(0, $div, bcdiv($total, $div));

# 生成指定长度
$maxPow = bcpow(10, 4);
$minPow = bcpow(10, 2);

# 每个数组减去随机的数
foreach ($array as &$value) {
    # 转换为一个比较大的数
    $temp = bcmul($value, $maxPow);
    # 随机一个数字
    $rand = mt_rand($minPow, $temp);
    # 求差
    $temp = $temp - $rand;
    # 取两位数
    $temp = intval(bcdiv($temp, $minPow));
    # 取两位小数
    $value = bcdiv($temp, $minPow);
}

$diff = $total - array_sum($array);
$avg = bcdiv($diff, $div);

// 加入随机的数字
foreach ($array as &$value) {
    $value = bcadd($value, $avg, 2);
}

/**
 * 分配余下数字
 * @param int $count
 * @param array $array
 * @return array
 */
function allocation($count, $array)
{
    foreach ($array as &$value) {
        if ($count <= 0) {
            break;
        }

        if (mt_rand(0, 1)) {
            $value += 0.01;
            $count--;
        }
    }

    if ($count > 0) {
        return allocation($count, $array);
    }

    return $array;
}

/**
 * 差距个数
 * @param $check
 * @param $total
 * @param int $scale
 * @return int
 */
function diffCount($check, $total, $scale = 2)
{
    # 去除小数的整数
    $temp = $check * bcpow(10, $scale);
    # 相同的证数
    $tempTotal = $total * bcpow(10, $scale);

    # 取差
    return intval(bcsub($tempTotal, $temp, 0));
}

# 计算和
$sum = array_sum($array);

// 取差距个数
$diff = diffCount($sum, $total);

// 随机分配余下金额
$array = allocation($diff, $array);

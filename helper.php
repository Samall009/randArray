<?php

/**
 * 通过一个数生成一个包含指定个数的随机数数组
 * @param float $total 总数
 * @param int $count 随机数个数
 * @param int $scale 保留小数位
 * @return array
 */
function rangeArray($total, int $count, int $scale = 2)
{
    // 设置默认小数位数
    bcscale($scale * 2);

    // 指定长度数组填充
    $array = array_fill(0, $count, bcdiv($total, $count));

    // 数组做随机减数处理
    arrayItemRangeSub($array, $scale);

    // 加入平均值
    // 可以进一步处理 做 加随机数
    arrayItemAdd($array, $total, $count, $scale);

    // 差值处理
    $arraySubCount = arraySubCount(array_sum($array), $total, $scale);

    // 获取步进
    $offset = offsetByScale($scale);

    // 数组元素随机增加步进
    arrayRangeAllocation($array, $arraySubCount, $offset);

    return $array;
}

/**
 * 数组随机减去数字
 * @param array $array
 * @param int $scale
 * @return array
 */
function arrayItemRangeSub(&$array, $scale)
{
    # 生成指定长度
    $maxPow = bcpow(10, $scale * 2);

    $minPow = bcpow(10, $scale);

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

    return $array;
}

/**
 * 数组元素做加入平均值处理
 * @param array $array
 * @param float $total
 * @param int $count
 * @param int $scale
 * @return array
 */
function arrayItemAdd(&$array, $total, $count, $scale)
{
    $diff = $total - array_sum($array);
    $avg = bcdiv($diff, $count);

    // 加入随机的数字
    foreach ($array as &$value) {
        $value = bcadd($value, $avg, $scale);
    }

    return $array;
}

/**
 * 数组和比较平均值的差值
 * @param $arraySum
 * @param $total
 * @param int $scale
 * @return int
 */
function arraySubCount($arraySum, $total, $scale)
{
    # 去除小数的整数
    $temp = $arraySum * bcpow(10, $scale);

    # 相同的证数
    $tempTotal = $total * bcpow(10, $scale);

    # 取差
    return intval(bcsub($tempTotal, $temp, 0));
}

/**
 * 获取小数位步进
 * @param $scale
 * @param int $offset
 * @return float|int
 */
function offsetByScale($scale, $offset = 1)
{
    // 获取步进
    $pow = bcpow(10, $scale);
    return $offset / $pow;
}

/**
 * 数组元素随机增加步进
 * @param array $array
 * @param int $count
 * @param int $offset
 * @return array
 */
function arrayRangeAllocation(&$array, $count, $offset = 1)
{
    foreach ($array as &$value) {
        // 判断count不为零
        if ($count <= 0) {
            break;
        }

        // 随机零或一
        if (mt_rand(0, 1)) {
            $value += $offset;
            $count--;
        }
    }

    if ($count > 0) {
        return arrayRangeAllocation($array, $count, $offset);
    }

    return $array;
}

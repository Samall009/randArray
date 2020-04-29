# randArray
通过一个数字获取一个数组
# 方法名称
```````php
/**
 * @param float $total 需要生成随机数的数字
 * @param int $count 需要生成的随机数个数
 * @param int $scale 保留小数位 默认值2
 * @return array
 */
function rangeArray($total, int $count, int $scale = 2) {}
```````

# 测试方法

```php
// 生成随机数
$array = rangeArray(100, 15);

// 打印数据
var_dump($array);

// 随机数生成数组和
var_dump(array_sum($array));
```

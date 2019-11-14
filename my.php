<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/14
 * Time: 17:03
 */

/*function sum($carry, $item) {
    var_dump($carry, $item);
    $carry += $item;
    echo '<br><hr>';
    return $carry;
}

$a = array(1, 2, 3, 4, 5);

var_dump(array_reduce($a, 'sum', 10));*/

class MakeUp {
    public static function handle(Closure $next) {
        echo '化妆打扮', '<br>';;
        $next();

    }
}
class Skirt {
    public static function handle(Closure $next) {
        echo '穿上裙子', '<br>';
        $next();
    }
}

$firstSlice = function (){
    echo '我要出去玩了～', '<br>';
};

$arr = [
    'MakeUp',
    'Skirt'
];

function getSlice(){
    return function ($stack, $pipe){
        return function () use ($stack, $pipe){
            return $pipe::handle($stack);
        };
    };
}

$go = array_reduce($arr, getSlice(), $firstSlice);

$go();
/*可以看到第一次执行时，stack 是一个匿名函数 , 也对应了官网介绍的作为第一次迭代时，$carry 是 initial，也就是$firstSlice。pipe 为MakeUp,但是它并没有执行而是直接返回了，也就是直接返回

function ($stack, $pipe){
    return function () use ($stack, $pipe){
        return $pipe::handle($stack);
    };

    匿名函数 function ($stack, $pipe)被返回后，也就相当于一个 array_reduce($arr, getSlice(), $firstSlice);，不同的是匿名函数 function ($stack, $pipe)代替了$firstSlice被传给下一次迭代。

第二次迭代时执行 Skire::handle，先穿上了美美的裙子，然后$next 执行匿名函数 function ($stack, $pipe)，也就是去MakeUp::handle，化妆后继续执行 $next，也就是匿名函数 $firstSlice。*/

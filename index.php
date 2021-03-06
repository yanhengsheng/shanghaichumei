<?php
//连接redis数据库
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$redis_name = 'secKill3';

//模拟100人请求秒杀(高压力)
for ($i = 0; $i < 100; $i++) {
    $uid = rand(10000000, 99999999);
    //获取当前队列已经拥有的数量,如果人数少于十,则加入这个队列
    $num = 10;
    if ($redis->lLen($redis_name) < $num) {
        $redis->rPush($redis_name, $uid);
        echo $uid . "秒杀成功"."<br>";
    } else {
        //如果当前队列人数已经达到10人,则返回秒杀已完成
        echo "秒杀已结束<br>";
    }
}
//关闭redis连接
$redis->close();

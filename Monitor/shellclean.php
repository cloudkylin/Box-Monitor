<?php
    date_default_timezone_set("Etc/GMT-8");

    //获取time表
    $time_tab = @json_decode(@file_get_contents('data/time.txt'), true);
    if (!$time_tab) {
        eixt();
    }
    
    //记录超时盒子IP
    $timeout = array();
    foreach($time_tab as $key => $value){
        $data = floor((strtotime("now") - strtotime($value))/86400);
        if($data >= 20){$timeout[] = $key;}
    }
    
    //判断是否需要清除
    if(empty($timeout)){
        exit();
    }
    
    //清除并报告超时盒子
    $name_tab = @json_decode(@file_get_contents('data/name.txt'), true);
    foreach($timeout as $value){
        unset($time_tab[$value]);
        unset($name_tab[$value]);
        @unlink('data/'.$value.'.txt');
    }
    file_put_contents('data/time.txt', json_encode($time_tab));
    file_put_contents('data/name.txt', json_encode($name_tab));
?>
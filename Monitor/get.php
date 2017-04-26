<?php
    function getIP()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else {
                $realip = getenv("REMOTE_ADDR");
            } 
        }
        return $realip;
    }
    //获取访问者IP
    $IP = getIP();
    
    //获取访问时间
    date_default_timezone_set("Etc/GMT-8"); 
    $time = date("Y-m-d H:i:s");
    $stime = date("Y-m-d");
    
    //获取POST内容
    //判断是否是盒子
    #if(empty($_POST)){
    #    exit();
    #}
    
    //获取剩余空间
    $free = $_POST['free'];
    if(empty($free)){
        $free = 'unknown';
    }
    
    //获取文件列表
    $file = $_POST['json'];
    if(empty($file)){
        $file = array(
            '0'=>array(
                'name'=>'No file',
                'state'=>'unknown'
                )
            );
    }else{
        $file = json_decode($_POST['json'],true);
    }
    
    
    //更新time表
    $new_time_tab = array(
        $IP => $time
        );
    $time_tab = @json_decode(@file_get_contents('data/time.txt'), true);
    if (!$time_tab) {$time_tab = array();}
    $time_tab = array_replace($time_tab,$new_time_tab);
    file_put_contents('data/time.txt', json_encode($time_tab));
    
    //更新IP详细信息
    if(!file_exists('data/' . $IP . '.txt')){
        touch('data/' . $IP . '.txt');
        $first = array(
            'name' => $IP,
            'first' => $stime,
            'latest' => $time
            );
        file_put_contents('data/' . $IP . '.txt', json_encode($first));
    }
    $all_msg = json_decode(file_get_contents('data/' . $IP . '.txt'), true);
    $update = array(
        'latest' => $time,
        'free' => $free,
        'file' => $file
        );
    $all_msg = array_replace($all_msg,$update);
    file_put_contents('data/' . $IP . '.txt', json_encode($all_msg));
    
    //返回成功信息
    echo 'ok';
?>
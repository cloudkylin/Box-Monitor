<html>
 <head> 
  <title>运行整理</title> 
  <meta charset="utf-8" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1" /> 
  <script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
        <script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="bootstrap.css" rel="stylesheet" type="text/css">
 </head>
 <body> 
  <div class="navbar navbar-default navbar-static-top">
   <div class="container">
    <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
     <a class="navbar-brand" href="#"><span>盒子监控</span></a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-ex-collapse">
     <ul class="nav navbar-nav navbar-right">
      <li><a href="index.php">所有盒子</a></li>
      <li class="active"><a href="clear.php">运行整理</a></li>
     </ul>
    </div>
   </div>
  </div>
<div class="section">
   <div class="container">
    <div class="row">
     <div class="col-md-12">
        <?php
            date_default_timezone_set("Etc/GMT-8");
            
            //获取time表
            $time_tab = @json_decode(@file_get_contents('data/time.txt'), true);
            if (!$time_tab) {
                echo '<h1 class="text-center">清理完成</h1>';
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
                echo '<h1 class="text-center">清理完成</h1>';
                exit();
            }
            
            //清除并报告超时盒子
            echo '<h2>以下盒子因超过20天未报告状态，已被清除列表</h2><hr />';
            foreach($timeout as $value){
                @unset($time_tab[$value]);
                @unlink('data/'.$value.'.txt');
                echo '<p>'.$value.'</p>';
            }
            file_put_contents('data/time.txt', json_encode($time_tab));
        ?>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>
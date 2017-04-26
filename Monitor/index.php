<html>
 <head> 
  <title>盒子监控</title> 
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
      <li class="active"><a href="index.php">所有盒子</a></li>
      <li><a href="clear.php">运行整理</a></li>
     </ul>
    </div>
   </div>
  </div>
  <div class="section">
   <div class="container">
    <div class="row">
     <div class="col-md-12">
      <table class="table">
       <thead>
        <tr>
         <th>盒子信息</th>
         <th>报告时间</th>
         <th>报告</th>
        </tr>
       </thead>
       <tbody>
        <?php
         date_default_timezone_set("Etc/GMT-8");
         $time_tab = @json_decode(@file_get_contents('data/time.txt'), true);
         if (!$time_tab) {$time_tab = array();}
         foreach ($time_tab as $key => $value) {
          echo '<tr>';
          echo '<td><a href="detal.php?ip='.$key.'">'.$key.'</a></td>';
          echo '<td>'.$value.'</td>';
          $date = floor((strtotime("now") - strtotime($value))/86400);
           if( $date > 1 ){
            echo '<td>该服务器已经超过'.$date.'天未提交数据</td>';
          }else{
            echo '<td>运行良好</td>';
          }
          echo '</tr>';
         }
        ?>
       </tbody>
      </table>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>


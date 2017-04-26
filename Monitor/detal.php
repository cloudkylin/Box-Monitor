<html>
 <head>
  <title>详细信息</title> 
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
      <li><a href="clear.php">运行整理</a></li>
     </ul>
    </div>
   </div>
  </div>
  <div class="section">
   <div class="container">
    <div class="row">
     <div class="col-md-12">
      <div class="panel panel-default" id="detaltab">
       <?php 
        $ip = $_GET['ip'];
        include 'api.php';
           
        echo '</div>
        <div class="row">
         <div class="col-md-12">
          <table class="table">
           <thead>
            <tr>
             <th>文件名</th>
             <th>状态</th>
            </tr>
           </thead>
           <tbody>';
       
        $file = json_decode(file_get_contents('data/'.$ip.'.txt'), true);
        $file = $file['file'];
       
        foreach($file as $value){
            echo "<tr>";
            echo "<td>".$value['name']."</td>";
            echo "<td>".$value['state']."</td>";
            echo "</tr>";
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
</html>
</html>
<?php
    function getdata($ip){
        //读取对应IP数据
        $list = @json_decode(file_get_contents('data/' . $ip . '.txt'), true);
    	if (!$list) {
    	    echo 'Can\'t read this box\'s data.';
    	    exit();
    	}
    	return $list;
    }

    if (empty($ip)) {$ip = $_GET['ip'];}
    if (empty($ip)) {exit();}
    $tab = $_GET['tab'];
    
    echo '<script>
       $(document).ready(function(){
        $("#overview").click(function(){
         $("#detaltab").load("api.php?ip=' . $ip . '&tab=overview");
        });
        $("#space").click(function(){
         $("#detaltab").load("api.php?ip=' . $ip . '&tab=space");
        });
        $("#manage").click(function(){
         $("#detaltab").load("api.php?ip=' . $ip . '&tab=manage");
        });
       });
      </script>';
    
    if (empty($tab) || $tab == 'overview') {
        //定义变量
    	$list = getdata($ip);
    	$name = $list['name'];
    	$first_report_time = $list['first'];
    	$latest_report_time = $list['latest'];
    	$free_space = $list['free'];
    
    	//改变头
    	echo '<div class="panel-heading">
            <center>
            <div class="btn-group">
            <button class="btn btn-default active" type="button" id="overview">概览</button>
            <button class="btn btn-default" type="button" id="space">储存</button>
            <button class="btn btn-default" type="button" id="manage">管理</button>
            </div>
            </center>
            </div>
            <div class="panel-body">';
    
    	//显示内容
    	echo '<div class="section">
           <div class="container">
            <div class="row">
             <div class="col-md-5">';
    	echo
    '<img src="https://ss0.baidu.com/73x1bjeh1BF3odCf/it/u=4218638281,4102587816&amp;fm=85&amp;s=32D3887E4E141ED44F9A37990200F09B" class="center-block img-responsive img-rounded">'
    									       ;
    	echo '</div>
             <div class="col-md-7">';
    	echo '<h2>' . $name . '</h2></br>
             <p>盒子IP：' . $ip . '</p>
             <p>更新时间：' . $latest_report_time . '</p>
             <p>创建时间：' . $first_report_time . '</p>
             <p>剩余空间：' . $free_space . 'GB</p>
             </div></div></div></div></div>';
    } elseif ($tab == 'space') {
        //定义变量
    	$list = getdata($ip);
    	$name = $list['name'];
    	$free_space = $list['free'];
    
    	//改变头
    	echo '<div class="panel-heading">
            <center>
            <div class="btn-group">
            <button class="btn btn-default" type="button" id="overview">概览</button>
            <button class="btn btn-default active" type="button" id="space">储存</button>
            <button class="btn btn-default" type="button" id="manage">管理</button>
            </div>
            </center>
            </div>
            <div class="panel-body">';
    
    	//显示内容
    	echo '<div class="col-md-3">';
    	echo
    '<img src="http://detect-10000037.image.myqcloud.com/86b6c4c9-f556-45c2-8a25-0051b27dd56d" height="150" width="150" class="center-block img-responsive img-rounded">'
    									       ;
    	echo '</div>
    	<div class="col-md-9">';
    
    	if ($free_space == 'unknown' || empty($free_space)) {
    		echo '<h2>' . $name .
    	    '<small class="navbar-right">剩余空间未知</small></h2><br />';
    		echo '<div class="progress">';
    		echo
    	     '<div class="progress-bar" role="progressbar" style="width: 0%;">';
    		echo '</div></div></div>';
    	} else {
    		echo '<h2>' . $name . '<small class="navbar-right">' .
    number_format($free_space, 2, '.', '') . 'G可用 （共119.41G）</small></h2><br />'
    									       ;
    		echo '<div class="progress">';
    		$width = (1 - ($free_space / 119.41)) * 100;
    		echo
    '<div class="progress-bar" role="progressbar" style="width: ' . $width . '%;">';
    		echo round(119.41 - $free_space, 2) . 'G';
    		echo '</div></div></div></div>';
    	}
    } elseif ($tab == 'manage') {
    	//定义变量
    	$list = getdata($ip);
    	$name = $list['name'];
    	$passwd = $list['passwd'];
    
    	//改变头
    	echo '<div class="panel-heading">
            <center>
            <div class="btn-group">
            <button class="btn btn-default" type="button" id="overview">概览</button>
            <button class="btn btn-default" type="button" id="space">储存</button>
            <button class="btn btn-default active" type="button" id="manage">管理</button>
            </div>
            </center>
            </div>
            <div class="panel-body">';
    
    	//判断是否已经输入密码
    	if (empty($passwd)) {
    		echo
    '<div class="alert alert-danger">您还未设置盒子密码，不能自动登陆。</div>'
    									       ;
    	}
    
    	//主要内容
    	echo '<h2>' . $name . '
    
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">设置</button></h2>
        
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        	<div class="modal-dialog">
        		<div class="modal-content">
        			<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        				<h4 class="modal-title" id="myModalLabel">
        					设置盒子 - ' . $ip . '
        				</h4>
        			</div>
        			
        			<form method="post" class="cmxform" id="form" action="note.php">
            			<div class="modal-body">
            			
                            <script>
                            $.validator.setDefaults({
                                submitHandler: function() {
                                  alert("设置成功!");
                                }
                            });
                            $().ready(function() {
                                $("#form").validate();
                            });
                            </script>
                            
                            <fieldset>
                                <input type="hidden"  name="ip" value="' . $ip . '" >
                                <p>
                                  <label for="note">备注</label>
                                  <input id="note" name="note" value="' . $note . '" required>
                                </p>
                                <p>
                                  <label for="password">密码</label>
                                  <input id="password" type="password" name="password">
                                </p>
                            </fieldset>
            			</div>
            			
            			<div class="modal-footer">
            				<button type="button" class="btn btn-default" data-dismiss="modal">关闭
            				</button>
            				<button type="submit" class="btn btn-primary">
            					提交
            				</button>
            			</div>
            	    </form>
        		</div><!-- /.modal-content -->
        	</div><!-- /.modal -->
        </div>';
    
    	echo '<p>创建时间：' . $list['first'] . '</p>';
    
    	if (empty($passwd)) {
    		echo '<p><a href="http://' . $ip .
    		       '/">芒果云文件管理：http://' . $ip . '/</a></p>';
    		echo '<p><a href="http://' . $ip .
           '/flood/">rTorrent管理面板flood：http://' . $ip . '/flood/</a></p>';
    		echo '<p><a href="http://' . $ip .
           '/ruT/">rTorrent管理面板ruTorrent：http://' . $ip . '/ruT/</a></p>';
    		echo '<p><a href="http://' . $ip .
    	    ':443/">Transmission管理面板：http://' . $ip . ':443/</a></p>';
    		echo '<p><a href="http://' . $ip .
    		  ':444/">Cloud9管理面板：http://' . $ip . ':444/</a></p>';
    	} else {
    		echo '<p><a href="http://' . $ip .
    		       '/">芒果云文件管理：http://' . $ip . '/</a></p>';
    		echo '<p><a href="http://' . $ip .
           '/flood/">rTorrent管理面板flood：http://' . $ip . '/flood/</a></p>';
    		echo '<p><a href="http://admin:' . $passwd . '@' . $ip .
           '/ruT/">rTorrent管理面板ruTorrent：http://' . $ip . '/ruT/</a></p>';
    		echo '<p><a href="http://admin:' . $passwd . '@' . $ip .
    	    ':443/">Transmission管理面板：http://' . $ip . ':443/</a></p>';
    		echo '<p><a href="http://admin:' . $passwd . '@' . $ip .
    		  ':444/">Cloud9管理面板：http://' . $ip . ':444/</a></p>';
    	}
    	echo '</div>';
    }

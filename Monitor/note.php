<!doctype html>
<html><head>
<?php
        $ip = $_POST['ip'];
        $note = $_POST['note'];
        $passwd = $_POST['password'];
        
        $new_name_tab = array(
            $ip => $note
            );
        $name_tab =  @json_decode(@file_get_contents('data/name.txt'), true);
        if (!$name_tab) {$name_tab = array();}
        $name_tab = array_replace($name_tab,$new_name_tab);
        file_put_contents('data/name.txt', json_encode($name_tab));
        
        $ip_name_tab = array('name' => $note);
        $ip_tab = json_decode(file_get_contents('data/'.$ip.'.txt'), true);
        $ip_tab = array_replace($ip_tab,$ip_name_tab);
        if(!empty($passwd)){
            $new_passwd_tab = array('passwd' => $passwd);
            $ip_tab = array_replace($ip_tab,$new_passwd_tab);
        }
        file_put_contents('data/'.$ip.'.txt', json_encode($ip_tab));
        
        echo '<meta http-equiv="refresh" content="0; url=detal.php?ip=' . $ip . '">';
?>
</head></html>
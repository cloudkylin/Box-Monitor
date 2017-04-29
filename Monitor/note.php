<!doctype html>
<html><head>
<?php
        $ip = $_GET['ip'];
        $note = $_GET['note'];
        
        $new_name_tab = array(
            $IP => $note
            );
        $name_tab =  @json_decode(@file_get_contents('data/name.txt'), true);
        if (!$name_tab) {$name_tab = array();}
        $name_tab = array_replace($name_tab,$new_name_tab);
        file_put_contents('data/name.txt', json_encode($name_tab));
        
        echo '<meta http-equiv="refresh" content="0; url=detal.php?ip=' . $ip . '">';
?>
</head></html>
<?php    
session_save_path("/home/users/web/b970/ipg.dpooran/cgi-bin/tmp");
session_start(); 
session_destroy();
if(isset($_SERVER['HTTP_REFERER'])) {
 header('Location: '.$_SERVER['HTTP_REFERER']);  
} else {
 header('Location:../../index.php');  
}
exit;  
?>
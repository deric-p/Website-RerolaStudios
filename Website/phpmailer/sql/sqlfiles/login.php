<?php
session_save_path("/home/users/web/b970/ipg.dpooran/cgi-bin/tmp");
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['userid'])){
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
}
?>
<html>
    <head>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../stylesheet/normal.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../../stylesheet/login.css"/>
	</head>
    <body>
           <script src="../../js/jquery-1.7.2.min.js"></script>
        
        <script src="../../js/framewarp.js"></script>
        <script src="../../js/script.js"></script>  
<?php

require'connect/credentials.php';

	if(isset($_SESSION['userid']) && isset($_SESSION['username']))
	{
		echo "You are already logged in as: ".$username;
	}
	else{
	
		try {
		$usernamedb = new PDO($userdb,$user,$password);
		$usernamedb->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$usernamedb->exec("SET NAMES 'utf8'");
		
		}
		catch (Exception $e)
		{
			echo "Could not connect to the database";
			exit;	
		}
		
		try{
			
			$results = $usernamedb->query("SELECT UserName,Password  FROM users");
			
			
			}
		catch(Exception $e){
			echo "data could not be retrieved from the database". $e;
			exit;
			
			}
			
			$logindetails = $results->fetchAll(PDO::FETCH_ASSOC);
			
	?>
	<?php	
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				
				$userentered = trim($_POST['user']);
				$passwordz = trim($_POST['password']);
			
				
				
			
				if($userentered) {
					if ($passwordz) {
						
						
						
							
							
							$usernam = $usernamedb->query("SELECT * FROM users WHERE UserName = '$userentered'");
							$rownum = $usernam->rowCount();
							if($rownum == 1)
							{
								
								$row = $usernam->fetchAll(PDO::FETCH_ASSOC);
								
								$dbid = $row[0]['UserId'];
								$dbuser = $row[0]['UserName'];
								$dbpass = $row[0]['Password'];
								
								$dbrlname = $row[0]['Name'];
								$dbemail = $row[0]['Email'];
								
								if($passwordz == $dbpass){
										
										
												
												//set session info
												$_SESSION['userid'] = $dbid;
												$_SESSION['username'] = $dbuser;
												$_SESSION['name'] = $dbrlname;
												$_SESSION['email'] = $dbemail;
												
												
                                                ?>
                                                <script>
												window.onload=function(){
                                                $('.popupBG',parent.document).trigger('click');
												};

                                                </script>
                                                <?php
                                               
                                               
												exit;
												
												
												
												
												
												
										
									
									}
								else{
										$errormessage =  "You did not enter in the correct password  <a class='forgot_password' href='recovery.php'>Forgot password?</a>"; 
										
									
									}
								
								
							
							}
							
							else 
							
							{
									$errormessage =   "user not found : " . $userentered ."<a class='forgot_password' href='recovery.php'>Forgot username?</a>";	
									
							}
							
							
						
						
						
					}
					
					else
					{
						
						$errormessage =   "You must enter in your password,  <a class='forgot_password' href='recovery.php'>Forgot password?</a>" ;
						
					}
					
				}
				else {
					$errormessage =   "You must enter in your username <a class='forgot_password' href='recovery.php'>Forgot username?</a>";	
					
					
				}
		
			}
			
			$usernamedb=null;
		?>
	
    <div id="content_login">
    			<div class="login_bar">
                	<h1>Login</h1>
                    <a href="" id="close" onclick="$('.popupBG',parent.document).trigger('click');">X</a>
                    <br> <br>
                    <hr>
                  
                </div>
                
    				<?php if(isset($errormessage)){
    				echo '<p class="messagelogin">'.$errormessage.'</p>';	
							}
					else{
					
					echo'<br><p>Welcome Back To Rerolz Gaming, Fill out the form below to access your account or if you dont have one, you can create a free account by clicking on register </p><br>';	
								
					}?>
	
					<form method="post" action="login.php">
					
						<table>
							<tr>
								<th>
									<label for="user">Username: </label>
								 </th>
								 <td>
									<input type="text" name="user" id="user" value="<?php if (isset($userentered)){ echo htmlspecialchars($userentered);} ?>">
								 </td>
							 </tr>
							 <tr>
								<th>
									<label for="password">Password: </label>
								 </th>
								 <td>
									<input type="password" name="password" id="password" value="" >
								 </td>
                                 
							 </tr>
							
						  </table>
                          
						  <div class="action_btns">
                          <div class="one_half">
						  <input type="submit"  value="Login">
                         </div>
 						 <div class="one_half last">
                		<a class="register" href="register.php" >Register</a>
            </div>
        </div>
    </form>
    
    
    </div>

            
			
	<?php } ?>

</body>
</html>

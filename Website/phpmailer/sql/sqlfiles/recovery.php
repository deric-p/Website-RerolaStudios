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
	<link rel="stylesheet" type="text/css" href="../../stylesheet/recovery.css"/>
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
		$recoverydb = new PDO($userdb,$user,$password);
		$recoverydb->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$recoverydb->exec("SET NAMES 'utf8'");
		
		}
		catch (Exception $e)
		{
			echo "Could not connect to the database";
			exit;	
		}
		
		try{
			
			$results = $recoverydb->query("SELECT *  FROM users");
			
			
			}
		catch(Exception $e){
			echo "data could not be retrieved from the database". $e;
			exit;
			
			}
			
			
			
	?>
	<?php	
			
			$email_body="";
		foreach( $_POST as $value ){
			if (stripos($value,'Content-Type:') != FALSE){
				echo "There was a problem with the information you entered. Please Close Window or Click the Background";
				exit;
					
			}
			
		}
	
	
			require_once("../../phpmailer/class.phpmailer.php");
			$mail = new PHPMailer();
			
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$email = trim($_POST["email"]);
				if($_POST["address"] == "") {
					if($email){
						if($mail->ValidateAddress($email)){
							$check = $recoverydb->query("SELECT * FROM users WHERE Email = '$email'");
							$rownum = $check->rowCount();
							
							if($rownum == 1)
							{	
								
								$row = $check->fetchAll(PDO::FETCH_ASSOC);
								
								
								$usernamez = $row[0]['UserName'];
								$passwordz = $row[0]['Password'];
								
								
								
								
								//Email Body
								$email_body=$email_body. "Username: ".$usernamez. "<br>";
								$email_body=$email_body. "Password: ".$passwordz. "<br>";
								$email_body=$email_body."Thank you for using our Account Recovery System, please contact us if you have any questions or concerns";
								//Send Email
								$from = "development@rerolzgaming.com";
								$from_name = "Rerolz Development Team";
								$mail->SetFrom($from,$from_name);
								
								
								$mail->AddAddress($email, $name);
								$mail->Subject = "Rerolz Gaming Account Recovery System";
								$mail->MsgHTML($email_body);
								
											if($mail->Send()){
												?>
												<script>
												window.location.replace("recovery.php?status=thanks");
												</script>
												<?php
												
												exit;
											} else {
												$error_message ="There was a problem sending the email: ".$mail->ErrorInfo;
												
											}
							}
							else
							{
								$errormessage = $email." does not corresponde to any account in our database, please check your spelling.";
							}
						}
						else
						{
							$errormessage = "You must specify a valid email";
						}
					}
					else
					{
						$errormessage = "Please enter in an email";
					}
					
				}
				else
				{
				$errormessage = "Your form submission has an error, leave address blank";
				}
			
			}
			
			
			$recoveryb=null;
		?>
	
    <div id="content_recovery">
    			<div class="recovery_bar">
                	<h1>Account Recovery</h1>
                    <a href="" id="close" onclick="$('.popupBG',parent.document).trigger('click');">X</a>
                    <br> <br>
                    <hr>
                  
                </div>
                	<?php if(isset($_GET["status"]) AND $_GET["status"] == "thanks") { ?>
                    
                    <p>An email with your username and password will arrive in your inbox shortly. Thank you for using our Account Recovery System.</p>
                    <?php } else { ?>
                    
    				<?php if(isset($errormessage)){
    				echo '<p class="messagerecovery">'.$errormessage.'</p>';	
							}
					else{
					
					echo'<br><p>Welcome to Rerolz Gaming&#39s Account Recovery, input the email registered to your account and an email will be sent to you with your account information</p><br>';	
								
					}?>
	
					<form method="post" action="recovery.php">
					
						<table>
							<tr>
								<th>
									<label for="user">Email: </label>
								 </th>
								 <td>
									<input type="text" name="email" id="email" value="<?php if (isset($email)){ echo htmlspecialchars($email);} ?>">
								 </td>
							 </tr>
							 <tr style ="display: none;">
                            <th>
                                <label for="address">Address: </label>
                             </th>
                             <td>
                                <input type="text" name="address" id="address">
                                <p>please leave this field blank</p>
                             </td>
                         </tr>
							
						  </table>
                          
						  <div class="action_btns">
                          
 						 <div class="one_half">
                         <input type="submit"  value="Recover">
                		
            			</div>
            <div class="one_half last">
						  <a class="back" href="login.php" >Back</a>
                         </div>
        </div>
    </form>
    
    
    </div>

        	<?php } ?>    
			
	<?php } ?>

</body>
</html>

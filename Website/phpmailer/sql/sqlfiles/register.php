<?php
session_save_path("/home/users/web/b970/ipg.dpooran/cgi-bin/tmp");
session_start();


?>
<html>
    <head>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../stylesheet/normal.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../../stylesheet/register.css"/>
	</head>
 <body>
 	<script src="../../js/jquery-1.7.2.min.js"></script>
      <script src="../../js/framewarp.js"></script>
        <script src="../../js/script.js"></script>  
 <?php
 
 
 		require'../../extras/filter.php';
	  require'connect/credentials.php';

		
		if(isset($_SESSION['userid']) && isset($_SESSION['username']))
		{
			echo "You are already logged in as: ".$_SESSION['username'];
		}
		else{
		
			try {
			$userregisterdb = new PDO($userdb,$user,$password);
			$userregisterdb->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$userregisterdb->exec("SET NAMES 'utf8'");
			
			}
			catch (Exception $e)
			{
				echo "Could not connect to the database";
				exit;	
			}
			
			try{
				
				$results = $userregisterdb->query("SELECT UserName,Email  FROM users");
				
				
				}
			catch(Exception $e){
				echo "data could not be retrieved from the database". $e;
				exit;
				
				}
				
				$checkregister = $results->fetchAll(PDO::FETCH_ASSOC);
				
				
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					
					$day = $_POST['day'];
					$year = $_POST['year'];
					$month = $_POST['month'];
					$dateofbirth = $year.'-'.$month.'-'.$day;
					$username = $_POST['user'];
					$passwordz =$_POST['password'];
					$email =trim($_POST['email']);
					$name =$_POST['name'];
					if($_POST["address"] == "") {
					
				foreach( $_POST as $value ){
					if (stripos($value,'Content-Type:') != FALSE){
					echo "There was a problem with the information you entered. Please Reload The Page";
					exit;
					}
			
					}
					//make sure username isnt stupidly long
					if((strlen($username) < 21)){
					//name blank
					If(trim($name)){
						//username blank
						if(trim($username)){
							//email blank
							if($email){
								//password blank
								if(trim($passwordz)){
									$check = true;
									//for loop to check if the user enter a in appriorate name
												$filler = $filter;
												$matches = array();
												$testuser = $username;
												$matchFound = preg_match_all(
													"/\b(" . implode($filler,"|") . ")\b/i", 
														$testuser, 
														$matches
										  );
										  if($matchFound)
										  {
											 $check = false;
										  }
									
									
										
										foreach($filter as $badwords)
											{
											if(stristr($username,$badwords))
											{
											$check = false;
											}
											}
									
									
									
									//username doesnt have any white spaces or inappriorate names
									if($check){
										//white space check for password and username
										if(preg_match('/\s/',$username) == 0)
										{
											$username=trim($username);
											if(preg_match('/\s/',$passwordz) == 0){
												$passwordz = trim($passwordz);
												//check email is valid
										    	require_once("../../phpmailer/class.phpmailer.php");
												$mail = new PHPMailer();
												
												if ($mail->ValidateAddress($email)){
													//check if user exisits
													$userexist = false;
													$useremail = false;
														foreach($checkregister as $exists){
														
															if($exists['UserName'] == $username) {
																
																$userexist = true;
															
															}
															if($exists['Email']==$email) {
															
																$useremail = true;
															}
															
														}
																		if(!$userexist)
																		{
																			if(!$useremail){
																				$insert = $userregisterdb->query("INSERT INTO users
																				 (Name, Email,UserName,Password,DateofBirth,Admin)
																				VALUES ('$name', '$email','$username','$passwordz', '$dateofbirth','0')"); 
																				$usernam = $userregisterdb->query("SELECT * FROM users WHERE UserName = '$username'");
																				$rownum = $usernam->rowCount();
																				if($rownum == 1)
																				{
																					
																					$row = $usernam->fetchAll(PDO::FETCH_ASSOC);
																					
																					$dbid = $row[0]['UserId'];
																					$dbuser = $row[0]['UserName'];
																					$dbpass = $row[0]['Password'];
																					
																					$dbrlname = $row[0]['Name'];
																					$dbemail = $row[0]['Email'];
																					$dbemail = $row[0]['Admin'];
																					
																							
																							
																									
																									//set session info
																									$_SESSION['userid'] = $dbid;
																									$_SESSION['username'] = $dbuser;
																									$_SESSION['name'] = $dbrlname;
																									$_SESSION['email'] = $dbemail;
																									$_SESSION['admin'] = $dbadmin;
																									
																									?>
																									<script>
																									window.onload=function(){
																									$('.popupBG',parent.document).trigger('click');
																									};
													
																									</script>
																									<?php
																								   
																								   
																									exit;
																									}
																				
																			}
																			else
																			{
																				$errormessage = "The email: ".$email." is already in use";
																			}
																			
																		}
																		else
																		{
																			$errormessage = "The username: ".$username." already exists";
																		}
																													
												}
												else
												{
													$errormessage = "You must specify a valid email.";
													
												}
											
											}
											else
											{
												$errormessage = "Password cannot contain spaces";
											}
										}
										else
										{
											$errormessage = "Username cannot contain spaces";
										}
									}
									
									else
									{
										$errormessage = "Your username is inappriorate";
									}
								}
								else
								{
									$errormessage="You must enter in a password";
								
								}
							
							}
							else
							{
								$errormessage = "You must enter in an email";
							
							}
							
							
						}
						else
						{
							$errormessage = "You must enter in a username";	
							
						}
						
					}
					else
					{
						
						$errormessage = "You must enter in your name";
					
					}
					}
					else
					{
						$errormessage = "Your username is too long";
					}
					}
					else
					{
					$errormessage = "Your form submission has an error.";
					}
					
					
				}
				//close connection
				$userregisterdb=null;
				
				
				
	?>
        <div id="content_register">
    			<div class="register_bar">
                	<h1>Register</h1>
                    <a href="" id="close" onclick="$('.popupBG',parent.document).trigger('click');">X</a>
                    <br> <br>
                    <hr>
                  
                </div>
                
    				<?php if(isset($errormessage)){
    				echo '<p class="messagelogin">'.$errormessage.'</p>';	
							}
					else{
					
					echo'<p>Welcome To Rerolz Gaming, Fill out the form below to access your free account </p>';	
								
					}?>
	
					<form method="post" action="register.php">
					
						<table>
                        <tr>
								<th>
									<label for="name">Name: </label>
								 </th>
								 <td>
									<input type="text" name="name" id="name" value="<?php if (isset($name)){ echo htmlspecialchars($name);} ?>">
								 </td>
							 </tr>
                              <tr>
								<th>
									<label for="Dob">Date of Birth: </label>
								 </th>
								 <td>
											<?php
											for ($i = 1; $i <= 31; $i++)
											{
											$arDays[] = $i;
											}
											echo '<select name="day">';
											foreach ($arDays as $option) {
												if(isset($day) && $day == $option){
													
													echo '<option value="'.$option.'" selected="selected">'.$option.'</option>';
												}
												else{
													
												echo '<option value="'.$option.'">'.$option.'</option>';
												}
											}
											echo '</select>';
											?>
											<select name="month">
											<option value="01" <?php if (isset($month) && $month == 01){ ?>selected="selected"<?php } ?>>Jan</option>
											<option value="02"<?php if (isset($month) && $month == 02){ ?>selected="selected"<?php } ?>>Feb</option>
											<option value="03"<?php if (isset($month) && $month == 03){ ?>selected="selected"<?php } ?>>March</option>
											<option value="04"<?php if (isset($month) && $month == 04){ ?>selected="selected"<?php } ?>>April</option>
											<option value="05"<?php if (isset($month) && $month == 05){ ?>selected="selected"<?php } ?>>May</option>
											<option value="06"<?php if (isset($month) && $month == 06){ ?>selected="selected"<?php } ?>>June</option>
											<option value="07"<?php if (isset($month) && $month == 07){ ?>selected="selected"<?php } ?>>July</option>
											<option value="08"<?php if (isset($month) && $month == 08){ ?>selected="selected"<?php } ?>>August</option>
											<option value="09"<?php if (isset($month) && $month == 09){ ?>selected="selected"<?php } ?>>Sept</option>
											<option value="10"<?php if (isset($month) && $month == 10){ ?>selected="selected"<?php } ?>>Oct</option>
											<option value="11"<?php if (isset($month) && $month == 11){ ?>selected="selected"<?php } ?>>Nov</option>
											<option value="12"<?php if (isset($month) && $month == 12){ ?>selected="selected"<?php } ?>>Dec</option>
											</select>
											<?php
											$currentYear = date("Y");
											for ($i = $currentYear; $i >= 1920; $i--)
											{
											$arYears[] = $i;
											}
											echo '<select name="year">';
											foreach ($arYears as $option) {
												if(isset($year) && $year == $option){
													echo '<option value="'.$option.'" selected="selected">'.$option.'</option>';
												}
												else
												{
												echo '<option value="'.$option.'">'.$option.'</option>';
												}
											}
											echo '</select>';
											?>
								</td>
							 </tr>
							<tr>
								<th>
									<label for="user">Username: </label>
								 </th>
								 <td>
									<input type="text" name="user" id="user" value="<?php if (isset($username)){ echo htmlspecialchars($username);} ?>">
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
							 <tr>
								<th>
									<label for="email">Email: </label>
								 </th>
								 <td>
									<input type="text" name="email" id="email" value="<?php if (isset($email)){ echo htmlspecialchars($email);} ?>" >
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
                          
						  
                          
						  <input type="submit"  value="Register">
                         
           
    </form>
    
    </div>
    
    <?php } ?>
</body>
</html>

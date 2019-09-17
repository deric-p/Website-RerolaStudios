<?php

                                    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $message = trim($_POST["message"]);
        $email_body = "";
    
    if($name == "" OR $email == "" OR $message == ""){
        $error_message = "You must specify a value for name, email and message.";
        
    }
    if(!isset($error_message)){
        foreach( $_POST as $value ){
            if (stripos($value,'Content-Type:') != FALSE){
                $error_message = "There was a problem with the information you entered.";
                    
            }
            
        }
    }
    if(!isset($error_message) AND $_POST["address"] !== "") {
        $error_message = "Your form submission has an error.";
            
    }
    
    require_once("phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    
    if (!isset($error_message) AND !$mail->ValidateAddress($email))
    {
        $error_message = "You must specify a valid email.";
        
    }
    if(!isset($error_message)){
        $email_body=$email_body. "Name: ".$name. "<br>";
        $email_body=$email_body. "Email: ".$email. "<br>";
        $email_body=$email_body."Message: ".$message;
        
        // TODO: SEND EMAIL
        
        $mail->SetFrom($email,$name);
        
        $address = 'development@rerola.com';
        $mail->AddAddress($address, "Rerola");
        $mail->Subject = "Rerola Contact Form Submission | ".$name;
        $mail->MsgHTML($email_body);
        
        if($mail->Send()){
            ?>
            <script>
            window.location.replace("?status=thanks");
            </script>
            <?php
            header("Location: " . BASE_URL . "?status=thanks");
            exit;
        } else {
            $error_message ="There was a problem sending the email: ".$mail->ErrorInfo;
            
        }
        
        
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="At Rerola, we are focused on making creative and fun products for entertainment.">
    <meta name="robots" content="index,follow,noarchive">
    <meta property=”og:title” content=”Rerola Studios”/>
    <meta property=”og:type” content=”website”/>
    <meta property=”og:image” content=”/img/icons/favicon-01.png”/>
    <meta property=”og:url” content=”http://www.rerola.com”/>
    <meta property=”og:description” content=”At Rerola, we are focused on making creative and fun products for entertainment.”/>
    <meta property=”fb:admins” content=”USER_ID”/>
    <link rel="apple-touch-icon" sizes="57x57" href="img/icons/favicon.svg">
    <link rel="apple-touch-icon" sizes="60x60" href="img/icons/favicon.svg">
    <link rel="apple-touch-icon" sizes="72x72" href="img/icons/favicon.svg">
    <link rel="apple-touch-icon" sizes="76x76" href="img/icons/favicon.svg">
    <link rel="apple-touch-icon" sizes="114x114" href="img/icons/favicon.svg">
    <link rel="apple-touch-icon" sizes="120x120" href="img/icons/favicon.svg">
    <link rel="apple-touch-icon" sizes="144x144" href="img/icons/favicon.svg">
    <link rel="apple-touch-icon" sizes="152x152" href="img/icons/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="img/icons/favicon.svg">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/icons/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icons/favicon.svg">
    <link rel="icon" type="image/png" sizes="96x96" href="img/icons/favicon.svg">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icons/favicon.svg">
    <link rel="manifest" href="img/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="img/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="Transparent">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rerola Studios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
    <!--load font awesome-->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    <!-- This following line is optional. Only necessary if you use the option css3:false and you want to use other easing effects rather than
    "linear", "swing" or "easeInOutCubic". -->
    <script src="js/vendors/jquery.easings.min.js"></script>
    <!-- This following line is only necessary in the case of using the plugin option `scrollOverflow:true` -->
    <script type="text/javascript" src="js/vendors/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="js/jquery.fullPage.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    $('#fullpage').fullpage({
    anchors: ['home', 'story', 'contact','thankyou','email'],
    menu: '#RerolzNav',
    scrollBar: true
    });
    });
    </script>
    <script type="text/javascript">
    // Copyright 2014-2015 Twitter, Inc.
    // Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
    if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
      var msViewportStyle = document.createElement('style')
      msViewportStyle.appendChild(
        document.createTextNode(
      '@-ms-viewport{width:auto!important}'
    )
  )
  document.querySelector('head').appendChild(msViewportStyle)
}
    </script>
  
</head>

<body>
        <?php 
            if(isset($_GET["status"]) AND $_GET["status"] == "thanks") { 
        ?>
                <!---Nav Bar After -->
                <nav class = "navbar navbar-default navbar-fixed-top" id="rerolznavbar">
                    <div class = "container-fluid">
                        <div class="navbar-header">
                            <!---Button for Mobile -->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                           
                            </button>
                            <!---Rerolz logo -->
                            <a class="navbar-brand brand" rel="home" href="#" title="Rerola Studios">
                          <img id="brand-image" src="img/brand/new_logo.png"  alt="Rerola Studios"></a>
                        </div>
                        <!---Menu Bar -->
                        <div class="collapse navbar-collapse navbar-right" id="navbar-collapse">
                            <ul class ="nav navbar-nav" id="RerolzNav">
                                <li><a href="http://www.rerola.com/#home">Home</a></li>
                                <li><a href="http://www.rerola.com/#story">Story</a></li>
                                <li><a href="#games" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">Games 
                                    <span class="caret"></span></a>
                                    <!---Drop Down Menu -->
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                             href="http://www.rerola.com/shapevale">Shape Vale</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-"
                                             href="http://www.rerola.com/shadesofthelamp">Shades of the Lamp</a></li>
                                        </ul></li>
                                <li><a href="http://www.rerola.com/#contact">Contact</a></li>
                            </ul>
                       </div>
                    </div>
                </nav>
                <div id="fullpage">
                    <div class="section text-center contact" id="section4">
                    <h2>Thanks for the email</h2>
                    <p class="lead">We&rsquo;ll be in touch shortly.</p>
                    </div>
                </div>
        <?php 
            } 
            else
            { 
        ?>
    
        <!---Nav Bar Before -->
        <nav class = "navbar navbar-default navbar-fixed-top" id="rerolznavbar">
            <div class = "container-fluid">
                <div class="navbar-header">
                    <!---Button for Mobile -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    
                    </button>
                    <!---Rerolz logo -->
                    <a class="navbar-brand brand" rel="home" href="#" title="Rerola Studios">
                    <img id="brand-image"src="img/brand/new_logo.png"  alt="Rerola Studios"></a>
                </div>
                <!---Menu Bar -->
                <div class="collapse navbar-collapse navbar-right" id="navbar-collapse">
                    <ul class ="nav navbar-nav" id="RerolzNav">
                        <li data-menuanchor="home" class="active"><a href="#home">Home</a></li>
                        <li data-menuanchor="story"><a href="#story">Story</a></li>
                        <li ><a href="#games" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">Games 
                        <span class="caret"></span></a>
                        <!---Drop Down Menu -->
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                               <li role="presentation"><a role="menuitem" tabindex="-1"
                                             href="http://www.rerola.com/shapevale">Shape Vale</a></li>
                             <li role="presentation"><a role="menuitem" tabindex="-1"
                                             href="http://www.rerola.com/shadesofthelamp">Shades of the Lamp</a></li>
                            </ul></li>
                        <li data-menuanchor="contact"><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="fullpage">
            <!-- Home Page --> 
            <div class="section" id="section0">
               <div id="bg-fade-carousel" class="carousel slide carousel-fade" data-ride="carousel">
                <!-- Wrapper for backgrounds -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="bg1"></div>
                        </div>
                        <div class="item">
                            <div class="bg2"></div>
                        </div>
                        <div class="item">
                            <div class="bg3"></div>
                        </div>
                    </div><!-- Jumbotron Text --> 
                    <div class="container carousel-overlay text-center">
                        <h1>CREATIVITY</h1>
                        <p class="lead">We Are Passonate About Creating Beautiful and Creative Games</p>
                     
                    </div>
                </div>
             </div>
                <!--Story-->
            <div class ="section well text-center" id="section1">
                 <h2>Our Story</h2>
                 <p class="lead">Rerola is a indie studio, that is passionate about creating
                 beautiful and creative games. We believe that our games aren&rsquo;t just games 
                 they&rsquo;re true works of art that will provide 
                 entertainment and admiration. </p>        
            </div>
            <!-- Contact -->
            <div class="section contact" id="section2">
                <h2 class="center">Contact Us</h2>
                <div class="row">
                <div class="col-md-4"></div>
              
                <div class="col-md-4 panel panel-default center">
                    <div class="panel-body">
                    <?php
                    if(isset($error_message))
                      {
                        echo '<p class="message">'.$error_message.'</p>';
                            
                      } 
                    ?>
                         <form method="post" role="form">
                            <div class="form-group">
                                    <label for="name">Name</label>
                                <div class="input-group center">
                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="name" name="name" class="form-control" placeholder="Enter your Name" value="<?php if ($name!=null
                                    ){ echo htmlspecialchars($name);} ?>" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-group center">
                                    <span class="input-group-addon" id="email"><span class="glyphicon glyphicon-leaf"></span></span>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Your Email" value="<?php if ($email!=
                                    null){ echo htmlspecialchars($email);} ?>" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="form-group" style="display:none;">
                                <label for="email">Address</label>
                                <div class="input-group center">
                                    <span class="input-group-addon" id="address"><span class="glyphicon glyphicon-remove"></span></span>
                                    <input type="address" class="form-control" name="address" placeholder="Leave Blank" 
                                    aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <div class="input-group center">
                                    <span class="input-group-addon" id="message"><span class="glyphicon glyphicon-pencil"></span></span>
                                    <textarea class="form-control" name="message" id="messsage" rows="3"><?php if (isset($message)){ echo 
                                    htmlspecialchars($message);} ?></textarea>
                                </div>
                            </div>
                            <div class="center" role="group" aria-label="...">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </form>
                    </div>
                
                </div>
                <div class="col-md-4"></div>    
                </div>
                <div class="social center">
                    <ul>
                        <li><a href="https://twitter.com/rerolastudios"><i class="fa fa-lg fa-twitter"></i></a></li>
                        <li><a href="https://plus.google.com/106684980583321639385/about"><i class="fa fa-lg fa-google-plus"></i></a></li>
                        <li><a href="https://plus.google.com/111224803461730432972"><i class="fa fa-lg fa-youtube">
                        </i></a></li>
                        <li><a href=""><i class="fa fa-lg fa-facebook"></i></a></li>
                    </ul>
                </div>
            </div> 
            <!--Thank You-->
            <div class="section jumbotron center" id="section3">
                <h1>THANK YOU!</h1>
                <h2>For Visiting!</h2>
                <footer ><small>&copy 2014 - <?php echo date('Y'); ?> Rerola | All rights reserved</small></footer>
            </div>
          </div>
          
        <?php
            }
        ?>
</body>
</html>

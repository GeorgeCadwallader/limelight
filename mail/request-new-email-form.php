<?php

/**
 *
 * @var yii\web\View $this
 * @var app\models\User $user
 */

$urlManager = Yii::$app->urlManager;
$resetLink = $urlManager->createAbsoluteUrl(['site/change-email', 'token' => $user->password_reset_token]);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- utf-8 works for most cases -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Forcing initial-scale shouldn't be necessary -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>Request New Email</title>

<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;900&display=swap" rel="stylesheet">
<style type="text/css">

	
html, body {
	margin: 0 !important;
	padding: 0 !important;
	height: 100% !important;
	width: 100% !important;
}

* {
	-ms-text-size-adjust: 100%;
	-webkit-text-size-adjust: 100%;
}

.ExternalClass {
	width: 100%;
}

div[style*="margin: 16px 0"] {
	margin: 0 !important;
}

table, td {
	mso-table-lspace: 0pt !important;
	mso-table-rspace: 0pt !important;
}

table {
	border-spacing: 0 !important;
	border-collapse: collapse !important;
	table-layout: fixed !important;
	margin: 0 auto !important;
}
table table table {
	table-layout: auto;
}

img { 
	-ms-interpolation-mode: bicubic;
}

.yshortcuts a {
	border-bottom: none !important;
}

a[x-apple-data-detectors] {
	color: inherit !important;
}

a{
    text-decoration: none !important;
}

</style>


<style type="text/css">

.button-td, .button-a {
	transition: all 100ms ease-in;
}
.button-td:hover, .button-a:hover {
	background: #0d8000 !important;
	border-color: #0d8000!important;
}
</style>
</head>
<body width="100%" height="100%" bgcolor="#e0e0e0" style="margin: 0;" yahoo="yahoo">
<table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" bgcolor="#f2f2f2" style="border-collapse:collapse;">
  <tr>
    <td><center style="width: 100%;">
        
        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: raleway;"> <?= Yii::$app->name; ?> | Request Email Change </div>
        <!-- Visually Hidden Preheader Text : END -->
        
        <div style="max-width: 600px;"> 
          <!--[if (gte mso 9)|(IE)]>
            <table cellspacing="0" cellpadding="0" border="0" width="600" align="center">
            <tr>
            <td>
            <![endif]--> 
          
          <!-- Email Header : BEGIN -->
          
          <!-- Email Header : END --> 
          
          <!-- Email Body : BEGIN -->
          <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#f6f6f6" width="100%" style="max-width: 600px; border: none; ">
            
            <!-- Hero Image, Flush : BEGIN -->
            <tr>
              <td class="full-width-image" align="center" ><img src="https://i.imgur.com/VnzhDUT.png" width="600" alt="alt_text" border="0" style="width: 100%; max-width: 600px; height: auto;"></td>
            </tr>
            <!-- Hero Image, Flush : END --> 
            
            <!-- 1 Column Text : BEGIN -->
            <tr>
              <td><table cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tr>
                    <td style="padding: 45px; font-family: 'Raleway', sans-serif; font-size: 30px; font-weight: 800; mso-height-rule: exactly; line-height: 28px; color: black; text-align: center"> You have requested to change your email on <?= Yii::$app->name; ?> <br>
                      <br>

						<span style="font-family: 'Raleway', sans-serif; font-size: 16px; font-weight: 400; line-height: 8px;">To change your email click on the button below. From here the email you are reading this from will become your new email to log into <?= Yii::$app->name; ?> with.</span>
						<br>


						
                      
                      <!-- Button : Begin -->
						
                      
                      <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto;">
                        <tr>
							
                          <td style="border-radius: 3px; background: #13bf00; text-align: center; text-decoration: none;" class="button-td">
							  
							  <a href="<?= $resetLink; ?>" style="background: #13bf00; border: 15px solid #13bf00; padding: 0 10px;color: #f2f2f2; font-family: 'Raleway', sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold; text-decoration: none;" class="button-a" > 
                            <!--[if mso]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]-->Change Email<!--[if mso]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]--> 
                            </a></td>
                        </tr>
                        
                      </table>
                      
                      <!-- Button : END --> 
   
					  </td>
					   <tr>
                                  <td style="padding: 20px; font-family: 'Raleway', sans-serif; font-size: 16px; font-weight: 100; mso-height-rule: exactly; line-height: 16px; color: black; text-align: center" class="stack-column-center">  If you have not requested an email change please contact an admin at <a href="mailto:<?= Yii::$app->params['senderEmail']; ?>">
        <?= Yii::$app->params['senderEmail']; ?>
    </a> </td>
                                </tr>
					 
                  </tr>
                </table></td>
            </tr>
            <!-- 1 Column Text : BEGIN --> 
            
            <!-- Two Even Columns : BEGIN -->
            <tr>
              <td bgcolor="#f2f2f2" align="center" height="100%" valign="top" width="100%"><!--[if mso]>
                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="560">
                        <tr>
                        <td align="center" valign="top" width="560">
                        <![endif]-->
                
                <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
                  <tr>
                    
                  </tr>
                </table>
                
                <!--[if mso]>
                        </td>
                        </tr>
                        </table>
                        <![endif]--></td>
            </tr>
            <!-- Two Even Columns : END -->
            
          </table>
          <!-- Email Body : END --> 
          
          <!-- Email Footer : BEGIN -->
          <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;">
            <tr>
              <td style="padding: 40px 10px;width: 100%; font-size: 16px; font-family: 'Raleway', sans-serif;  font-weight: 800; mso-height-rule: exactly; line-height:18px; text-align: center; color: #13bf00; text-align: center">
                <br>
                
                <?= Yii::$app->name; ?><br>
              
                <br>
                </td>
            </tr>
          </table>
          <!-- Email Footer : END --> 
          
          <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]--> 
        </div>
      </center></td>
  </tr>
</table>
</body>
</html>



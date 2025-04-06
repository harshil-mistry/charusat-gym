<?php
include('smtp/PHPMailerAutoload.php');
include('passkeys.php');

function send_mail($to,$subject, $msg){
    global $password;
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	//$mail->SMTPDebug = 2; 
	$mail->Username = "charusat.gym.portal@gmail.com";
	$mail->Password = $password;
	$mail->SetFrom("charusat.gym.portal@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
        echo "There was some error sending the email<br>";
		echo $mail->ErrorInfo;
	}
}
?>
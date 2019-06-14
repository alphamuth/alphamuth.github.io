<html>
<style type="text/css">
h2{

color:green;
}
</style>
</html>

<?php
$db = pg_connect("host=localhost port=5432 dbname=library user=postgres password=root");
if(!$db){
  echo pg_last_error($db);
}else {
  echo "";
}

$email=$_REQUEST["email"];

$query=pg_query("select * from addusers where email='$email'");
$row=pg_fetch_array($query);
/*print_r ($row);
echo $row["email"];
*/
echo $row["email"];
echo $row["name"];
echo $row["password"];
require 'PHPMailer-master/PHPMailerAutoload.php';

$mail = new PHPMailer();
  
  //Enable SMTP debugging.
  $mail->SMTPDebug = 2;
  //Set PHPMailer to use SMTP.
  $mail->isSMTP();
  //Set SMTP host name
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
  //Set this to true if SMTP host requires authentication to send email
  $mail->SMTPAuth = TRUE;
  //Provide username and password
  $mail->Username = "";
  $mail->Password = "";
  //If SMTP requires TLS encryption then set it
  $mail->SMTPSecure = "false";
  $mail->Port = 587;
  //Set TCP port to connect to
  
  $mail->From = "library.iiitm@gmail.com";
  $mail->FromName = "IIIT Manipur (Library)";
  
  
  $mail->addAddress($row["email"]);

  $mail->isHTML(true);
 
  $mail->Subject = "Registration (Only for Registered Users)";
 $mail->Body = "<i>This is your Name :</i>".$row["name"]."</br></br> & This is Your Password:".$row["password"]."</br></br> & This is Your E-mail :".$row["email"];

  $mail->AltBody = "This is the plain text version of the email content";
  if(!$mail->send())
  {
   echo "Mailer Error: " . $mail->ErrorInfo;
  }
  else
  {
echo "<center>";
echo "</br></br></br>";
   echo "<h2>Message has been sent successfully<h2>";
echo "</center>";
  }
?>

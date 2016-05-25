<?php
/**
 * Project Ripple
 * Boxcutter
 * Twilio gate entry
*/

session_start();
$session = $_SESSION['boxcutter'];
require_once ( "boxcutter_settings.php" );
require_once ( "twilio-php/Services/Twilio.php" );

$client = new Services_Twilio($sid, $token);

// Set our Twilio phone number here
$twilio_from = $twilio_phone_number;

$msg_customer['phone_number'] = $_REQUEST['From'];
$msg_in = $_REQUEST['Body'];

require ( 'boxcutting.php' );

$boxcutting = new Boxcutting( $msg_customer, $msg_in, $session );
$msg_out = $boxcutting->respond_process();
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

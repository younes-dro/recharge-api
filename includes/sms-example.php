<?php

/*****************************************************************************************
 *
 *  How to Send Single Message
 */

try {
	// Send a message using the primary device.
	$msg = sendSingleMessage( '+11234567890', 'This is a test of single message.' );

	// Send a message using the Device ID 1.
	$msg = sendSingleMessage( '+11234567890', 'This is a test of single message.', 1 );

	// Send a prioritize message using Device ID 1 for purpose of sending OTP, message reply etc…
	$msg = sendSingleMessage( '+11234567890', 'This is a test of single message.', 1, null, false, null, true );

	// Send a MMS message with image using the Device ID 1.
	$attachments = 'https://example.com/images/footer-logo.png,https://example.com/downloads/sms-gateway/images/section/create-chat-bot.png';
	$msg         = sendSingleMessage( '+11234567890', 'This is a test of single message.', 1, null, true, $attachments );

	// Send a message using the SIM in slot 1 of Device ID 1 (Represented as "1|0").
	// SIM slot is an index so the index of the first SIM is 0 and the index of the second SIM is 1.
	// In this example, 1 represents Device ID and 0 represents SIM slot index.
	$msg = sendSingleMessage( '+11234567890', 'This is a test of single message.', '1|0' );

	// Send scheduled message using the primary device.
	$msg = sendSingleMessage( '+11234567890', 'This is a test of schedule feature.', null, strtotime( '+2 minutes' ) );
	print_r( $msg );

	echo 'Successfully sent a message.';
} catch ( Exception $e ) {
	echo $e->getMessage();
}


/*****************************************************************************************
 *
 *  Send Bulk Messages
 */
$messages = array();
for ( $i = 1; $i <= 12; $i++ ) {
	array_push(
		$messages,
		array(
			'number'  => '+11234567890',
			'message' => "This is a test #{$i} of PHP version. Testing bulk message functionality.",
		)
	);
}
try {
	// Send messages using the primary device.
	sendMessages( $messages );

	// Send messages using default SIM of all available devices. Messages will be split between all devices.
	sendMessages( $messages, USE_ALL_DEVICES );

	// Send messages using all SIMs of all available devices. Messages will be split between all SIMs.
	sendMessages( $messages, USE_ALL_SIMS );

	// Send messages using only specified devices. Messages will be split between devices or SIMs you specified.
	// If you send 12 messages using this code then 4 messages will be sent by Device ID 1, other 4 by SIM in slot 1 of
	// Device ID 2 (Represendted as "2|0") and remaining 4 by SIM in slot 2 of Device ID 2 (Represendted as "2|1").
	sendMessages( $messages, USE_SPECIFIED, array( 1, '2|0', '2|1' ) );

	// Send messages on schedule using the primary device.
	sendMessages( $messages, null, null, strtotime( '+2 minutes' ) );

	// Send a message to contacts in contacts list with ID of 1.
	sendMessageToContactsList( 1, 'Test', USE_SPECIFIED, 1 );

	// Send a message on schedule to contacts in contacts list with ID of 1.
	sendMessageToContactsList( 1, 'Test', null, null, strtotime( '+2 minutes' ) );

	// Array of image links to attach to MMS message;
	$attachments = array(
		'https://example.com/images/footer-logo.png',
		'https://example.com/downloads/sms-gateway/images/section/create-chat-bot.png',
	);
	$attachments = implode( ',', $attachments );

	$mmsMessages = array();
	for ( $i = 1; $i <= 12; $i++ ) {
		array_push(
			$mmsMessages,
			array(
				'number'      => '+11234567890',
				'message'     => "This is a test #{$i} of PHP version. Testing bulk MMS message functionality.",
				'type'        => 'mms',
				'attachments' => $attachments,
			)
		);
	}
	// Send MMS messages using all SIMs of all available devices. Messages will be split between all SIMs.
	$msgs = sendMessages( $mmsMessages, USE_ALL_SIMS );

	print_r( $msgs );

	echo 'Successfully sent bulk messages.';
} catch ( Exception $e ) {
	echo $e->getMessage();
}


/*****************************************************************************************
 *
 *  Get remaining message credits
 */
try {
	$credits = getBalance();
	echo "Message Credits Remaining: {$credits}";
} catch ( Exception $e ) {
	echo $e->getMessage();
}

/*****************************************************************************************
 *
 *  Get messages and their current status
 */
try {
	// Get a message using the ID.
	$msg = getMessageByID( 1 );
	print_r( $msg );

	// Get messages using the Group ID.
	$msgs = getMessagesByGroupID( ')V5LxqyBMEbQrl9*J$5bb4c03e8a07b7.62193871' );
	print_r( $msgs );

	// Get messages received in last 24 hours.
	$msgs = getMessagesByStatus( 'Received', null, null, time() - 86400 );

	// Get messages received on SIM 1 of device ID 8 in last 24 hours.
	$msgs = getMessagesByStatus( 'Received', 8, 0, time() - 86400 );
	print_r( $msgs );
} catch ( Exception $e ) {
	echo $e->getMessage();
}

/*****************************************************************************************
 *
 *  Resend messages
 */
try {
	// Resend a message using the ID.
	$msg = resendMessageByID( 1 );
	print_r( $msg );

	// Get messages using the Group ID and Status.
	$msgs = resendMessagesByGroupID( 'LV5LxqyBMEbQrl9*J$5bb4c03e8a07b7.62193871', 'Failed' );
	print_r( $msgs );

	// Resend pending messages in last 24 hours.
	$msgs = resendMessagesByStatus( 'Pending', null, null, time() - 86400 );

	// Resend pending messages sent using SIM 1 of device ID 8 in last 24 hours.
	$msgs = resendMessagesByStatus( 'Received', 8, 0, time() - 86400 );
	print_r( $msgs );
} catch ( Exception $e ) {
	echo $e->getMessage();
}

/*****************************************************************************************
 *
 *  Manage Contacts
 */
try {
	// Add a new contact to contacts list 1 or resubscribe the contact if it already exists.
	$contact = addContact( 1, '+11234567890', 'Test', true );
	print_r( $contact );

	// Unsubscribe a contact using the mobile number.
	$contact = unsubscribeContact( 1, '+11234567890' );
	print_r( $contact );
} catch ( Exception $e ) {
	echo $e->getMessage();
}

/*****************************************************************************************
 *
 *  Send USSD request
 */
try {
	// Send a USSD request using default SIM of Device ID 1.
	$ussdRequest = sendUssdRequest( '*150#', 1 );
	print_r( $ussdRequest );

	// Send a USSD request using SIM in slot 1 of Device ID 1.
	$ussdRequest = sendUssdRequest( '*150#', 1, 0 );
	print_r( $ussdRequest );

	// Send a USSD request using SIM in slot 2 of Device ID 1.
	$ussdRequest = sendUssdRequest( '*150#', 1, 1 );
	print_r( $ussdRequest );
} catch ( Exception $e ) {
	echo $e->getMessage();
}

/*****************************************************************************************
 *
 *  Get USSD requests
 */
try {
	// Get a USSD request using the ID.
	$ussdRequest = getUssdRequestByID( 1 );
	print_r( $ussdRequest );

	// Get USSD requests with request text "*150#" sent in last 24 hours.
	$ussdRequests = getUssdRequests( '*150#', null, null, time() - 86400 );
	print_r( $ussdRequests );
} catch ( Exception $e ) {
	echo $e->getMessage();
}

/*****************************************************************************************
 *
 *  Get Devices
 */
try {
	// Get all enabled devices for sending messages.
	$devices = getDevices()
	print_r( $devices );
} catch ( Exception $e ) {
	echo $e->getMessage();
}


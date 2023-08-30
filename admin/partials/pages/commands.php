<?php

$device_name = sanitize_text_field( trim( get_option( 'set-the-sms-gateway-device-name' ) ) );

$deviceId = ( isset( $device_name ) ) ? $device_name : 11;

?>

<div class="wrap">


<div>
<h1>Solde by Device ID </h1>
<div class="api_links">
		<div class="api_column">
			<input  id="device_id" type="text" placeholder="Device ID"  value="<?php echo $deviceId?>" class="large-text feedinput" required>
			
		</div>
		<div class="api_actions">
			<button id="run_solde" type="button" title="Lancer"  class=" dashicons dashicons-controls-play"></button>
			
		</div>
	</div>
</div>

<div class="commands_result"></div>

</div>
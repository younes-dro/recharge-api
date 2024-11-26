<?php
$api_url = sanitize_text_field( trim( get_option( 'set-the-sms-gateway-api-url' ) ) );
$api_key = sanitize_text_field( trim( get_option( 'set-the-sms-gateway-api-key' ) ) );
$device_name = sanitize_text_field( trim( get_option( 'set-the-sms-gateway-device-name' ) ) );
$ussd_recharge = sanitize_text_field( trim( get_option( 'set-the-ussd-code-for-recharge' ) ) );
$ussd_balance = sanitize_text_field( trim( get_option( 'set-the-ussd-code-for-balance-check' ) ) );
$email_recipients = sanitize_text_field( trim( get_option( 'set-the-users-for-email-notifications' ) ) );

?>
<div class="wrap">
<h2>SMS Gateway settings</h2>
<div class="api-form">
    <form  action = "<?php echo esc_url( get_site_url() . '/wp-admin/admin-post.php' ); ?>" method="post">
        <input type="hidden" name="action" value="save_sms_gateway_settings">
        <input type="hidden" name="current_url" value="<?php echo esc_url( recharge_api_get_current_screen_url() ); ?>"> 
            <label for="url">SMS gateway API URL:</label>
            <input value="<?php echo $api_url?>" type="text" id="set-the-sms-gateway-api-url" name="set-the-sms-gateway-api-url" placeholder="Set the SMS gateway API URL" required>

            <label for="set-the-sms-gateway-api-key">SMS gateway API key:</label>
            <input value="<?php echo $api_key?>" type="text" id="set-the-sms-gateway-api-key" name="set-the-sms-gateway-api-key" placeholder="Set the SMS gateway API key" required>

            <label for="set-the-sms-gateway-device-name">SMS gateway device name:</label>
            <input value="<?php echo $device_name?>" type="text" id="set-the-sms-gateway-device-name" name="set-the-sms-gateway-device-name" placeholder="Set the SMS gateway device name" required>

            <label for="set-the-ussd-code-for-recharge">USSD code for Recharge:</label>
            <input value="<?php echo $ussd_recharge?>" type="text" id="set-the-ussd-code-for-recharge" name="set-the-ussd-code-for-recharge" placeholder="Set the USSD code for Recharge" required>

            <label for="set-the-ussd-code-for-balance-check">USSD code for balance check:</label>
            <input value="<?php echo $ussd_balance?>" type="text" id="set-the-ussd-code-for-balance-check" name="set-the-ussd-code-for-balance-check" placeholder="Set the USSD code for balance check" required>

            <label for="set-the-users-for-email-notifications">Users for email notifications:</label>
            <input value="<?php echo $email_recipients?>" type="text" id="set-the-users-for-email-notifications" name="set-the-users-for-email-notifications" placeholder="Set the users that will receive email notifications" required>


            <input type="submit" value="Submit">
        </form>
</div>
</div>


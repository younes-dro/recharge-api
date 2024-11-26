<?php
/**
 * Send a manual Recharge.
 */

?>
<div class="wrap">
	<h2>Recharge Manuelle</h2>
	<div class="api-form">
		<form action="<?php echo esc_url( get_site_url() . '/wp-admin/admin-post.php' ); ?>" method="post">

			<label for="tel">Tel:</label>
			<input type="text" id="tel" name="tel" placeholder="Enter phone number" required>

			<label for="montant">Montant:</label>
			<input type="text" id="montant" name="montant" placeholder="Enter amount" required>

			<label for="code">Code:</label>
			<input type="text" id="code" name="code" placeholder="Enter code">

			<input id="run_recharge_manuelle" type="submit" value="Submit">
		</form>
	</div>
	<div class="result_manuelle"></div>
</div>








<!-- 
<div class="wrap">

<div class="">
	<div class="api_links">
	<h1>Recharge Manuelle</h1>
		<div class="api_column">
			<input  id="phone_number" type="text" placeholder="" value="" class="large-text feedinput">
			
		</div>
		<div class="api_actions">
			<button id="run_recharge_manuelle" type="button" title="Lancer"  class=" dashicons dashicons-controls-play"></button>
		</div>
	</div>



	<span class="stargps-spinner"></span>
	<div class="result_manuelle"></div>
</div>
</div> -->

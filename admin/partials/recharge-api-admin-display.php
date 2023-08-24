
<h1><img  class="recharge-api-logo" src="<?php echo RECHARGE_API_PLUGIN_URL; ?>admin/images/logo-medium.png" /><?php esc_html_e( 'API Devices', 'recharge-api' ); ?></h1>
		<div id="recharge-api-outer" class="skltbs-theme-light" data-skeletabs='{ "startIndex": 0 }'>
			<ul class="skltbs-tab-group">
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="api" ><?php esc_html_e( 'Add API', 'recharge-api' ); ?></button>

				</li>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="new_api" ><?php esc_html_e( 'Available APIs', 'recharge-api' ); ?></button>
				</li>>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="logs" ><?php esc_html_e( 'Logs', 'recharge-api' ); ?>	
				</button>
				</li>  
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="manuelle" ><?php esc_html_e( 'Recharge manuelle', 'recharge-api' ); ?>	
				</button>
				</li>
			</ul>
			<div class="skltbs-panel-group">
				<div id="add_api" class="recharge-api-tab-conetent skltbs-panel">
                <?php require_once RECHARGE_API_PLUGIN_DIR_PATH . 'admin/partials/pages/add-api.php'; ?>
				</div>     
				<div id="availables_api" class="recharge-api-tab-conetent skltbs-panel wrap">
                <?php require_once RECHARGE_API_PLUGIN_DIR_PATH . 'admin/partials/pages/availables-apis.php'; ?>
				</div>

				<div id='logs' class="recharge-api-tab-conetent skltbs-panel">
                <?php require_once RECHARGE_API_PLUGIN_DIR_PATH . 'admin/partials/pages/logs.php'; ?>
				</div>
				<div id='recharge_manuelle' class="recharge-api-tab-conetent skltbs-panel">
				<?php require_once RECHARGE_API_PLUGIN_DIR_PATH . 'admin/partials/pages/recharge-manuelle.php'; ?>
				</div>				
			</div>  
		</div>

<div id="tfs-options-wrap" class="wrap">
	<h2><?php _e('Theme Options'); ?></h2>

	<h2 class="nav-tab-wrapper">
		<?php echo $options_machine->menu ?>
	</h2>

	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('tfs-ajax-nonce'); ?>" />

	<form id="tfs-form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >

		<?php echo $options_machine->output; ?>

		<div class="save_bar"> 
			<button id ="tfs-save" type="button" class="button submit-button button-primary"><?php _e( 'Save Changes' );?></button>			
			<button id ="tfs-reset" type="button" class="button submit-button reset-button" ><?php _e( 'Reset Defaults' );?></button>
			<img style="display:none" src="<?php echo ADMIN_TEMPLATES; ?>images/loading-bottom.gif" class="ajax-loading-img-bottom" alt="Working..." />
			
		</div><!--.save_bar--> 

		<div id="msg-success" style="display: none;">
			<p><?php _e( 'Change Successful!' ) ?></p>
		</div>

		<div id="msg-fail" style="display: none;">
			<p><?php _e( 'Change Error!' ) ?></p>
		</div>
	</form>

</div><!--wrap-->

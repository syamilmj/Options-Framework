<div class="wrap wp-38" id="of_container">
	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save">Options Updated</div>
	</div>
	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset">Options Reset</div>
	</div>
	<div id="of-popup-fail" class="of-save-popup">
		<div class="of-save-fail">Error!</div>
	</div>
	<span style="display: none;" id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
	<div class="logo">
		<h2><?php echo THEMENAME; ?> <span><?php echo ('v'. THEMEVERSION); ?></span></h2>
	</div>
	<div id="js-warning">Warning &ndash; This options panel will not work properly without JavaScript enabled!</div>
	<div class="icon-option"></div>
	<div class="clear"></div>
	<input type="hidden" id="reset" value="<?php if(isset($_REQUEST['reset'])) echo $_REQUEST['reset']; ?>">
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>">
	<form id="of_form" method="post" action="<?php echo esc_attr($_SERVER['REQUEST_URI']) ?>" enctype="multipart/form-data" >
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<a><div id="expand_options" class="expand" title="Show all options">Expand</div></a>
						<img style="display: none;" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working...">
					</th>
					<td>
						<button id="of_save" type="button" class="button-primary"><?php _e( 'Save All Changes' ); ?></button>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<div id="of-nav">
							<ul>
								<?php echo $options_machine->Menu ?>
							</ul>
						</div>
					</th>
					<td>
						<div id="content"><?php echo $options_machine->Inputs ?></div>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<img style="display: none;" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working...">
						<button id ="of_reset" type="button" class="button submit-button reset-button" ><?php _e('Options Reset'); ?></button>
					</th>
					<td>
						<img style="display: none;" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-reset-loading-img ajax-loading-img-bottom" alt="Working...">
						<button id ="of_save" type="button" class="button-primary"><?php _e('Save All Changes');?></button>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2">
						<div class="smof_footer_info">Skeleton WordPress Admin Panel <strong><?php echo SMOF_VERSION; ?></strong></div>
					</th>
			</tbody>
		</table>
		</form>
</div><!--wrap-->

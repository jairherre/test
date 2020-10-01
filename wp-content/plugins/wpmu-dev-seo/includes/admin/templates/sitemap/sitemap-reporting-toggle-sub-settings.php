<?php
$dash_profile_data = smartcrawl_get_dash_profile_data();
?>
<?php if ( $dash_profile_data ): ?>
	<small><strong><?php esc_html_e( 'Recipient', 'wds' ); ?></strong></small>
	<?php $this->_render( 'email-recipients', array(
		'id'               => 'wds-sitemap-email-recipients',
		'disable_addition' => true,
		'email_recipients' => array(
			array(
				'name'  => $dash_profile_data->user_login,
				'email' => $dash_profile_data->user_email,
			),
		),
	) ); ?>
	<p></p>
<?php endif; ?>

<small><strong><?php esc_html_e( 'Schedule', 'wds' ); ?></strong></small>

<?php $this->_render( 'sitemap/sitemap-reporting-schedule' ); ?>
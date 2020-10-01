<?php
$engines = empty( $engines ) ? array() : $engines;
$automatically_switched = empty( $automatically_switched ) ? false : $automatically_switched;
$total_post_count = empty( $total_post_count ) ? 0 : $total_post_count;
?>

<?php $this->_render( 'sitemap/sitemap-split-setting', array(
	'automatically_switched' => $automatically_switched,
	'total_post_count'       => $total_post_count,
) ); ?>

<?php
$this->_render( 'toggle-group', array(
	'label'       => esc_html__( 'Include images', 'wds' ),
	'description' => esc_html__( 'If your posts contain imagery you would like others to be able to search, this setting will help Google Images index them correctly.', 'wds' ),
	'items'       => array(
		'sitemap-images' => array(
			'label'       => esc_html__( 'Include image items with the sitemap', 'wds' ),
			'description' => esc_html__( 'Note: When uploading attachments to posts, be sure to add titles and captions that clearly describe your images.', 'wds' ),
			'value'       => '1',
		),
	),
) );

$this->_render( 'toggle-group', array(
	'label'       => esc_html__( 'Auto-notify search engines', 'wds' ),
	'description' => esc_html__( 'Instead of waiting for search engines to crawl your website you can automatically submit your sitemap whenever it changes.', 'wds' ),
	'separator'   => true,
	'items'       => $engines,
) );

$this->_render( 'toggle-group', array(
	'label'       => esc_html__( 'Style sitemap', 'wds' ),
	'description' => esc_html__( 'Adds some nice styling to your sitemap.', 'wds' ),
	'separator'   => true,
	'items'       => array(
		'sitemap-stylesheet' => array(
			'label'       => esc_html__( 'Include stylesheet with sitemap', 'wds' ),
			'description' => esc_html__( 'Note: This doesn’t affect your SEO and is purely visual.', 'wds' ),
			'value'       => '1',
		),
	),
) );
?>

<?php
$automatic_updates_disabled = ! empty( $_view['options']['sitemap-disable-automatic-regeneration'] );
$automatic_updates_notice_class = 'sui-notice-warning';
if ( ! $automatic_updates_disabled ) {
	$automatic_updates_notice_class .= ' hidden';
}
?>
<div class="wds-disable-updates">
	<?php
	$this->_render( 'toggle-group', array(
		'label'       => esc_html__( 'Automatic sitemap updates', 'wds' ),
		'description' => esc_html__( 'Choose whether or not you want SmartCrawl to update your Sitemap automatically when you publish new pages, posts, post types or taxonomies.', 'wds' ),
		'separator'   => true,
		'items'       => array(
			'sitemap-disable-automatic-regeneration' => array(
				'label'            => esc_html__( 'Automatically update my sitemap', 'wds' ),
				'inverted'         => true,
				'html_description' => $this->_load( 'notice', array(
					'message' => esc_html__( "Your sitemap isn't being updated automatically. Click Save Settings below to regenerate your sitemap.", 'wds' ),
					'class'   => $automatic_updates_notice_class,
				) ),
			),
		),
	) );
	?>
	<div></div>
</div>

<?php $this->_render( 'sitemap/sitemap-deactivate-button', array(
	'label_description'  => esc_html__( 'If you no longer wish to use the Sitemap generator, you can deactivate it.', 'wds' ),
	'button_description' => esc_html__( 'Note: Sitemaps are crucial for helping search engines index all of your content effectively. We highly recommend you have a valid sitemap.', 'wds' ),
) ); ?>
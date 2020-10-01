<?php
/**
 * Lesson resources shortcode template
 */

defined( 'ABSPATH' ) || exit;

$i = 0;
$has_resource_title = false;

if ( ! empty( $resource_data ) ) : ?>

	<div class="tg-ResourcesSections">

		<?php
		foreach ( $resource_data as $key => $value ) :
			if ( isset( $value->r_id) && $value->r_id == 0 ) :
				$has_resource_title = true;

				if ( $i != 0 ) {
					echo '</div>';
				}

				echo '<div class="tg-ResourcesSection '.($value->highlight == 'yes' ? 'tg-ResourcesSection--highlight':'').'">';
				$i++;
				?>

				<h3 class="tg-ResourcesSection__title"><?php echo stripslashes($value->title);?></h2>

			<?php else : ?>
				<ul class="tg-ResourcesList">
				<?php

				if ( isset( $value->link_url ) && $value->link_url != '' ) : // this is a single resource
					?>
					<li class="tg-ResourcesList__item"><?php echo get_resource_icon_fa(($value->link_url == 'yes'?'.ext_link':'.link'));?> <a class="tg-ResourcesList__itemLink" href="<?php echo $value->link_url;?>" target="<?php echo ($value->link_open_in_new_tab == 'yes'?'_blank':'');?>" rel="<?php echo ($value->link_nofollow == 'yes'?'nofollow':'');?>"><?php echo $value->title;?></a></li>
					<?php
				else :
					foreach ( $value as $key1 => $value1 ) :
						if ( $value1->att_id == 0 ) :
							$r_link = json_decode( $value1->r_link, true );
							?>
							<li><?php echo get_resource_icon_fa(($r_link['open_in_new_tab'] == 'yes'?'.ext_link':'.link'));?> <a href="<?php echo $r_link['url'];?>" target="<?php echo ($r_link['open_in_new_tab'] == 'yes'?'_blank':'');?>"><?php echo $r_link['name'];?></a></li>
						<?php else : ?>
							<li><?php echo get_resource_icon_fa(wp_get_attachment_url( $value1->att_id ));?> <a href="<?php echo wp_get_attachment_url( $value1->att_id );?>" target="_blank"><?php echo get_the_title( $value1->att_id );?></a></li>
							<?php
						endif;
					endforeach;
				endif;
				?>

				</ul>

				<?php
			endif;
		endforeach;
		?>

		<?php
		if ( $has_resource_title ) {
			echo '</div>';
		}
		?>

	</div>

	<?php
endif;

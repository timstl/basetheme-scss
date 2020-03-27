<?php
if ( get_field( 'alert_enable', 'options' ) && get_field( 'alert_message', 'options' ) ) {

	$show_alert = false;

	if ( get_field( 'alert_display_pages', 'options' ) == 'all' ) {
		$show_alert = true;
	} else {

		$page_ids = array();

		if ( get_field( 'alert_display_pages', 'options' ) == 'home' ) {
			if ( is_front_page() ) {
				$show_alert = true;
			}
		} elseif ( get_field( 'alert_display_pages', 'options' ) == 'specific' && get_field( 'alert_page_ids', 'options' ) ) {
			$alert_page_ids = get_field( 'alert_page_ids', 'options' );
			
			if ( ! is_array( $alert_page_ids ) ) {
				$page_ids = array( $alert_page_ids );
			}

			$page_ids = $alert_page_ids;

			global $post;
			if ( ! empty( $page_ids ) && in_array( $post->ID, $page_ids ) ) {
				$show_alert = true;
			}
		}
	}

	if ( $show_alert ) : ?>
	<div class="alertmessage">
		<div class="<?php esc_attr_e( get_field( 'alert_container', 'options' ) ); ?>">
			<?php the_field( 'alert_message', 'options' ); ?>
		</div>
	</div>
		<?php
	endif;
}

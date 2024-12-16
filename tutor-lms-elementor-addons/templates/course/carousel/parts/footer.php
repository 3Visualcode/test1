<?php if ( 'yes' === $settings['course_carousel_footer_settings'] ) : ?>

<?php 
	$course_id    = get_the_ID();
	$can_continue = tutor_utils()->is_enrolled( $course_id ) || get_post_meta( $course_id, '_tutor_is_public_course', true ) == 'yes';

	if ( ! $can_continue ) {
		$can_continue = tutor_utils()->has_user_course_content_access( get_current_user_id(), $course_id );
	}
	
	$corso_iscritto=tutor_utils()->is_course_added_to_cart( $course_id );
	if ( $can_continue || $corso_iscritto) {
		?>
		<div class="tutor-card-footer">
			<?php

				$monitize_by     = tutor_utils()->get_option( 'monetize_by' );
				$is_purchasable  = tutor_utils()->is_course_purchasable();
				if ( 'edd' === $monitize_by && $is_purchasable ) {
					ob_start();
					tutor_load_template( 'single.course.add-to-cart-edd' );
					echo apply_filters( 'tutor/course/single/entry-box/purchasable', ob_get_clean(), get_the_ID() );
				} else {
					tutor_course_loop_price();
				}
			?>
		</div>
<?php		
	}
endif; ?>
<?php
/**
 * @package Tutor\Templates
 * @subpackage CourseLoopPart
 * @author Themeum <support@themeum.com>
 * @link https://themeum.com
 * @since 1.4.3
 */
$course_id    = get_the_ID();
$can_continue = tutor_utils()->is_enrolled( $course_id ) || get_post_meta( $course_id, '_tutor_is_public_course', true ) == 'yes';

if ( ! $can_continue ) {
	$can_continue = tutor_utils()->has_user_course_content_access( get_current_user_id(), $course_id );
}

$corso_iscritto=tutor_utils()->is_course_added_to_cart( $course_id );
if ( $can_continue || $corso_iscritto) {
?>

<div class="tutor-card-footer">
	<?php tutor_course_loop_price(); ?>
</div>

<?php
}
?>
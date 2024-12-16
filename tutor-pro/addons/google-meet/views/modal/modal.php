<?php
/**
 * Modal template wrapper
 *
 * @since v2.1.0
 *
 * @package TutorPro\GoogleMeet\Views
 */

?>
<div class="tutor-modal tutor-modal-scrollable <?php echo esc_attr( $data['modal_class'] );?>" id="<?php echo esc_attr( $data['modal_id'] ); ?>">
	<div class="tutor-modal-overlay"></div>
	<div class="tutor-modal-window">
		<div class="tutor-modal-content">
			
			<?php if ( isset( $data['form_id'] ) && '' !== $data['form_id'] ) : ?>
				<form action="" id="<?php echo esc_attr( $data['form_id'] ); ?>">
			<?php endif; ?>
				<?php tutor_nonce_field(); ?>
				<input type="hidden" type="text" name="attendees" value="Yes">
				<?php if ( isset( $data['hidden_args'] ) ) : ?>
					<?php foreach ( $data['hidden_args'] as $key => $value ) : ?>
						<input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>">
					<?php endforeach; ?>
				<?php endif; ?>
				<div class="tutor-modal-header">
					<div class="tutor-modal-title">
						<?php echo esc_html( $data['header_title'] ); ?>       
					</div>
					<button class="tutor-iconic-btn tutor-modal-close" data-tutor-modal-close="">
						<span class="tutor-icon-times" area-hidden="true"></span>
					</button>
				</div>
				<div class="tutor-modal-body tutor-modal-container">
					<?php
					if ( '' !== $data['body'] && file_exists( $data['body'] ) ) {
						tutor_load_template_from_custom_path( $data['body'], array( 'modal_id' => $data['modal_id'] ), false );
					}
					?>
					<select name="course_dup_id" class="tutor-form-select tutor-mw-100">
						<?php 
							global $wpdb;
							$where_custom="";
							if(isset($data['hidden_args']['course_id']) && !empty($data['hidden_args']['course_id'])){
								$where_custom="AND post_author = (select post_author from {$wpdb->posts} where ID = ".$data['hidden_args']['course_id'].") AND ID <> ".$data['hidden_args']['course_id'];
							}
								
							$data_courses_custom = $wpdb->get_results(
								$wpdb->prepare(
									"SELECT ID,
										post_author,
										post_title,
										post_name,
										post_status,
										menu_order
								FROM 	{$wpdb->posts}
								WHERE 	post_status IN ('publish','private')
								AND 	post_type IN ( %s, %s ) $where_custom
								",
									'courses',
									'course-bundle'
								)
							);
						?>
						<option value="0" >
						<?php
							echo esc_html( 'Seleziona il corso dove duplicare il meet che stai creando' );
							?>
							</option>
							<?php
							foreach ( $data_courses_custom as $row ) :
								echo wp_kses(
									"<option value='{$row->ID}'>{$row->post_title}</option>",
									array(
										'option' => array( 'value' => true ),
									)
								);
							endforeach; 
						?>
					</select> 
				</div>	
				<div class="tutor-modal-footer">
					<?php foreach ( $data['footer_buttons'] as $key => $button ) : ?>
						<button type="<?php echo esc_attr( $button['type'] ); ?>" class="<?php echo esc_attr( $button['class'] ); ?>" id="<?php echo esc_attr( $button['id'] ); ?>" <?php echo esc_attr( isset( $button['attr'] ) ? $button['attr'] : '' ); ?>>
							<?php echo esc_html( $button['label'] ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php if ( isset( $data['form_id'] ) && '' !== $data['form_id'] ) : ?>
				</form>
			<?php endif; ?>
		</div>
	</div>
</div>

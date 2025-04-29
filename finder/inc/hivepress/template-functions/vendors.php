<?php
/**
 * Finder HivePress Vendors Template Functions
 *
 * @package Finder
 */

use HivePress\Forms\Message_Send;
use HivePress\blocks\Message_Send_Form;

if ( ! function_exists( 'finder_hivepress_archive_vendor_template_content' ) ) {
	/**
	 * Display hivepress vendors content.
	 *
	 * @param object $vendor vendors object.
	 */
	function finder_hivepress_archive_vendor_template_content( $vendor ) {

		$args = array(
			'vendor' => $vendor,
		);

		finder_get_template( 'hivepress/vendors/archive-vendor-content.php', $args );
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_message_form' ) ) {
	/**
	 * Display hivepress vendors content.
	 *
	 * @param object $vendor vendors object.
	 */
	function finder_hivepress_vendor_message_form( $vendor ) {

		if ( ! finder_is_hivepress_messages_activated() ) {
			return;
		}


		$msg_forms = new Message_Send_Form();
		

		$msg_form_args = array(
			'attributes' => array(
				'class'      => array( 'modal-body' ),
				'data-reset' => 'true',
				
			),
			'fields'     => array(
				'text'      => array(
					'label'      => false,
					'attributes' => array(
						'rows'        => 6,
						'placeholder' => esc_html__( 'Type your message here', 'finder' ),
					),
				),
				'recipient' => array(
					'display_type' => 'hidden',
					'value'        => $vendor->get_user__id(),
				),
			),
			'button'     => array(
				'label'      => esc_html__( 'Send message', 'finder' ),
				'attributes' => array(
					'class' => array( 'btn', 'btn-primary', 'mb-2', 'mt-2' ),
				),
			),
		);

		if ( isset( $msg_forms->get_context()['message'] ) ) {
			$data_id = $msg_forms->get_context()['message']->get_id();
			$msg_form_args['attributes']['data-id'] = $data_id;
		}

		$msg_form = new Message_Send( $msg_form_args );

		?>
		<div class="modal fade vendor-archive-message-form" id="message_send_modal_<?php echo esc_attr( $vendor->get_id() ); ?>" tabindex="-1" aria-modal="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="fs-base modal-title"><?php echo esc_html( sprintf( 'Message to  %s', $vendor->get_name() ) ); ?></h3>
						<button class="btn-close ms-0" type="button" data-bs-dismiss="modal"></button>
					</div>
					<?php echo apply_filters( 'finder_vendor_msg_form_output', $msg_form->render() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		</div>
		<?php
	}
}

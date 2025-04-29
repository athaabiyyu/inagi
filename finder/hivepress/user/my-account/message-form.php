<?php
/**
 * The Template for my account message form
 *
 * @package Finder
 */

use HivePress\Blocks\Message_Send_Form;
$account_style             = finder_hivepress_get_user_account_style();
$listing_message_form_args = apply_filters(
	'finder_listing_message_form_args',
	array(
		'form'   => 'message_send',
		'button' => array(
			'attributes' => array(
				'class' => array( 'btn', 'btn-primary', 'px-3', 'px-sm-4', 'mt-4' ),
			),
		),
	)
);

$listing_message_form = new Message_Send_Form( $listing_message_form_args );

?><div class="finder-form-<?php echo esc_attr( 'car-finder' === $account_style ) ? 'dark' : 'light'; ?>">
<?php
echo apply_filters( 'finder_user_listing_message_form_output', $listing_message_form->render() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
?>
</div>
<?php

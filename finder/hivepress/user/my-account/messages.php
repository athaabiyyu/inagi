<?php
/**
 * The Template for my account messages
 *
 * @package Finder
 */

use HivePress\Models\User;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$account_style = finder_hivepress_get_user_account_style();
$card_class    = '';
$header_class  = finder_hivepress_user_account_header_classes();
$user          = User::query()->get_by_id( hivepress()->request->get_param( 'user_id' ) );
$sticky_header = finder_is_sticky_header();

if ( 'car-finder' === $account_style ) {
	$card_class = 'card-light';
}

$container_class = 'container pt-5 pb-lg-4 mt-5 mb-sm-2';
if ( ! $sticky_header ) {
	$container_class = 'container mt-4 mb-md-4 pt-2';
}

?>
<div class="<?php echo esc_attr( $container_class ); ?>">
	<?php if ( 'city-guide' === $account_style ) : ?>
		<div class="pt-5">
		<?php finder_hivepress_sidebar_city_guide_listing(); ?>
		</div>
		<div class="card card-body p-4 p-md-5 shadow-sm">
			<?php finder_hivepress_sidebar_city_guide_content(); ?>
			<div class="d-flex flex-md-row flex-column align-items-md-center justify-content-md-between mb-4 pt-2">
				<h1 class="<?php echo esc_attr( $header_class ); ?>">
					<?php
						echo esc_html(
							sprintf(
							/* translators: 1: user name */
								esc_html__( 'Messages from %s', 'finder' ),
								$user->get_display_name()
							)
						);
					?>
				</h1>
			</div>
			<?php

			// Get message IDs.
			$message_ids = hivepress()->request->get_context( 'message_ids' );

			// Get messages.
			$messages = Hivepress\Models\Message::query()->filter(
				array(
					'id__in' => $message_ids,
				)
			)->order( 'id__in' )
			->limit( count( $message_ids ) )
			->get()
			->serialize();

			?>
			<div class="hp-messages hp-grid">
				<?php foreach ( $messages as $message ) : ?>
				<div class="hp-grid__item mb-4 <?php echo esc_attr( $message->get_sender__id() === get_current_user_id() ? 'ms-5' : 'me-5' ); ?>">
					<div class="mx-0 hp-message rounded hp-message--view-block <?php echo esc_attr( $message->get_sender__id() === get_current_user_id() ? 'hp-message--sent' : 'hp-message--read bg-secondary' ); ?>">
						<?php if ( $message->get_listing__id() ) : ?>
							<a href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', array( 'listing_id' => $message->get_listing__id() ) ) ); ?>" target="_blank" class="hp-message__listing hp-link"><i class="hp-icon fas fa-external-link-alt"></i><span><?php echo esc_html( $message->get_listing__title() ); ?></span></a>
						<?php endif; ?>
						<header class="hp-message__header">
							<div class="hp-message__details mt-2">
								<strong class="hp-message__sender"><?php echo esc_html( $message->get_sender__display_name() ); ?></strong>
								<time class="hp-message__sent-date hp-message__date hp-meta" datetime="<?php echo esc_attr( $message->get_sent_date() ); ?>"><?php echo esc_html( $message->display_sent_date() ); ?></time>
							</div>
						</header>
						<div class="hp-message__content">
							<div class="hp-message__text"><?php comment_text( $message->get_id() ); ?></div>
								<?php if ( $message->get_attachment__id() ) : ?>
									<a href="<?php echo esc_url( $message->get_attachment__url() ); ?>" target="_blank" class="hp-message__attachment hp-link">
										<i class="hp-icon fas fa-file-download"></i>
										<span><?php echo esc_html( $message->get_attachment__name() ); ?></span>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<?php finder_get_template( 'hivepress/user/my-account/message-form.php' ); ?>
			</div>
		</div>
	<?php else : ?>
		<div class="row pt-5">
			<aside class="col-lg-4 col-md-5 pe-xl-4 mb-5">
				<div class="card card-body <?php echo esc_attr( $card_class ); ?> border-0 shadow-sm pb-1 me-lg-1">
					<?php
						finder_hivepress_sidebar_author_meta();
						finder_hivepress_sidebar_listing();
					?>
				</div>
			</aside>
			<div class="col-lg-8 col-md-7 mb-5">
				<h1 class="<?php echo esc_attr( $header_class ); ?>">
					<?php
					echo esc_html(
						sprintf(
						/* translators: 1: user name */
							esc_html__( 'Messages from %s', 'finder' ),
							$user->get_display_name()
						)
					);
					?>
				</h1>
				<?php

				// Get message IDs.
				$message_ids = hivepress()->request->get_context( 'message_ids' );

				// Get messages.
				$messages = Hivepress\Models\Message::query()->filter(
					array(
						'id__in' => $message_ids,
					)
				)->order( 'id__in' )
				->limit( count( $message_ids ) )
				->get()
				->serialize();
				?>
				<div class="hp-messages hp-grid">
					<?php foreach ( $messages as $message ) : ?>
					<div class="hp-grid__item mb-4 <?php echo esc_attr( $message->get_sender__id() === get_current_user_id() ? 'ms-5' : 'me-5' ); ?>">
						<div class="mx-0 hp-message rounded hp-message--view-block <?php echo esc_attr( $message->get_sender__id() === get_current_user_id() ? 'hp-message--sent' : 'hp-message--read bg-secondary' ); ?>">
							<?php if ( $message->get_listing__id() ) : ?>
								<a href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', array( 'listing_id' => $message->get_listing__id() ) ) ); ?>" target="_blank" class="hp-message__listing hp-link"><i class="hp-icon fas fa-external-link-alt"></i><span><?php echo esc_html( $message->get_listing__title() ); ?></span></a>
							<?php endif; ?>
							<header class="hp-message__header">
								<div class="hp-message__details mt-2">
									<strong class="hp-message__sender"><?php echo esc_html( $message->get_sender__display_name() ); ?></strong>
									<time class="hp-message__sent-date hp-message__date hp-meta" datetime="<?php echo esc_attr( $message->get_sent_date() ); ?>"><?php echo esc_html( $message->display_sent_date() ); ?></time>
								</div>
							</header>
							<div class="hp-message__content">
								<div class="hp-message__text"><?php comment_text( $message->get_id() ); ?></div>
								<?php if ( $message->get_attachment__id() ) : ?>
									<a href="<?php echo esc_url( $message->get_attachment__url() ); ?>" target="_blank" class="hp-message__attachment hp-link">
										<i class="hp-icon fas fa-file-download"></i>
										<span><?php echo esc_html( $message->get_attachment__name() ); ?></span>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
					<?php finder_get_template( 'hivepress/user/my-account/message-form.php' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>


<?php
/**
 * The Template for my account messages-thread
 *
 * @package Finder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$account_style = finder_hivepress_get_user_account_style();
$card_class    = '';
$header_class  = finder_hivepress_user_account_header_classes();
$sticky_header = finder_is_sticky_header();

if ( 'car-finder' === $account_style ) {
	$card_class = 'card-light';
}

$container_class = 'container mt-5 py-5';
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
				<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html__( 'Messages', 'finder' ); ?></h1>
			</div>
			<div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4 gx-3 gx-lg-4">
			<?php
				// Get thread IDs.
				$thread_ids = hivepress()->request->get_context( 'message_thread_ids' );

				// Get threads.
				$threads = array();

				$messages = HivePress\Models\Message::query()->filter(
					array(
						'id__in' => $thread_ids,
					)
				)->order( array( 'sent_date' => 'desc' ) )->limit( count( $thread_ids ) )->get()->serialize();

			foreach ( $messages as $message ) {
				if ( $message->get_sender__id() === get_current_user_id() ) {

					// Get recipient.
					$recipient = $message->get_recipient();

					if ( ! $recipient ) {
						continue;
					}

					// Set sender.
					$message->fill(
						array(
							'sender'               => $recipient->get_id(),
							'sender__display_name' => $recipient->get_display_name(),
							'sender__email'        => $recipient->get_email(),
							'read'                 => 1,
						)
					);
				}

				// Add thread.
				if ( ! isset( $threads[ $message->get_sender__id() ] ) ) {
					$threads[ $message->get_sender__id() ] = $message;
				}
			}
			foreach ( $threads as $thread ) {
				$icon_class = 'fas fa-envelope';
				$icon_class = $thread->is_read() ? $icon_class . '-open' : $icon_class;
				?>
				<div class="col">
					<div class="message-listing card card-hover card-body mb-3 bg-secondary">
						<a href="<?php echo esc_url( hivepress()->router->get_url( 'messages_view_page', array( 'user_id' => $thread->get_sender__id() ) ) . '#message-' . $thread->get_id() ); ?>" class="mb-2 nav-link p-0 stretched-link fs-6">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 40, '', 'avatar', array( 'class' => 'rounded-circle me-2' ) ); ?>
							<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
							<span><?php echo esc_html( $thread->get_sender__display_name() ); ?></span>
						</a>
					<?php

					if ( $thread->get_listing__id() ) :
						?>
							<a href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', array( 'listing_id' => $thread->get_listing__id() ) ) ); ?>" target="_blank" class="hp-link mb-2"><i class="hp-icon fas fa-external-link-alt"></i><span><?php echo esc_html( $thread->get_listing__title() ); ?></span></a>
						<?php endif; ?>

						<time datetime="<?php echo esc_attr( $thread->get_sent_date() ); ?>"><?php echo esc_html( $thread->display_sent_date() ); ?></time>
					</div>
				</div>
				<?php
			}
			?>
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
			<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html__( 'Messages', 'finder' ); ?></h1>
				<?php
					// Get thread IDs.
					$thread_ids = hivepress()->request->get_context( 'message_thread_ids' );

					// Get threads.
					$threads = array();

					$messages = HivePress\Models\Message::query()->filter(
						array(
							'id__in' => $thread_ids,
						)
					)->order( array( 'sent_date' => 'desc' ) )->limit( count( $thread_ids ) )->get()->serialize();

				foreach ( $messages as $message ) {
					if ( $message->get_sender__id() === get_current_user_id() ) {

						// Get recipient.
						$recipient = $message->get_recipient();

						if ( ! $recipient ) {
							continue;
						}

						// Set sender.
						$message->fill(
							array(
								'sender'               => $recipient->get_id(),
								'sender__display_name' => $recipient->get_display_name(),
								'sender__email'        => $recipient->get_email(),
								'read'                 => 1,
							)
						);
					}

					// Add thread.
					if ( ! isset( $threads[ $message->get_sender__id() ] ) ) {
						$threads[ $message->get_sender__id() ] = $message;
					}
				}

				foreach ( $threads as $thread ) {

					$icon_class = 'fas fa-envelope';
					$icon_class = $thread->is_read() ? $icon_class . '-open' : $icon_class;

					?>
					<div class="message-listing card card-hover card-body mb-3 bg-secondary">
						<a href="<?php echo esc_url( hivepress()->router->get_url( 'messages_view_page', array( 'user_id' => $thread->get_sender__id() ) ) . '#message-' . $thread->get_id() ); ?>" class="mb-2 nav-link p-0 stretched-link fs-6">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 40, '', 'avatar', array( 'class' => 'rounded-circle me-2' ) ); ?>
							<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
							<span><?php echo esc_html( $thread->get_sender__display_name() ); ?></span>
						</a>
					<?php

					if ( $thread->get_listing__id() ) :
						?>
							<a href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', array( 'listing_id' => $thread->get_listing__id() ) ) ); ?>" target="_blank" class="hp-link mb-2"><i class="hp-icon fas fa-external-link-alt"></i><span><?php echo esc_html( $thread->get_listing__title() ); ?></span></a>
						<?php endif; ?>

						<time datetime="<?php echo esc_attr( $thread->get_sent_date() ); ?>"><?php echo esc_html( $thread->display_sent_date() ); ?></time>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	<?php endif; ?>
</div>


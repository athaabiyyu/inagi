<?php
/**
 * Finder HivePress Myaccount Template Functions
 *
 * @package Finder
 */

use HivePress\Menus\User_Account;
use HivePress\Forms\User_Delete;

if ( ! function_exists( 'finder_hivepress_view_accounts_styles' ) ) {
	/**
	 * Display hivepress view_accounts content.
	 */
	function finder_hivepress_view_accounts_styles() {

		$account_style = finder_hivepress_get_user_account_style();
		finder_get_template( 'hivepress/myaccount/account-' . $account_style . '.php' );
	}
}

if ( ! function_exists( 'finder_hivepress_sidebar_author_meta' ) ) {
	/**
	 * Display hivepress sidebar_author_info.
	 */
	function finder_hivepress_sidebar_author_meta() {
		$user          = wp_get_current_user();
		$account_style = finder_hivepress_get_user_account_style();
		$text_class    = 'car-finder' === $account_style ? 'text-light' : '';
		$li_class      = 'car-finder' === $account_style ? '-light' : '';
		$button_text   = 'Add property';
		if ( 'car-finder' === $account_style ) {
			$button_text   = 'Add Car';
		}
		if ( 'city-guide' === $account_style ) {
			$button_text   = 'Add Business';
		}


		?><div class="d-flex d-md-block d-lg-flex align-items-start pt-lg-2 mb-4">
			<?php echo get_avatar( $user->ID, 48, '', $user->display_name, array( 'class' => 'rounded-circle' ) ); ?>
			<div class="pt-md-2 pt-lg-0 ps-3 ps-md-0 ps-lg-3">
				<h2 class="fs-lg mb-0 <?php echo esc_attr( $text_class ); ?>"><?php echo esc_html( $user->display_name ); ?></h2>
				<ul class="list-unstyled fs-sm mt-3 mb-0">
					<li><a class="nav-link<?php echo esc_attr( $li_class ); ?> fw-normal p-0" href="mailto:<?php echo esc_html( $user->user_email ); ?>"><i class="fi-mail opacity-60 me-2"></i><?php echo esc_html( $user->user_email ); ?></a></li>
				</ul>
			</div>
		</div>
		<?php if ( get_option( 'hp_listing_enable_submission' ) ) : ?>
		<a class="btn btn-primary btn-lg w-100 mb-3" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_submit_page' ) ); ?>"><i class="fi-plus me-2"></i><?php echo apply_filters( 'finder_hivepress_account_add_button_text', $button_text ); ?></a>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_hivepress_sidebar_listing' ) ) {
	/**
	 * Display hivepress sidebar_listing_info.
	 */
	function finder_hivepress_sidebar_listing() {
			// Get menu items.
		$menu_items    = ( new User_Account() )->get_items();
		$url           = hivepress()->router->get_current_url();
		$account_style = finder_hivepress_get_user_account_style();
		$btn_class     = 'car-finder' === $account_style ? 'light' : 'primary';

		$default_icons = apply_filters(
			'finder_sidebar_myaccount_listing_icons',
			array(
				'listings_edit'              => 'fi-home',
				'user_listing_packages_view' => 'fi-file-clean',
				'orders_view'                => 'fi-file',
				'messages_thread'            => 'fi-chat-circle',
				'listings_favorite'          => 'fi-heart',
				'user_edit_settings'         => 'fi-settings',
				'user_logout'                => 'fi-logout',
				'vendor_dashboard'           => 'fi-dashboard',
			)
		);
		?>
		<a class="btn btn-outline-<?php echo esc_attr( $btn_class ); ?> d-block d-md-none w-100 mb-3" href="#account-nav" data-bs-toggle="collapse"><i class="fi-align-justify me-2"></i><?php echo esc_html__( 'Menu', 'finder' ); ?></a>
		<div class="collapse d-md-block mt-3" id="account-nav">
			<div class="card-nav">
			<?php
			foreach ( $menu_items as $key => $menu_item ) :

				$active = ( ( $url === $menu_item['url'] || strpos( $url, $menu_item['url'] ) !== false ) ? ' active' : '' );

				?>
				<a class="card-nav-link<?php echo esc_attr( $active ); ?>" href="<?php echo esc_url( $menu_item['url'] ); ?>">
					<i class="<?php echo esc_attr( $default_icons[ $key ] ); ?> opacity-60 me-2"></i>
					<?php echo esc_html( $menu_item['label'] ); ?>
					<?php if ( hivepress()->request->get_context( 'notice_count' ) && 'messages_thread' === $key ) : ?>
						<small class="badge rounded-pill bg-primary ms-1"><?php echo esc_html( hivepress()->request->get_context( 'notice_count' ) ); ?></small>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
if ( ! function_exists( 'finder_hivepress_sidebar_city_guide_listing' ) ) {
	/**
	 * Display hivepress sidebar_city listing_info.
	 */
	function finder_hivepress_sidebar_city_guide_listing() {
		$menu_items = ( new User_Account() )->get_items();
		$user       = wp_get_current_user();

		?>
		<div class="d-flex align-items-center justify-content-between pb-4 mb-2">
			<div class="d-flex align-items-center">
				<div class="position-relative flex-shrink-0">
				<?php echo get_avatar( $user->ID, 100, '', $user->display_name, array( 'class' => 'rounded-circle border border-white' ) ); ?>
				</div>
				<div class="ps-3 ps-sm-4">
					<h3 class="h4 mb-2"><?php echo esc_html( $user->display_name ); ?></h3>
				</div>
			</div>
			<a class="nav-link p-0 d-none d-md-block" href="<?php echo esc_url( $menu_items['user_logout']['url'] ); ?>"><i class="fi-logout mt-n1 me-2"></i><?php echo esc_html( $menu_items['user_logout']['label'] ); ?></a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_sidebar_city_guide_content' ) ) {
	/**
	 * Display hivepress city content_info.
	 */
	function finder_hivepress_sidebar_city_guide_content() {
		$menu_items    = ( new User_Account() )->get_items();
		$url           = hivepress()->router->get_current_url();
		$default_icons = apply_filters(
			'finder_sidebar_myaccount_listing_icons',
			array(
				'listings_edit'              => 'fi-home',
				'user_listing_packages_view' => 'fi-file-clean',
				'orders_view'                => 'fi-file',
				'messages_thread'            => 'fi-chat-circle',
				'listings_favorite'          => 'fi-heart',
				'user_edit_settings'         => 'fi-settings',
				'user_logout'                => 'fi-logout',
			)
		);
		?>
		<div class="mt-md-n3 mb-4">
			<a class="btn btn-outline-primary btn-lg rounded-pill w-100 d-md-none" href="#account-nav" data-bs-toggle="collapse"><i class="fi-align-justify me-2"></i><?php echo esc_html__( 'Account Menu', 'finder' ); ?></a>
			<div class="collapse d-md-block" id="account-nav">
				<ul class="nav nav-pills flex-column flex-md-row pt-3 pt-md-0 pb-md-4 border-bottom-md">
					<?php
					foreach ( $menu_items as $key => $menu_item ) :
						$active = ( $url === $menu_item['url'] ? ' active' : '' );
						?>
						<li class="nav-item <?php echo ( 'Sign Out' !== $menu_item['label'] ) ? 'mb-md-0 me-md-2 pe-md-1' : 'd-md-none'; ?>">
							<a class="nav-link<?php echo esc_attr( $active ); ?>" href="<?php echo esc_url( $menu_item['url'] ); ?>">
								<i class="<?php echo esc_attr( $default_icons[ $key ] ); ?> mt-n1 me-2"></i>
								<?php echo esc_html( $menu_item['label'] ); ?>
								<?php if ( hivepress()->request->get_context( 'notice_count' ) && 'messages_thread' === $key ) : ?>
									<small class="badge rounded-pill bg-primary ms-1"><?php echo esc_html( hivepress()->request->get_context( 'notice_count' ) ); ?></small>
								<?php endif; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_user_account_header_classes' ) ) {
	/**
	 * Display hivepress user account header classes.
	 */
	function finder_hivepress_user_account_header_classes() {
		$account_style = finder_hivepress_get_user_account_style();
		switch ( $account_style ) {
			case 'real-estate':
				$header_class = 'h2';
				break;
			case 'car-finder':
				$header_class = 'h2 text-light';
				break;
			case 'city-guide':
				$header_class = 'h3 mb-0';
				break;
		}
		return $header_class;
	}
}

if ( ! function_exists( 'finder_hivepress_user_delete_form' ) ) {
	/**
	 * Display hivepress vendors content.
	 */
	function finder_hivepress_user_delete_form() {

		$delete_form_args = array(
			'model'  => HivePress\Models\User::query()->get_by_id( get_current_user_id() ),
			'button' => array(
				'attributes' => array(
					'class' => array( 'btn', 'btn-primary', 'px-3', 'px-sm-4' ),
				),
			),
		);

		$delete_form = new User_Delete( $delete_form_args );
		?>
		<div class="modal fade" id="user_delete_modal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><?php esc_html_e( 'Delete Account', 'finder' ); ?></h4>
						<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'finder'); ?>"></button>
					</div>
					<div class="modal-body">
						<?php echo apply_filters( 'finder_user_delete_form_output', $delete_form->render() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

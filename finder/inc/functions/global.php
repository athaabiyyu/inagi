<?php
/**
 * Functions used globally across the theme.
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get read time in minutes.
 *
 * @param string $content Content to calculate the read time for.
 * @return int
 */
function finder_get_read_time( $content ) {
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	$minutes = round( $words / 200 );
	return $minutes;
}

/**
 * Retrives blog page permalink.
 *
 * @return string
 */
function finder_get_blog_page_permalink() {
	// If front page is set to display a static page, get the URL of the posts page.
	if ( 'page' === get_option( 'show_on_front' ) ) {
		return get_permalink( get_option( 'page_for_posts' ) );
	}

	// The front page IS the posts page. Get its URL.
	return get_home_url();
}

if ( ! function_exists( 'finder_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo
	 *
	 * @param bool $echo Echo the string or return it.
	 * @return string
	 */
	function finder_site_title_or_logo( $echo = true ) {
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$logo = get_custom_logo();
			$html = $logo;
		} else {
			$html = esc_html( get_bloginfo( 'name' ) );
			$html = '<a href="' . esc_url( home_url( '/' ) ) . '" class="navbar-brand me-3 me-xl-4" rel="home">' . $html . '</a>';
		}

		if ( ! $echo ) {
			return apply_filters( 'finder_finder_site_title_or_logo', $html, $echo );
		}

		echo apply_filters( 'finder_finder_site_title_or_logo', $html, $echo ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'finder_get_icons' ) ) {
	/**
	 * Get Finder Icons.
	 *
	 * @return array
	 */
	function finder_get_icons() {

		$icons = array(
			'none fi-alarm'                 => esc_html__( 'alarm', 'finder' ),
			'none fi-alert-circle'          => esc_html__( 'alert-circle', 'finder' ),
			'none fi-alert-octagon'         => esc_html__( 'alert-octagon', 'finder' ),
			'none fi-alert-triange'         => esc_html__( 'alert-triange', 'finder' ),
			'none fi-align-justify'         => esc_html__( 'align-justify', 'finder' ),
			'none fi-align-left'            => esc_html__( 'align-left', 'finder' ),
			'none fi-align-right'           => esc_html__( 'align-right', 'finder' ),
			'none fi-anchor'                => esc_html__( 'anchor', 'finder' ),
			'none fi-archive'               => esc_html__( 'archive', 'finder' ),
			'none fi-arrow-back-up'         => esc_html__( 'arrow-back-up', 'finder' ),
			'none fi-arrow-back'            => esc_html__( 'arrow-back', 'finder' ),
			'none fi-arrow-down'            => esc_html__( 'arrow-down', 'finder' ),
			'none fi-arrow-forward-up'      => esc_html__( 'arrow-forward-up', 'finder' ),
			'none fi-arrow-forward'         => esc_html__( 'arrow-forward', 'finder' ),
			'none fi-arrow-left'            => esc_html__( 'arrow-left', 'finder' ),
			'none fi-arrow-long-down'       => esc_html__( 'arrow-long-down', 'finder' ),
			'none fi-arrow-long-left'       => esc_html__( 'arrow-long-left', 'finder' ),
			'none fi-arrow-long-right'      => esc_html__( 'arrow-long-right', 'finder' ),
			'none fi-arrow-long-up'         => esc_html__( 'arrow-long-up', 'finder' ),
			'none fi-arrow-right'           => esc_html__( 'arrow-right', 'finder' ),
			'none fi-arrow-up'              => esc_html__( 'arrow-up', 'finder' ),
			'none fi-arrows-sort'           => esc_html__( 'arrow-sort', 'finder' ),
			'none fi-award'                 => esc_html__( 'award', 'finder' ),
			'none fi-bell-off'              => esc_html__( 'bell-off', 'finder' ),
			'none fi-bell-on'               => esc_html__( 'bell-on', 'finder' ),
			'none fi-bell'                  => esc_html__( 'bell', 'finder' ),
			'none fi-bookmark-filled'       => esc_html__( 'bookmark-filled', 'finder' ),
			'none fi-bookmark'              => esc_html__( 'bookmark', 'finder' ),
			'none fi-briefcase'             => esc_html__( 'Bbriefcase', 'finder' ),
			'none fi-building'              => esc_html__( 'building', 'finder' ),
			'none fi-calendar'              => esc_html__( 'calendar', 'finder' ),
			'none fi-calendar-alt'          => esc_html__( 'calendar-alt', 'finder' ),
			'none fi-camera-plus'           => esc_html__( 'camera Plus', 'finder' ),
			'none fi-car'                   => esc_html__( 'car', 'finder' ),
			'none fi-cart'                  => esc_html__( 'cart', 'finder' ),
			'none fi-cash'                  => esc_html__( 'cash', 'finder' ),
			'none fi-chat-circle'           => esc_html__( 'chat-circle', 'finder' ),
			'none fi-chat-left'             => esc_html__( 'chat-left', 'finder' ),
			'none fi-chat-right'            => esc_html__( 'chat-right', 'finder' ),
			'none fi-check'                 => esc_html__( 'check', 'finder' ),
			'none fi-check-circle'          => esc_html__( 'check-circle', 'finder' ),
			'none fi-checkbox'              => esc_html__( 'checkbox', 'finder' ),
			'none fi-checkbox-checked'      => esc_html__( 'checkbox-checked', 'finder' ),
			'none fi-checkbox-checked-alt'  => esc_html__( 'checkbox-checked-alt', 'finder' ),
			'none fi-chevron-down'          => esc_html__( 'chevron-down', 'finder' ),
			'none fi-chevron-left'          => esc_html__( 'chevron-left', 'finder' ),
			'none fi-chevron-right'         => esc_html__( 'chevron-right', 'finder' ),
			'none fi-chevron-up'            => esc_html__( 'chevron-up', 'finder' ),
			'none fi-chevrons-left'         => esc_html__( 'chevrons-left', 'finder' ),
			'none fi-chevrons-right'        => esc_html__( 'chevrons-right', 'finder' ),
			'none fi-clock'                 => esc_html__( 'clock', 'finder' ),
			'none fi-cloud-download'        => esc_html__( 'cloud-download', 'finder' ),
			'none fi-cloud-upload'          => esc_html__( 'cloud-upload', 'finder' ),
			'none fi-corner-down-left'      => esc_html__( 'corner-down-left', 'finder' ),
			'none fi-corner-down-right'     => esc_html__( 'corner-down-right', 'finder' ),
			'none fi-corner-left-down'      => esc_html__( 'corner-left-down', 'finder' ),
			'none fi-corner-left-up'        => esc_html__( 'corner-left-up', 'finder' ),
			'none fi-corner-right-down'     => esc_html__( 'corner-right-down', 'finder' ),
			'none fi-corner-right-up'       => esc_html__( 'corner-right-up', 'finder' ),
			'none fi-corner-up-left'        => esc_html__( 'corner-up-left', 'finder' ),
			'none fi-corner-up-right'       => esc_html__( 'corner-up-right', 'finder' ),
			'none fi-credit-card-off'       => esc_html__( 'credit-card-off', 'finder' ),
			'none fi-credit-card'           => esc_html__( 'credit-card', 'finder' ),
			'none fi-cup'                   => esc_html__( 'cup', 'finder' ),
			'none fi-dashboard'             => esc_html__( 'dashboard', 'finder' ),
			'none fi-device-desktop'        => esc_html__( 'device-desktop', 'finder' ),
			'none fi-device-laptop'         => esc_html__( 'device-laptop', 'finder' ),
			'none fi-device-mobile'         => esc_html__( 'device-mobile', 'finder' ),
			'none fi-device-tablet'         => esc_html__( 'device-tablet', 'finder' ),
			'none fi-dislike'               => esc_html__( 'dislike', 'finder' ),
			'none fi-dots-horisontal'       => esc_html__( 'dots-horisontal', 'finder' ),
			'none fi-dots-vertical'         => esc_html__( 'dots-vertical', 'finder' ),
			'none fi-download-file'         => esc_html__( 'download-file', 'finder' ),
			'none fi-download'              => esc_html__( 'download', 'finder' ),
			'none fi-edit'                  => esc_html__( 'edit', 'finder' ),
			'none fi-education'             => esc_html__( 'education', 'finder' ),
			'none fi-expand'                => esc_html__( 'expand', 'finder' ),
			'none fi-external-link'         => esc_html__( 'external-link', 'finder' ),
			'none fi-eye-off'               => esc_html__( 'eye-off', 'finder' ),
			'none fi-eye-on'                => esc_html__( 'eye-on', 'finder' ),
			'none fi-file'                  => esc_html__( 'file', 'finder' ),
			'none fi-file-clean'            => esc_html__( 'file-clean', 'finder' ),
			'none fi-filter-alt-horizontal' => esc_html__( 'filter-alt-horizontal', 'finder' ),
			'none fi-filter-alt-vertical'   => esc_html__( 'filter-alt-vertical', 'finder' ),
			'none fi-filter'                => esc_html__( 'filter', 'finder' ),
			'none fi-filter-off'            => esc_html__( 'filter-off', 'finder' ),
			'none fi-flag'                  => esc_html__( 'flag', 'finder' ),
			'none fi-flame'                 => esc_html__( 'flame', 'finder' ),
			'none fi-folder'                => esc_html__( 'folder', 'finder' ),
			'none fi-folder-minus'          => esc_html__( 'folder-minus', 'finder' ),
			'none fi-folder-off'            => esc_html__( 'folder-off', 'finder' ),
			'none fi-folder-plus'           => esc_html__( 'folder-plus', 'finder' ),
			'none fi-folder-x'              => esc_html__( 'folder-x', 'finder' ),
			'none fi-folders'               => esc_html__( 'folders', 'finder' ),
			'none fi-footer'                => esc_html__( 'footer', 'finder' ),
			'none fi-friends'               => esc_html__( 'friends', 'finder' ),
			'none fi-geo'                   => esc_html__( 'geo', 'finder' ),
			'none fi-gift'                  => esc_html__( 'gift', 'finder' ),
			'none fi-glass'                 => esc_html__( 'glass', 'finder' ),
			'none fi-globe'                 => esc_html__( 'globe', 'finder' ),
			'none fi-grid'                  => esc_html__( 'grid', 'finder' ),
			'none fi-header'                => esc_html__( 'header', 'finder' ),
			'none fi-heart-filled'          => esc_html__( 'heart-filled', 'finder' ),
			'none fi-heart'                 => esc_html__( 'heart', 'finder' ),
			'none fi-help'                  => esc_html__( 'help', 'finder' ),
			'none fi-home'                  => esc_html__( 'home', 'finder' ),
			'none fi-image'                 => esc_html__( 'image', 'finder' ),
			'none fi-info-circle'           => esc_html__( 'info-circle', 'finder' ),
			'none fi-info-square'           => esc_html__( 'info-square', 'finder' ),
			'none fi-layers'                => esc_html__( 'layers', 'finder' ),
			'none fi-like'                  => esc_html__( 'like', 'finder' ),
			'none fi-link'                  => esc_html__( 'link', 'finder' ),
			'none fi-list'                  => esc_html__( 'list', 'finder' ),
			'none fi-lock'                  => esc_html__( 'lock', 'finder' ),
			'none fi-login'                 => esc_html__( 'login', 'finder' ),
			'none fi-logout'                => esc_html__( 'logout', 'finder' ),
			'none fi-mail'                  => esc_html__( 'mail', 'finder' ),
			'none fi-man'                   => esc_html__( 'man', 'finder' ),
			'none fi-map'                   => esc_html__( 'map', 'finder' ),
			'none fi-map-pin'               => esc_html__( 'map-pin', 'finder' ),
			'none fi-map-pins'              => esc_html__( 'map-pins', 'finder' ),
			'none fi-microphone'            => esc_html__( 'microphone', 'finder' ),
			'none fi-minus'                 => esc_html__( 'minus', 'finder' ),
			'none fi-minus-circle'          => esc_html__( 'minus-circle', 'finder' ),
			'none fi-minus-square'          => esc_html__( 'minus-square', 'finder' ),
			'none fi-music'                 => esc_html__( 'music', 'finder' ),
			'none fi-paperclip'             => esc_html__( 'paperclip', 'finder' ),
			'none fi-pencil'                => esc_html__( 'pencil', 'finder' ),
			'none fi-phone'                 => esc_html__( 'phone', 'finder' ),
			'none fi-pinned'                => esc_html__( 'pinned', 'finder' ),
			'none fi-plane'                 => esc_html__( 'plane', 'finder' ),
			'none fi-play'                  => esc_html__( 'play', 'finder' ),
			'none fi-play-circle'           => esc_html__( 'play-circle', 'finder' ),
			'none fi-play-filled'           => esc_html__( 'play-filled', 'finder' ),
			'none fi-plus'                  => esc_html__( 'plus', 'finder' ),
			'none fi-plus-circle'           => esc_html__( 'plus-circle', 'finder' ),
			'none fi-plus-square'           => esc_html__( 'plus-square', 'finder' ),
			'none fi-power'                 => esc_html__( 'power', 'finder' ),
			'none fi-quote'                 => esc_html__( 'quote', 'finder' ),
			'none fi-refresh'               => esc_html__( 'refresh', 'finder' ),
			'none fi-reply'                 => esc_html__( 'reply', 'finder' ),
			'none fi-rotate-left'           => esc_html__( 'rotate-left', 'finder' ),
			'none fi-rotate-right'          => esc_html__( 'rotate-right', 'finder' ),
			'none fi-route'                 => esc_html__( 'route', 'finder' ),
			'none fi-search'                => esc_html__( 'search', 'finder' ),
			'none fi-send'                  => esc_html__( 'send', 'finder' ),
			'none fi-settings'              => esc_html__( 'settings', 'finder' ),
			'none fi-share'                 => esc_html__( 'share', 'finder' ),
			'none fi-sidebar-left'          => esc_html__( 'sidebar-left', 'finder' ),
			'none fi-sidebar-right'         => esc_html__( 'sidebar-right', 'finder' ),
			'none fi-star'                  => esc_html__( 'star', 'finder' ),
			'none fi-star-filled'           => esc_html__( 'star-fille', 'finder' ),
			'none fi-star-half'             => esc_html__( 'star-half', 'finder' ),
			'none fi-switch-horizontal'     => esc_html__( 'switch-horizontal', 'finder' ),
			'none fi-switch-vertical'       => esc_html__( 'switch-vertical', 'finder' ),
			'none fi-ticket'                => esc_html__( 'ticket', 'finder' ),
			'none fi-trash'                 => esc_html__( 'trash', 'finder' ),
			'none fi-truck'                 => esc_html__( 'truck', 'finder' ),
			'none fi-unlock'                => esc_html__( 'unlock', 'finder' ),
			'none fi-upload-file'           => esc_html__( 'upload-file', 'finder' ),
			'none fi-upload'                => esc_html__( 'upload', 'finder' ),
			'none fi-user'                  => esc_html__( 'user', 'finder' ),
			'none fi-user-check'            => esc_html__( 'user-check', 'finder' ),
			'none fi-user-minus'            => esc_html__( 'user-minus', 'finder' ),
			'none fi-user-plus'             => esc_html__( 'user-plus', 'finder' ),
			'none fi-user-x'                => esc_html__( 'user-x', 'finder' ),
			'none fi-users'                 => esc_html__( 'users', 'finder' ),
			'none fi-video-off'             => esc_html__( 'video-off', 'finder' ),
			'none fi-video'                 => esc_html__( 'video', 'finder' ),
			'none fi-wallet'                => esc_html__( 'wallet', 'finder' ),
			'none fi-woman'                 => esc_html__( 'woman', 'finder' ),
			'none fi-x'                     => esc_html__( 'x', 'finder' ),
			'none fi-x-circle'              => esc_html__( 'x-circle', 'finder' ),
			'none fi-x-square'              => esc_html__( 'x-square', 'finder' ),
			'none fi-zoom-in'               => esc_html__( 'zoom-in', 'finder' ),
			'none fi-zoom-out'              => esc_html__( 'zoom-out', 'finder' ),
			'none fi-airbnb'                => esc_html__( 'airbnb', 'finder' ),
			'none fi-behance'               => esc_html__( 'behance', 'finder' ),
			'none fi-discord'               => esc_html__( 'discord', 'finder' ),
			'none fi-dribbble'              => esc_html__( 'dribbble', 'finder' ),
			'none fi-dropbox'               => esc_html__( 'dropbox', 'finder' ),
			'none fi-facebook'              => esc_html__( 'facebook', 'finder' ),
			'none fi-facebook-square'       => esc_html__( 'facebook-square', 'finder' ),
			'none fi-foursquare'            => esc_html__( 'foursquare', 'finder' ),
			'none fi-github'                => esc_html__( 'github', 'finder' ),
			'none fi-google-drive'          => esc_html__( 'google-drive', 'finder' ),
			'none fi-google-play'           => esc_html__( 'google-play', 'finder' ),
			'none fi-google'                => esc_html__( 'google', 'finder' ),
			'none fi-hangouts'              => esc_html__( 'hangouts', 'finder' ),
			'none fi-instagram'             => esc_html__( 'instagram', 'finder' ),
			'none fi-linkedin'              => esc_html__( 'linkedin', 'finder' ),
			'none fi-medium'                => esc_html__( 'medium', 'finder' ),
			'none fi-messenger'             => esc_html__( 'messenger', 'finder' ),
			'none fi-odnoklassniki'         => esc_html__( 'odnoklassniki', 'finder' ),
			'none fi-paypal'                => esc_html__( 'paypal', 'finder' ),
			'none fi-pinterest'             => esc_html__( 'pinterest', 'finder' ),
			'none fi-rss'                   => esc_html__( 'rss', 'finder' ),
			'none fi-skype'                 => esc_html__( 'skype', 'finder' ),
			'none fi-slack'                 => esc_html__( 'slack', 'finder' ),
			'none fi-snapchat'              => esc_html__( 'snapchat', 'finder' ),
			'none fi-soundcloud'            => esc_html__( 'soundcloud', 'finder' ),
			'none fi-telegram'              => esc_html__( 'telegram', 'finder' ),
			'none fi-telegram-circle'       => esc_html__( 'telegram-circle', 'finder' ),
			'none fi-tiktok'                => esc_html__( 'tiktok', 'finder' ),
			'none fi-tumblr'                => esc_html__( 'tumblr', 'finder' ),
			'none fi-twitch'                => esc_html__( 'twitch', 'finder' ),
			'none fi-twitter'               => esc_html__( 'twitter', 'finder' ),
			'none fi-viber'                 => esc_html__( 'viber', 'finder' ),
			'none fi-vimeo'                 => esc_html__( 'vimeo', 'finder' ),
			'none fi-vk'                    => esc_html__( 'vk', 'finder' ),
			'none fi-wechat'                => esc_html__( 'wechat', 'finder' ),
			'none fi-whatsapp'              => esc_html__( 'whatsapp', 'finder' ),
			'none fi-xing'                  => esc_html__( 'xing', 'finder' ),
			'none fi-youtube'               => esc_html__( 'youtube', 'finder' ),
			'none fi-accounting'            => esc_html__( 'accounting', 'finder' ),
			'none fi-apartment'             => esc_html__( 'apartment', 'finder' ),
			'none fi-bath'                  => esc_html__( 'bath', 'finder' ),
			'none fi-bed'                   => esc_html__( 'bed', 'finder' ),
			'none fi-billboard-house'       => esc_html__( 'billboard-house', 'finder' ),
			'none fi-cafe'                  => esc_html__( 'cafe', 'finder' ),
			'none fi-cctv'                  => esc_html__( 'cctv', 'finder' ),
			'none fi-cocktail'              => esc_html__( 'cocktail', 'finder' ),
			'none fi-computer'              => esc_html__( 'computer', 'finder' ),
			'none fi-disco-ball'            => esc_html__( 'disco-ball', 'finder' ),
			'none fi-dish'                  => esc_html__( 'dish', 'finder' ),
			'none fi-double-bed'            => esc_html__( 'double-bed', 'finder' ),
			'none fi-dumbell'               => esc_html__( 'dumbell', 'finder' ),
			'none fi-entertainment'         => esc_html__( 'entertainment', 'finder' ),
			'none fi-gearbox'               => esc_html__( 'gearbox', 'finder' ),
			'none fi-hotel-bell'            => esc_html__( 'hotel-bell', 'finder' ),
			'none fi-house-chosen'          => esc_html__( 'house-chosen', 'finder' ),
			'none fi-iron'                  => esc_html__( 'iron', 'finder' ),
			'none fi-laundry'               => esc_html__( 'laundry', 'finder' ),
			'none fi-makeup'                => esc_html__( 'laundry', 'finder' ),
			'none fi-meds'                  => esc_html__( 'meds', 'finder' ),
			'none fi-museum'                => esc_html__( 'museum', 'finder' ),
			'none fi-no-smoke'              => esc_html__( 'no-smoke', 'finder' ),
			'none fi-parking'               => esc_html__( 'parking', 'finder' ),
			'none fi-pet'                   => esc_html__( 'pet', 'finder' ),
			'none fi-petrol'                => esc_html__( 'petrol', 'finder' ),
			'none fi-pie-chart'             => esc_html__( 'pie-chart', 'finder' ),
			'none fi-plant'                 => esc_html__( 'plant', 'finder' ),
			'none fi-real-estate-buy'       => esc_html__( 'real-estate-buy', 'finder' ),
			'none fi-real-estate-house'     => esc_html__( 'real-estate-house', 'finder' ),
			'none fi-rent'                  => esc_html__( 'rent', 'finder' ),
			'none fi-security'              => esc_html__( 'security', 'finder' ),
			'none fi-shop'                  => esc_html__( 'shop', 'finder' ),
			'none fi-shopping-bag'          => esc_html__( 'shopping-bag', 'finder' ),
			'none fi-single-bed'            => esc_html__( 'shopping-bag', 'finder' ),
			'none fi-snowflake'             => esc_html__( 'snowflake', 'finder' ),
			'none fi-spa'                   => esc_html__( 'spa', 'finder' ),
			'none fi-swimming-pool'         => esc_html__( 'swimming-pool', 'finder' ),
			'none fi-thermometer'           => esc_html__( 'thermometer', 'finder' ),
			'none fi-tv'                    => esc_html__( 'tv', 'finder' ),
			'none fi-wifi'                  => esc_html__( 'wifi', 'finder' ),
		);

		return $icons;
	}
}

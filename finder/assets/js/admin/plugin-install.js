/**
 * admin.js
 *
 * Handles behaviour of the theme
 */
 ( function( $, window ) {
    'use strict';

    $( document ).on( 'ready', function () {
        appendReqButtons();
    } );

    function appendReqButtons() {
        $( '.js-ocdi-gl-item' ).each( function( index ) {
            var $item         = $(this),
                name          = $item.data( 'name' ),
                $footer       = $item.find( '.ocdi__gl-item-footer' ),
                importButton  =  $item.find( '.ocdi__gl-item-button.button-primary' )[0],
                urlParams     = new URLSearchParams( $(importButton).attr( 'href' ) ),
                fileValue     = urlParams.get( 'import' ),
                txtInstall    = ocdi_params.txt_install,
                pluginProfile = ocdi_params.file_args[fileValue].plugin_profile,
                url           = ocdi_params.tgmpa_url + '&demo=' + pluginProfile;

            if ( ocdi_params.profiles[pluginProfile] && ocdi_params.profiles[pluginProfile].requires_install ) {
                $(importButton).hide();
                $(importButton).after( '<a class="ocdi__gl-item-button button button-primary" href=" ' + url + '">' + txtInstall + '</a>' );
            }
        } );
    }

} )( jQuery, window );
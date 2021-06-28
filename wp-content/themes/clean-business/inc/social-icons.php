<?php
/**
 * The template for displaying Social Icons
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */

if ( ! function_exists( 'clean_business_get_social_icons' ) ) :
/**
 * Generate social icons.
 *
 * @since Clean Business 0.1
 */
function clean_business_get_social_icons(){
	if( ( !$output = get_transient( 'clean_business_social_icons' ) ) ) {
		$output	= '';

		//Pre defined Social Icons Link Start
		$pre_def_social_icons 	=	clean_business_get_social_icons_list();

		foreach ( $pre_def_social_icons as $key => $item ) {
			$social_icon = apply_filters( 'clean_business_get_option', $key );

			if( $social_icon && '' != $social_icon ) {
				$value = $social_icon;

				if ( 'email_link' == $key  ) {
					$output .= '<a class="fa fa-'. esc_attr( $item['class'] ) .'" target="_blank" title="'. esc_attr__( 'Email', 'clean-business') . '" href="mailto:'. antispambot( sanitize_email( $value ) ) .'"><span class="screen-reader-text">'. __( 'Email', 'clean-business') . '</span> </a>';
				}
				else if ( 'skype_link' == $key  ) {
					$output .= '<a class="fa fa-'. esc_attr( $item['class'] ) .'" target="_blank" title="'. esc_attr( $item['label'] ) . '" href="'. esc_attr( $value ) .'"><span class="screen-reader-text">'. esc_attr( $item['label'] ). '</span> </a>';
				}
				else if ( 'phone_link' == $key || 'handset_link' == $key ) {
					$output .= '<a class="fa fa-'. esc_attr( $item['class'] ) .'" target="_blank" title="'. esc_attr( $item['label'] ) . '" href="tel:' . preg_replace( '/\s+/', '', esc_attr( $value ) ) . '"><span class="screen-reader-text">'. esc_attr( $item['label'] ) . '</span> </a>';
				}
				else {
					$output .= '<a class="fa fa-'. esc_attr( $item['class'] ) .'" target="_blank" title="'. esc_attr( $item['label'] ) .'" href="'. esc_url( $value ) .'"><span class="screen-reader-text">'. esc_attr( $item['label'] ) .'</span> </a>';
				}
			}
		}
		//Pre defined Social Icons Link End
		set_transient( 'clean_business_social_icons', $output, 86940 );
	}

	return $output;
} // clean_business_get_social_icons
endif;

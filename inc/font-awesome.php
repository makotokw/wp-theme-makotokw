<?php
/**
 * Font Awesome functions
 *
 * @package makotokw
 */

/**
 * @param string $slug
 * @return string
 */
function makotokw_awesome_icon_by_slug( $slug ) {
	$icon       = '';
	$icon_class = makotokw_find_awesome_icon_class( $slug );
	if ( ! empty( $icon_class ) ) {
		$icon = '<i class="' . $icon_class . '"></i> ';
	}
	return $icon;
}

/**
 * @param string $slug
 * @param string $default_value
 * @return string
 */
function makotokw_find_awesome_icon_class( $slug, $default_value = 'folder' ) {
	$map = array(
		'interior'            => 'fas fa-couch',
		'comedy'              => 'fas fa-laugh-beam',
		'gourmet'             => 'fas fa-utensils',
		'computer'            => 'fas fa-laptop',
		'computer/software'   => 'fas fa-laptop-code',
		'computer/hardware'   => 'fas fa-keyboard',
		'computer/server'     => 'fas fa-server',
		'computer/programing' => 'fas fa-code',
		'sports'              => 'fas fa-futbol',
		'lifehack'            => 'fas fa-hat-wizard',
		'work'                => 'fas fa-building',
		'politics'            => 'fas fa-landmark',
		'stationery'          => 'fas fa-pen-fancy',
		'life'                => 'fas fa-sun',
		'cinema'              => 'fas fa-film',
		'art'                 => 'fas fa-image',
		'readingbook'         => 'fas fa-book',
		'electronics'         => 'fas fa-robot',
		'music'               => 'fas fa-music',
		'gadget'              => 'fas fa-mobile-alt',
		'game'                => 'fas fa-gamepad',
	);

	if ( array_key_exists( $slug, $map ) ) {
		return $map[ $slug ];
	}

	return $default_value;
}

<?php
/*
Plugin Name: Mahjong Tiles
Plugin URI: http://www.mahjongopas.info/mahjong-tiles/
Description: This plugin adds a shortcode [tile] that can be used to display Mahjong tiles.
Version: 1.0
Author: Mikko Saari
Author URI: http://www.mikkosaari.fi/
*/

/*  Copyright 2015 Mikko Saari  (email: mikko@mikkosaari.fi)

    This file is part of Mahjong Tiles, a plugin for WordPress.

    Mahjong Tiles is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Mahjong Tiles is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Mahjong Tiles.  If not, see <http://www.gnu.org/licenses/>.
*/

add_action( 'init', 'MahjongTiles_init' );

function MahjongTiles_init() {
	if ( !shortcode_exists( 'tile' ) ) add_shortcode( 'tile', 'MahjongTiles_shortcode' );
	if ( !shortcode_exists( 'mahjongtile' ) ) add_shortcode( 'mahjongtile', 'MahjongTiles_shortcode' );
	add_action( 'admin_menu', 'MahjongTiles_menu' );
}

function MahjongTiles_shortcode( $atts ) {
	extract( shortcode_atts( array( 'tile' => NULL ), $atts ) );
	
	if ( $tile == NULL ) return "";		// No tile chosen
	
	$tile = strtolower( $tile );
	
	$plugin_image_dir = plugin_dir_path( __FILE__ ) . 'tile_images/';
	$plugin_image_url = plugin_dir_url( __FILE__ ) . 'tile_images/';
	$theme_image_dir = get_stylesheet_directory() . '/tile_images/';
	$theme_image_url = get_stylesheet_directory_uri() . '/tile_images/';

	$tile_image = NULL;
	
	$alt = MahjongTiles_altname( $tile );
	
	if ( file_exists( $plugin_image_dir . $tile . '.png' ) ) {
		$tile_image = '<img src="' . $plugin_image_url . $tile . '.png" alt="' . $alt . '" />';
	}
	
	if ( file_exists( $theme_image_dir . $tile . '.png' ) ) {
		$tile_image = '<img src="' . $theme_image_url . $tile . '.png" alt="' . $alt . '" />';
	}
	
	return $tile_image;
}

function MahjongTiles_altname( $tile ) {
	if ( $tile == 'b1' ) $alt = "1 bamboo";
	if ( $tile == 'b2' ) $alt = "2 bamboo";
	if ( $tile == 'b3' ) $alt = "3 bamboo";
	if ( $tile == 'b4' ) $alt = "4 bamboo";
	if ( $tile == 'b5' ) $alt = "5 bamboo";
	if ( $tile == 'b6' ) $alt = "6 bamboo";
	if ( $tile == 'b7' ) $alt = "7 bamboo";
	if ( $tile == 'b8' ) $alt = "8 bamboo";
	if ( $tile == 'b9' ) $alt = "9 bamboo";
	if ( $tile == 'd1' ) $alt = "1 dot";
	if ( $tile == 'd2' ) $alt = "2 dot";
	if ( $tile == 'd3' ) $alt = "3 dot";
	if ( $tile == 'd4' ) $alt = "4 dot";
	if ( $tile == 'd5' ) $alt = "5 dot";
	if ( $tile == 'd6' ) $alt = "6 dot";
	if ( $tile == 'd7' ) $alt = "7 dot";
	if ( $tile == 'd8' ) $alt = "8 dot";
	if ( $tile == 'd9' ) $alt = "9 dot";
	if ( $tile == 'c1' ) $alt = "1 character";
	if ( $tile == 'c2' ) $alt = "2 character";
	if ( $tile == 'c3' ) $alt = "3 character";
	if ( $tile == 'c4' ) $alt = "4 character";
	if ( $tile == 'c5' ) $alt = "5 character";
	if ( $tile == 'c6' ) $alt = "6 character";
	if ( $tile == 'c7' ) $alt = "7 character";
	if ( $tile == 'c8' ) $alt = "8 character";
	if ( $tile == 'c9' ) $alt = "9 character";
	if ( $tile == 'ew' ) $alt = "East wind";
	if ( $tile == 'ww' ) $alt = "West wind";
	if ( $tile == 'nw' ) $alt = "North wind";
	if ( $tile == 'sw' ) $alt = "South wind";
	if ( $tile == 's1' ) $alt = "1 season";
	if ( $tile == 's2' ) $alt = "2 season";
	if ( $tile == 's3' ) $alt = "3 season";
	if ( $tile == 's4' ) $alt = "4 season";
	if ( $tile == 'f1' ) $alt = "1 flower";
	if ( $tile == 'f2' ) $alt = "2 flower";
	if ( $tile == 'f3' ) $alt = "3 flower";
	if ( $tile == 'f4' ) $alt = "4 flower";
	if ( $tile == 'gd' ) $alt = "green dragon";
	if ( $tile == 'rd' ) $alt = "red dragon";
	if ( $tile == 'wd' ) $alt = "white dragon";
	return $alt;
}

function MahjongTiles_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	$theme_image_dir = get_stylesheet_directory() . '/tile_images/';

	$content = <<<EOH
<div class="wrap">

<h1>Mahjong Tiles</h1>

<h2>Dots: d1–d9</h2>
<p>[tile tile="d1"][tile tile="d2"][tile tile="d3"][tile tile="d4"][tile tile="d5"][tile tile="d6"][tile tile="d7"][tile tile="d8"][tile tile="d9"]</p>

<h2>Bamboos: b1–b9</h2>
<p>[tile tile="b1"][tile tile="b2"][tile tile="b3"][tile tile="b4"][tile tile="b5"][tile tile="b6"][tile tile="b7"][tile tile="b8"][tile tile="b9"]</p>

<h2>Characters: c1–c9</h2>
<p>[tile tile="c1"][tile tile="c2"][tile tile="c3"][tile tile="c4"][tile tile="c5"][tile tile="c6"][tile tile="c7"][tile tile="c8"][tile tile="c9"]</p>

<h2>Winds: ew, sw, ww, nw</h2>
<p>[tile tile="ew"][tile tile="sw"][tile tile="ww"][tile tile="nw"]</p>

<h2>Dragons: rd, gd wd</h2>
<p>[tile tile="rd"][tile tile="gd"][tile tile="wd"]</p>

<h2>Flowers: f1–f4</h2>
<p>[tile tile="f1"][tile tile="f2"][tile tile="f3"][tile tile="f4"]</p>

<h2>Seasons: s1–s4</h2>
<p>[tile tile="s1"][tile tile="s2"][tile tile="s3"][tile tile="s4"]</p>

<h2>Replacing the tiles</h2>

<p>If you want to change the tile images, you can put replacement image files in folder
<code>$theme_image_dir</code>, using the same file names as the plugin is using. Files in
theme tile image folder will be used instead of the files in plugin folder, if present.</p>

<h2>Questions, etc.</h2>

<p>Any questions can be directed at mikko@mikkosaari.fi. Additional tile set images are
also welcome.</p>

</div>
EOH;
	echo do_shortcode( $content );
}

function MahjongTiles_menu() {
	add_options_page( 'Mahjong Tiles', 'Mahjong Tiles', 'manage_options', 'mahjong-tiles', 'MahjongTiles_options' );
}

?>
<?php
/**
 * Plugin Name:       Bluerails Machine-Readable Remediation
 * Plugin URI:        https://github.com/Bluerails-2-0/bluerails-machine-readable
 * Description:       Serves /llms.txt, adds a named-AI-bot robots.txt allow-list, and enriches
 *                     Yoast's JSON-LD graph (Organization, Hotel, Restaurant, EventVenue, Event)
 *                     for AI-visibility. Built for weingut-domhof.de.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Bluerails
 * Author URI:        https://bluerails.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bluerails-machine-readable
 * Update URI:        https://github.com/Bluerails-2-0/bluerails-machine-readable
 *
 * @package Bluerails_Machine_Readable
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BLUERAILS_DHZ_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once BLUERAILS_DHZ_PLUGIN_DIR . 'includes/facts.php';
require_once BLUERAILS_DHZ_PLUGIN_DIR . 'includes/llms-txt.php';
require_once BLUERAILS_DHZ_PLUGIN_DIR . 'includes/robots.php';
require_once BLUERAILS_DHZ_PLUGIN_DIR . 'includes/schema.php';
require_once BLUERAILS_DHZ_PLUGIN_DIR . 'includes/sitemap.php';

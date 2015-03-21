<?php

/*  Copyright 2010  TODD HALFPENNY  (email : todd@gingerbreaddesign.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Plugin Name: Relevanssi Dashboard
Plugin URI: http://gingerbreaddesign.co.uk/wordpress/plugins/relevanssi-dashboard-widget.php
Description: Dashboard Widget for Relevanssi Search data.. 
Author: Todd Halfpenny
Version: 0.0.1
Author URI: http://gingerbreaddesign.co.uk/todd
*/


/* ===============================
  I N S T A L L / U P G R A D E 
================================*/

function gbd_rd_install() {
	// nothing to do this time out
}



/* ===============================
  C O R E    C O D E 
================================*/
function gbd_rd_widget() {
	echo "<div>";
	gbd_rd_date_queries(30, __("Last 30 days", 'relevanssi'));
	echo '<p><a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=relevanssi/relevanssi.php">Full Relevanssi Results</a></p>';
	echo '</div>';
}

function add_gbd_rd() {
	wp_add_dashboard_widget('gbd_rd_widget', 'Relevanssi Search - Last 30 Days', 'gbd_rd_widget');
}
add_action('wp_dashboard_setup', 'add_gbd_rd');


function gbd_rd_date_queries($d, $title) {
	global $wpdb, $log_table;
	
	$queries = $wpdb->get_results("SELECT COUNT(DISTINCT(id)) as cnt, query, hits
		  FROM $log_table
		  WHERE TIMESTAMPDIFF(DAY, time, NOW()) <= $d
		  GROUP BY query
		  ORDER BY cnt DESC
		  LIMIT 20");

	if (count($queries) > 0) {
		echo "<table class='widefat'><tbody><tr><th>Query</th><th>#</th><th>Hits</th></tr>";
		foreach ($queries as $query) {
			$url = get_bloginfo('url');
			$u_q = urlencode($query->query);
			if  (  $query->hits == 0 ) {
				echo "<tr style='font-weight:bold;'>";
			} else {
				echo "<tr>";
			}
			echo "<td style='padding: 3px 5px'><a href='$url/?s=$u_q'>" . esc_attr( $query->query ) . "</a></td><td style='padding: 3px 5px; text-align: center'>" . $query->cnt . "</td><td style='padding: 3px 5px; text-align: center'>" . $query->hits . "</td></tr>";
		}
		echo "</tbody></table>";
	}
}


?>
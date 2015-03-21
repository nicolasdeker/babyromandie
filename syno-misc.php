<?php
class csSYNOWordPressMisc {

	static function get_home_path($home, $siteurl) {

		$root_dir = '/var/services/web';
		if ( $home != '' && $home != $siteurl ) {
			$siteDomain = substr($siteurl, 0, -9);
			$home_path = $root_dir . "/" . substr($home, strlen($siteDomain)) . "/";
		} else {
			$home_path = ABSPATH;
		}

		return $home_path;
	}
}
?>

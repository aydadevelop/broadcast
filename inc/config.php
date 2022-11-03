<?php

require_once '/etc/config_couple.php';
require_once __DIR__ . '/db.php';

$siteName = 'Interactive Platforms';
$secureURL = 'https://interactiveplatforms.com';

$pageTitle = $siteName;
$pageDescription = 'Live, audience-interactive broadcasts on a global scale.';

$supportEmail = 'support@team.couple.com';

$PATH_INFO = $_SERVER['REQUEST_URI'];
$VISITORIP = $_SERVER["REMOTE_ADDR"];
$HTTP_REFERER = '';

if(isset($_SERVER['HTTP_REFERER']))
{
	$HTTP_REFERER = $_SERVER['HTTP_REFERER'];
}

?>
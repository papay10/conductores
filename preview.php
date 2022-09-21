<?php
if (!defined("ROOT_PATH"))
{
	define("ROOT_PATH", dirname(__FILE__) . '/');
}
require ROOT_PATH . 'app/config/options.inc.php';

require_once PJ_FRAMEWORK_PATH . 'pjAutoloader.class.php';
pjAutoloader::register();

if (!isset($_GET['controller']) || empty($_GET['controller']))
{
	header("HTTP/1.1 301 Moved Permanently");
}
ob_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Job Listing Script by PHPJabbers.com</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		{JL_META}
	</head>
	<body>
		<div style="max-width: 1200px;">
			{JL_LOAD}
		</div>
	</body>
</html>
<?php
if (!isset($_GET['iframe']))
{
	$content = ob_get_contents();
	ob_end_clean();
	ob_start();
}

if (!isset($_GET['controller']) || empty($_GET['controller']))
{
	$_GET["controller"] = "pjLoad";
}
if (!isset($_GET['action']) || empty($_GET['action']))
{
	$_GET["action"] = "pjActionJobs";
}
if (!isset($_GET['from_preview']) || empty($_GET['from_preview']))
{
	$_GET["from_preview"] = "1";
}
$dirname = str_replace("\\", "/", dirname(__FILE__));
include str_replace("app/views/pjLayouts", "", $dirname) . '/ind'.'ex.php';

$meta = NULL;
$meta_arr = $pjObserver->getController()->get('meta_arr');
if ($meta_arr !== FALSE)
{
	$meta = sprintf('<title>%s</title>
<meta name="keywords" content="%s" />
<meta name="description" content="%s" />
<meta property="og:type" content="Website" />
<meta property="og:title" content="%s" />
<meta property="og:description" content="%s" />
<meta property="og:url" content="%s" />
<meta property="og:image" content="%s" />
<meta name="twitter:image:src" content="%s">',
			stripslashes($meta_arr['title']),
			htmlspecialchars(stripslashes($meta_arr['keywords'])),
			!empty($meta_arr['description']) ? htmlspecialchars(stripslashes($meta_arr['description'])) : htmlspecialchars(stripslashes($meta_arr['body'])),
			stripslashes($meta_arr['og_title']),
			!empty($meta_arr['description']) ? htmlspecialchars(stripslashes($meta_arr['description'])) : htmlspecialchars(stripslashes($meta_arr['body'])),
			$meta_arr['url'],
			stripslashes($meta_arr['og_image']),
			stripslashes($meta_arr['og_image'])
	);
}
$content = str_replace('{JL_META}', $meta, $content);

if (!isset($_GET['iframe']))
{
	$app = ob_get_contents();
	ob_end_clean();
	ob_start();
	$app = str_replace('$','&#36;',$app);
	echo preg_replace('/\{JL_LOAD\}/', $app, $content);
}
?>
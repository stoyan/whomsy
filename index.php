<?php
error_reporting(E_ALL);

include 'includes/model.php';
include 'includes/view.php';

// config - types of requests the app expects and their settings
$conf = array(
	'domain' => array(),
	'api' 	 => array('nohtml' => 'true'),
	'tools'	 => array('static' => 'tools.html', 'title' => 'Tools'),
	'faq' 	 => array('static' => 'faq.html',   'title' => 'FAQ'),
	'apidoc' => array('static' => 'apidoc.html','title' => 'API Docs'),
	'home'	 => array('static' => 'home.html' , 'title' => 'Whomsy')
);

// make sense of the request
$url = parse_url($_SERVER['REQUEST_URI']);
if (empty($_REQUEST) && !empty($url['query'])){ // dreamhost quirk with phpcgi
    parse_str($url['query'], $_REQUEST);
}
$url = $url['path'];
$self = dirname($_SERVER['PHP_SELF']);
if ($self !== '/') { // app not in the server root
    $url = str_replace($self, '', $url);
    $self = $self . '/';
}
$url = ltrim($url, '/');
$request = explode('/',  $url);
if (!in_array($request[0], array_keys($conf))) {
    $request[0] = 'home';	
}

// define useful constants 
define('HOME', $self);
define('PAGEID', $request[0]); // the requested page
define('DOMAIN', (!empty($_REQUEST['domain'])) ? $_REQUEST['domain'] : @$request[1]); // domain, if any
$conf = $conf[PAGEID]; // config for the requested page


// the "business" logic
$data = WhomsyModel::getData($conf, DOMAIN);		


// render the view
WhomsyView::render($data, $conf);
?>

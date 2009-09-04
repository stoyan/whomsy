<?php
class WhomsyModel {
    
    function getData($conf, $domain = '') {

	    // is this a request for a static page?
	    if (!empty($conf['static']) && empty($domain)) {
		    return file_get_contents("includes/content/" . $conf['static']);
	    }
	    
	    // input
	    if (!$domain) {
		    return WhomsyModel::bye('I need a domain name', true);
	    }

	    // try the best to make sense of any input
	    $parts = @parse_url($domain);
	    $host = empty($parts['host']) ? $parts['path'] : $parts['host'];
    	$host = explode('/', $host);
    	$host = $host[0];
    	$host = explode('.', $host);
    	$count = count($host);
    	if ($count < 2) {
    		return WhomsyModel::bye('I need a valid domain name - like "example.org"', true);
    	}
    	$d = $host[$count-2] . '.' . $host[$count-1];

    	// execute command
    	$cmd = 'whois ' . escapeshellarg($d);
    	exec($cmd, $output, $result);
    	if ($result === 1) {
    		return WhomsyModel::bye('Error executing whois command', true);
    	}
    	$output = implode("\n", $output);
    	return WhomsyModel::bye($output);
    }

    function bye($msg, $error = false) {
    	$data = array (
    		'domain'  => DOMAIN,
    		'type'    => $error ? 'error' : 'success',
    		'message' => $msg
    	);
    	return $data;
    }
}
?>

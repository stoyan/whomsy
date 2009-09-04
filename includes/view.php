<?php
class WhomsyView {

    function render($data, $conf) {
        $output = is_array($data) ? WhomsyView::renderData($data) : $data;
        if (!empty($conf['nohtml'])) {
            echo $output;
            return;
        } 
        // manifest or not
        $manifest = '';
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone')) {
            $manifest = ' manifest="cache.manifest"';
        }
    	include 'includes/templates/page_template.php';
    }
    
    function renderData($data) {
    	if (empty($_REQUEST['output'])) {
    		$_REQUEST['output'] = (PAGEID === 'api') ? 'json' : 'html';
    	}
    	$o = $_REQUEST['output'];
	    switch($o) {
    		case 'html':
    			header('Content-Type: text/html');
    			return WhomsyView::template($o, $data);
    			break;
    		case 'xml':
    			header('Content-Type: application/xml');						
    			return WhomsyView::template($o, $data);
    			break;
    		default: // json
    			$data['message'] = htmlentities($data['message']);
    			$json = json_encode($data);
    			if (!empty($_REQUEST['callback'])) {
				    //header('application/javascript');
				    return htmlentities($_REQUEST['callback']) . '(' . $json . ')';
    			} else {
				    //header('application/json');
				    return $json;
    			}
    			break;
    	}
    }

    function template($type, $data) {	
    	$tpl = file_get_contents('includes/templates/' . $type . '.tpl');
    	$find = array('%%TYPE%%', '%%MESSAGE%%', '%%DOMAIN%%');
    	$replace = array($data['type'], htmlentities($data['message']), htmlentities($data['domain']));
    	return str_replace($find, $replace, $tpl);
    }
}
?>

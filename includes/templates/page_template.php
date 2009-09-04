<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"<?php echo $manifest; ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link type="text/css" rel="stylesheet" href="<?php echo HOME; ?>css/whomsy.css" />
	<title><?php
	if (!empty($conf['title'])) {
		echo $conf['title'] . ' / ';
	} 
	if (DOMAIN) {
		echo htmlentities(DOMAIN) . ' / ';
	}
	?>whois domain lookup</title>
<?php if (DOMAIN) { ?>
	<link rel="canonical" href="http://whomsy.com/domain/<?php echo htmlentities(DOMAIN); ?>" />
<?php } ?>
</head>
<body id="<?php echo PAGEID; ?>">
	<div id="head" role="application">
	    <h3><a href="<?php echo HOME; ?>">whomsy.com</a></h3>
	    <form action="<?php echo HOME; ?>domain/" method="get"><p>
    	    <input type="text" name="domain" id="domain-input" value="<?php echo @htmlentities(DOMAIN); ?>" />
    	    <input type="submit" value="lookup domain" /> <span class="example">e.g. example.org, w3c.org</span>
	    </p></form>
	</div>
	<div id="content" role="main" aria-live="assertive">
		<?php echo $output; ?>	
	</div>
	<div id="foot" role="navigation">
	    <ul>
		    <li class="first"><a href="<?php echo HOME; ?>apidoc" title="Documentation about the API (Application Programming Interface)">API</a></li>
		    <li><a href="<?php echo HOME; ?>tools" title="Take this service with you">Tools</a></li>
		    <li><a href="<?php echo HOME; ?>faq" title="Answers to frequently asked questions">FAQ</a></li>
		    <li><a href="mailto:whois@whomsy.com" title="Send Whomsy an email">Contact</a></li>
	    </ul>
	</div>
	<!-- JS -->
	<!--script type="text/javascript" src="http://yui.yahooapis.com/combo?3.0.0b1/build/yui/yui-min.js&3.0.0b1/build/oop/oop-min.js&3.0.0b1/build/event/event-min.js&3.0.0b1/build/event-custom/event-custom-min.js&3.0.0b1/build/attribute/attribute-min.js&3.0.0b1/build/base/base-min.js&3.0.0b1/build/dom/dom-min.js&3.0.0b1/build/node/node-min.js&3.0.0b1/build/anim/anim-base-min.js&3.0.0b1/build/anim/anim-color-min.js&3.0.0b1/build/json/json-parse-min.js&3.0.0b1/build/io/io-base-min.js"></script-->
	<script src="<?php echo HOME; ?>js/yui.js" type="text/javascript"></script>
	<script src="<?php echo HOME; ?>js/whomsy.js" type="text/javascript"></script>
	<script type="text/javascript">whomsy.service = '<?php echo HOME; ?>' + whomsy.service</script>
</body>
</html>
(function() {
    var domain = prompt('Which domain you want to look up?', location.hostname.split('.').slice(-2).join('.'));
    if (!domain) {
        return;
    }
    var url = 'http://whomsy.com/api/' + encodeURIComponent(domain) + '?callback=whomsy_callback';
    var s = document.createElement('script');
    s.src = url;
    document.body.appendChild(s);
    
    var r = document.getElementById('whomsy-result'),
        offset = window.pageYOffset ? window.pageYOffset : document.body.scrollTop,
        container_styles,
        fonts,
        hide_js, html, button, ad;            
    if (!r) {
        r = document.createElement('div');
        r.id = 'whomsy-result';
        document.body.appendChild(r);
    }
    container_styles = [
        'display:block',
        'border:10px solid #CBCCCE',
        'width:640px',
        'height:400px',
        'padding:20px',
        'overflow:scroll',
        'position:absolute',
        'z-index:1000',
        'top:' + (50 + parseInt(offset, 10)) + 'px',
        'left:' + (document.body.clientWidth - 640) / 2 + 'px',
        '-moz-border-radius: 10px',
        '-webkit-border-radius: 10px',
        'border-radius: 10px'
        ].join(';');
    fonts = [
        'background:white',
        'color:black',
        'font:12px monospace',
        'text-align:left'        
        ].join(';');
    r.style.cssText = container_styles + ';' + fonts;
    r.setAttribute('style', container_styles + ';' + fonts);
    
    hide_js = "document.getElementById('whomsy-result').style.display='none';";
    html = '<pre style="' + fonts + '">querying...</pre>';
    button = '<button style="float:right;' + fonts + '" onclick="' + hide_js + '">OK</button>';
    ad = '<br style="clear:right" /><p style="float:right;' + fonts + '">';
    ad += 'Whois lookup by <a style="' + fonts + '" href="http://whomsy.com">whomsy.com</a></p>';
    r.innerHTML = button + html + ad;    
    
    /* intentionally global */
    whomsy_callback = function(o) {
        if (typeof o !== 'object' || o.type !== 'success') {
            alert('Wacky response from the server, sorry');
            return;
        }
        var ret = [],
            pre = document.getElementById('whomsy-result').getElementsByTagName('pre')[0];
  
        ret[0] = '<h1>domain: ' + o.domain + '</h1>';
        var msg = o.message;
        // IE and <pre> :()
        msg = msg.replace(/\t/g, '    ');
        msg = msg.replace(/ /g, '&nbsp;');
        msg = msg.replace(/\n/g, '\n<br />');
        ret[1] = msg;
        pre.innerHTML = ret.join("\n");
    };
})();






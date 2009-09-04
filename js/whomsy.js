var Y = YUI().use('*');
var whomsy = {
	service: 'api/',
	cache: {},
	last_domain: '',
	in_progress: false,
	old_content: '',
	init: function() {
		this.old_content = Y.get('#content').get('innerHTML');
		Y.on('submit', this.formLookup, 'form');
        setInterval(whomsy.checkHash, 500);
	},
	formLookup: function(e) {
		e.halt();
		var input = Y.get('#domain-input');
		var domain = input.get('value');
		if (!domain) {
			alert('I need a domain name');
			input.focus();
			return;
		}
		whomsy.request(domain);
	},
	checkHash: function() {
		var hash = location.hash.replace('#', '');
		if (!whomsy.last_domain && !hash) {return;}
		if (hash === whomsy.last_domain) {return;}
		if (whomsy.in_progress) {return;}
		if (!hash) {
			whomsy.setContent(whomsy.old_content);
			whomsy.last_domain = '';
			return;
		}
		Y.get('#domain-input').set('value', hash);
		whomsy.request(hash);
	},
	request: function(domain) {
		whomsy.progress(domain);
		whomsy.last_domain = domain;
		if (whomsy.cache[domain]) { // mby it's in the cache
			whomsy.update(domain);
			return;
		}
		// cache miss, go fetch
		Y.io(whomsy.service + encodeURIComponent(domain), whomsy.callback);
	},
	callback: {
		on: {
			success: function(id, o){
				var data;
				try {
					data = Y.JSON.parse(o.responseText);
					whomsy.cache[data.domain] = data;
					whomsy.update(data.domain);					
				} catch (e) {
					alert('Nonsense response fromn the whois server :(');
					whomsy.setContent('');
				}
				whomsy.in_progress = false;
			},
			failure: function(){
				alert('Lookup failed, sorry, give it another try in a bit');
				whomsy.setContent('');
				whomsy.in_progress = false;
			}
		}	
	},
	update: function(domain) {
		var data = whomsy.cache[domain];
		var html = '<h1>' + domain + ' whois lookup</h1>';
		var needle = 'No match for &quot;' + domain.toUpperCase() + '&quot;.';
		data.message = data.message.replace(needle, '<span class="avail">' + needle + '</span>')
		html += '<div class="' + data.type + '">' + data.message + '</div>';
		whomsy.setContent(html);
		location.hash = domain;
		document.title = domain + ' / whois domain lookup';
		whomsy.in_progress = false;
	},
	progress: function(domain) {
		whomsy.in_progress = true;
		Y.get('#content').set('innerHTML', 'querying whois database for ' + domain + '...');
	},
	setContent: function(html) {
		var node = Y.get('#content');
		node.set('innerHTML', html);
		new Y.Anim({
			node: node,
			duration: 0.5,
			to: {backgroundColor: '#ffffff'},
			from: {backgroundColor: '#ffa928'}
		}).run();
	}
};
whomsy.init();

/*! GTC-WOMBAT - v1.0 - 2012-06-08
* http://www.addthis.com/
* Copyright (c) 2012 AddThis;*/

/**
* Greet Bar
* 
*/

var env = 'wordpress';

var skip;

var wom = {};
wom.log = function() {
	//console.log.apply(console,arguments);
};

var wc;


var currentPanel = false;

var followUrls = {
	googlebuzz: "http://www.google.com/profiles/%s",
	//google_follow: "https://plus.google.com/%s",
	google: "https://plus.google.com/%s",
	youtube: "http://www.youtube.com/user/%s",
	//facebook: "http://www.facebook.com/profile.php?id=%s",
	//facebook_url: "http://www.facebook.com/%s", /* temporary, til we have a fancier integration */
	facebook: "http://www.facebook.com/%s",
	rss: "%s",
	flickr: "http://www.flickr.com/photos/%s",
	foursquare: "http://foursquare.com/%s",
	instagram: "http://followgram.me/%s",
	twitter: "http://twitter.com/intent/follow?source=followbutton&variant=1.0&screen_name=%s",
	linkedin: "http://www.linkedin.com/in/%s",
	pinterest: "http://www.pinterest.com/%s",
	tumblr: "http://%s.tumblr.com",
	vimeo: "http://www.vimeo.com/%s"
};

var tracking = {
	svcCnt : 0,
	urlCnt : 0,
	svcAdd : false,
	urlAdd : false,
	msgCol : false,
	barCol : false,
	btnCol : false,
	actCol : false
};

	
	codeError = {
		follow : {
		},
		custom : {
		},
		share : {
		},
		dismiss : {
		}
	};
	serviceMap = {};
	wombat_pubid = {};
	hidden_services = ["addressbar",
    "menu",
    "facebook_comment",
    "facebook_like",
    "facebook_uncomment",
    "windows",
    "print",
    "google_plusone",
    "google_plusone_badge"];
	
	generations = 0;
	var startTime = new Date().getTime();
	setInterval(function() {
	
		var now = new Date().getTime();
		var length = (now - startTime)/1000;
		wom.log('' + (generations/length) + ' genCode calls per second');
		
	},5000);
	


    var capWord = function(s){
        return s.charAt(0).toUpperCase() + s.slice(1);
    };

	var initClipboard = function() {
		wom.log('initClipboard');
		/*Copy Button - uses swf*/
		ZeroClipboard.setMoviePath(zeroclipboardswf);
		var clip = new ZeroClipboard.Client();
		clip.setText('');
		// will be set later on mouseDown
		clip.setHandCursor(true);
		clip.setCSSEffects(true);
		clip.addEventListener('mouseDown', function(client)
		{
			// set text to copy here
			clip.setText($('#wbCode').val());
			//$('#wbCode').select();
			$('#copyfdbk3').html('&nbsp;<em>Copied</em>').show();
			setTimeout(function()
			{
				$('#copyfdbk3').fadeOut();
				}, 2500);
				trackComplete('wb');
			});
			clip.glue('copybtn3');
			$('#wbCode').live('copy cut', function()
			{
				trackComplete('wb');
			});
			$('#cpyBtnForm').hover(function()
			{
				clip.reposition();
			});
	};
	
	/**
	
		{
			name : "Facebook",
			rule : {
				service : "facebook"
			},
			config : {
				messageText : "Tell your friends about us:",
				messageTextFollow : "Connect with us on Facebook!",
				messageTextCustom : "Tell your friends about us:",
				buttonText : "Share on Facebook",
				buttonTextFollow : "Follow on Facebook",
				buttonTextCustom : "Click Here",
				buttonType: "share",
				service: "facebook"
			},
			enabled:true,
			custom:false
		},
		
		
		
		
		{
				"name": "Facebook",
				"match": {
					"referringService": "facebook"
				},
				"message": "If you enjoy this page, do us a favor:",
				"action": {
					"type": "button",
								"text": "Share on Facebook",
								"verb": "share",
								"service": "facebook"
				}
			}
	
	
	*/
	
	
	var toReal = function(fake) {
		
		//init
		var real = {};
		real.action = {};
		if('config' in fake) {
			for(var i in fake.config) {
				switch(i) {
					case 'barColor':
						real.backgroundColor = fake.config[i];
						break;
					case 'barTextColor':
						real.textColor = fake.config[i];
						break;
					case 'messageText':
						real.message = fake.config[i];
						break;
					//case ''
					case 'service':
						real.action.service = fake.config.service;
						break;
					default:
						real[i] = fake.config[i];
						break;
				}	
			}
		}
		if('enabled' in fake) {
			real.show = fake.enabled;
		}
		
		for(var i in fake) {
			switch(i) {
				case 'hideAfter':
					real.hideAfter = fake.hideAfter;
					break;
				default:
					break;
			}
			
		}
		
		
		wom.log('fake in',fake);
		
		//transfer
		real.name = fake.name;
		real.match = {};
		
		if('rule' in fake) {
			if('service' in fake.rule) {
				real.match.referringService = fake.rule.service;
				real.action.service = fake.rule.service;
			}
			if('url' in fake.rule) {
				real.match.referrer = fake.rule.url;
			}
		}
		real.action.type = 'button';
		real.action.verb = fake.config.buttonType;
		switch(real.action.verb) {
			case 'share':
				real.action.text = fake.config.buttonText;
				break;
			case 'follow':
				real.action.text = fake.config.buttonTextFollow;
				real.action.url = fake.config.buttonUrlCustom;
				break;
				
			case 'link':
				real.action.text = fake.config.buttonTextCustom;
				break;
			case 'custom':
				real.action.text = 'link';
				break;
		}
		if('show' in real) {
			fake.enabled = real.show;
		}
		
		wom.log('real out',real);
		//return
		return real;
	};
	

	var toFake = function(real) {
		
		//init
		var fake = {};
		
		//transfer
		fake.name = real.name;
		fake.rule = {};
		if('match' in real) {
			if('referringService' in real.match) {
				fake.rule.service = real.match.referringService;
			}
			if('referrer' in real.match) {
				fake.rule.url = real.match.referrer;
			}
		}
		
		fake.enabled = true;
		fake.custom = false;
		fake.config = {};
		for(var i in real) {
			switch(i) {
				case 'message':
					fake.config.messageText = real.message;
					fake.config.messageTextFollow = real.message;
					fake.config.messageTextCustom = real.message;
					break;
			}
		}
		
		if('action' in real) {
			fake.config.buttonText = real.action.text;
			fake.config.buttonTextFollow = real.action.text;
			fake.config.buttonTextCustom = real.action.text;
			fake.config.buttonType = real.action.verb;
			if(fake.config.buttonType === 'link') {
				fake.config.buttonType = 'custom';
			}
			if('id' in real.action) {
				fake.config.followIdFollow = real.action.id;
				fake.config.serviceFollow = real.action.service;
			}
			if('url' in real.action) {
				fake.config.url = real.action.url;
			}
			if(real.action.verb === 'follow') {
				
				fake.config.buttonTextCustom = real.action.text;
				fake.config.messageTextCustom = real.message;
			}
			if('url' in real.action) {
				fake.config.buttonUrlCustom = real.action.url;
			}
			if('service' in real.action) {
				fake.config.service = real.action.service;
			}
			
		}
		
		fake.config.barTextColor = real.textColor;
		fake.config.barColor = real.backgroundColor;
		fake.config.buttonColor = real.buttonColor;
		fake.config.buttonTextColor = real.buttonTextColor;

		wom.log('fake:',fake);
		return fake;
	};
	
	
	

	//Generate Code
	var genCode = function(cmp) {
        wom.log(wombat_config);
		wom.log('genCode');
		generations++;
		cmp = $('.RDcodesize input[name=codeSize]:checked').val()=='Detailed'?false:true;
		var errStr = false;
		$(wombat_config).each(function(i,o) {
			if(o.enabled && (codeError && 'follow' in codeError && 'custom' in codeError && 'share' in codeError && (codeError.follow[o.name] || codeError.custom[o.name] || codeError.share[o.name] )) && o.name!='default'){
				errStr = true;
			}
		});
		if(wombat_config[wombat_config.length-1].config.dismiss && codeError.dismiss.time)
		{
			errStr = true;
		}
	var a = [];
	var renderRule = {
	};
	wom.log(wombat_config);
	wom.log(getServiceIndex());
	var svcName = wombat_config[getServiceIndex()].name;
	$(wombat_config).each(function()
	{
		var o = {
		},
		cfg = this.config,
		type = cfg.buttonType=="share"?"":cfg.buttonType=="follow"?"Follow":"Custom";
		o.name = this.name;
		o.match = clone(this.rule);
		if(o.match.url)
		{
			o.match.referrer = o.match.url;
			delete o.match.url;
		}
		if(o.match.service)
		{
			o.match.referringService = o.match.service;
			delete o.match.service;
		}
		o.message = cfg['messageText'+type];
		o.action =	{
			type:"button",
			text:cfg["buttonText"+type],
			verb:(cfg.buttonType=='custom'?'link':cfg.buttonType)
		};
		if(cfg.service)o.action.service = cfg.service;
		if(o.name == "default")
		{
			o.backgroundColor = cfg.barColor;
			o.buttonColor = cfg.buttonColor;
			o.textColor = cfg.barTextColor;
			o.buttonTextColor = cfg.buttonTextColor;
			if(cfg.dismiss) o.hideAfter = parseInt(cfg.dismissTime,10);
		}
		if(cfg.buttonType=="follow")
		{
			o.action.id = cfg.followIdFollow;
			o.action.service = cfg.serviceFollow;
		}
		if(cfg.buttonType=="custom")
		{
			o.action.url = cfg.buttonUrlCustom;
			delete o.action.service;
		}
		if(o.name==svcName)
		{
			renderRule=clone(o);
			delete renderRule.match;
		}
		if(o.match.referringService=='preferred'||o.match.url=='preferred') delete o.match;
		if((o.action||{
			}).service=='any')o.action.service="preferred";
			if(this.enabled)
			{
				a.push(o);
			}
		});
		var def = toReal(wombat_default),
		code = "";
		if(a[a.length-1].name=='All visitors')
		{
			var any = a.pop();
			delete any.match;
			a.unshift(any);
		}
		if(a.length === 0)
		{
			$('#wbCode').val('Please select at least one rule.');
			return;
		}
		delete def.name;
		delete def.message;
		delete def.action;
		if(addthis.bar && addthis.bar.initialize && addthis.bar.apply)
		{
			addthis.bar.initialize(def,[renderRule]);
			if(typeof addthis.bar.version === 'undefined' || addthis.bar.version >= 1.1)
			{
				addthis.bar.render();
			}
		}
		if(env !== 'wordpress') {
			code += "<!-- AddThis Welcome BEGIN -->\n";
			code += '<script type="text/javascript" src="'+addthis_widget_path+'#pubid='+($('#pub').val()||wombat_pubid)+'"></script>\n';
			code += "<script type='text/javascript'>\n";
			code += "addthis.bar.initialize(";
		}
		code += "{'default':";

		code += JSON.stringify(def,null,"\t");
	//	code += cmp?JSON.stringify(def):JSON.stringify(def,null,"\t");
		code += ",rules:";

		code += JSON.stringify(a,null,"\t");
		code += '}';
	//	code += cmp?JSON.stringify(a):JSON.stringify(a,null,"\t");
		if(env !== "wordpress") {
			code += "\n</script>\n";
			code += '<!-- AddThis Welcome END -->';
		}
		
	if(errStr)
	{
		$('.copyLabel').css('color','red');
		$('.copyLabel').text('Resolve errors to get updated code');
	}
	else
	{
		$("#wbCode").val(code);
		$('.copyLabel').css('color','#424242');
		$('.copyLabel').text('');
	}
};

	//Force checks to beginning state
	var resetChecks = function()
{
	$(wombat_config).each(function(i,o)
	{
		wom.log(o.name);
		wom.log(o.enabled);
		if(o.enabled)
		{
			wom.log('setting input ' + i + ' to on');
			if($('.wbcMainLt :input')[i]) {
				
				$('.wbcMainLt :input')[i].checked = true;
			}
		}
		else
		{
			
			if($('.wbcMainLt :input')[i]) {
				wom.log('setting input ' + i + ' to off');
				$('.wbcMainLt :input')[i].checked = false;
			}
		}
	});
};

	var clone = function(obj)
	{
		var copy, attr;
		// Handle the 3 simple types, and null or undefined
		if (null === obj || "object" !== typeof obj) return obj;
		if (obj instanceof Array)
		{
			copy = [];
			for (attr in obj)
			{
				if (obj.hasOwnProperty(attr)) copy[attr] = clone(obj[attr]);
			}
			return copy;
		}
		// Handle Object
		if (obj instanceof Object)
		{
			copy = {
			};
			for (attr in obj)
			{
				if (obj.hasOwnProperty(attr)) copy[attr] = clone(obj[attr]);
			}
			return copy;
		}
		return null;
	};

	//utility function
	var validateUrl = function(s)
	{
		//return new RegExp('ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?').test(s);
		return true;
	};

	var trackPageView = function(p)
	{
		if (typeof gaPageTracker != "undefined") gaPageTracker._trackPageview(p);
	};

	var trackComplete = function(action)
	{
		// check if this pub already got the code
		if (alreadyGotCode('welcome', $('#pub').val()) === false)
		{
			// track combination
			$.get('/get/combo?metric=welcome&type=welcome&where=welcome&welcome=');
			// track that this pub got the code
			trackGotTheCode('welcome', $('#pub').val());
			trackPageView('/tracker/gtc/welcome?svcadd='+tracking.svcAdd+(tracking.svcAdd?'&count='+tracking.svcCnt:''));
			trackPageView('/tracker/gtc/welcome?urladd='+tracking.urlAdd+(tracking.urlAdd?'&count='+tracking.urlCnt:''));
			trackPageView('/tracker/gtc/welcome?msgcol='+($('#messageColor').val()=="#CCCCCC"?"false":("true&nmsgcol="+$('#messageColor').val())));
			trackPageView('/tracker/gtc/welcome?barcol='+($('#barColor').val()=="#464646"?"false":("true&nbarcol="+$('#barColor').val())));
			trackPageView('/tracker/gtc/welcome?btncol='+($('#buttonColor').val()=="#098DF4"?"false":("true&nbtncol="+$('#buttonColor').val())));
			trackPageView('/tracker/gtc/welcome?actcol='+($('#buttonTextColor').val()=="#FFFFFF"?"false":("true&nactcol="+$('#buttonTextColor').val())));
			// track event
			if (typeof gaPageTracker != "undefined") gaPageTracker._trackEvent('Site', 'GTC - Welcome Complete', action);
			if (atsgat.success) atsgat.success();
		}
	};

	//Update the visible configs with our stored data
	var initOpts = function(rule,initiator) {
		wom.log('initOpts',rule);
		if(!rule.enabled)
		{
			//$('.optionsDiv span').css('color', 'blue !important');
			$('.optionsDiv').find('div').find('span').css('color','gray');
			$('.optionsDiv').find('input,select').attr('disabled','disabled');
			$('.addthis_bar_container').css('display','none');
			$('.wbcWhoSel').css('color','#098DF4');
		}
		else
		{
			$('.optionsDiv').find('div').find('span').css('color','#424242');
			$('.optionsDiv').find('input,select').removeAttr('disabled');
			$('.addthis_bar_container').css('display','block');
		}

		skip = (rule.name == current_selection && initiator != "select") ? true : false;

		if(!skip) {
			current_selection=rule.name;
		}

		if(rule.rule.url)
		{
			$('#previewLabel').text(rule.rule.url=="preferred"?"<span style='text-transform:lowercase'>any other social service</span>":rule.rule.url);
			$('#optionsLabel').text(rule.rule.url=="preferred"?"<span style='text-transform:lowercase'>any other social service</span>":rule.rule.url);
		}
		else
		{
			$('#btnType option[value=share]').show();
			$('#btnType option[value=follow]').show();
			$('#previewLabel').html(rule.rule.service=="preferred"?"<span style='text-transform:lowercase'>any other social service</span>":rule.rule.service);
			$('#optionsLabel').html(rule.rule.service=="preferred"?"<span style='text-transform:lowercase'>any other social service</span>":rule.rule.service);
		}
		$('#btnType').val(rule.config.buttonType);
		wom.log('button type is...',rule.config.buttonType);
		switch(rule.config.buttonType)
		{
			case("share"):
				initShareOpts(rule);
				break;
			case("follow"):
				initFollowOpts(rule);
				break;
			case("custom"):
				initCustomOpts(rule);
				break;
			default:
				//err
				break;
		}
		genCode();
	};

	var initShareOpts = function(rule) {
		wom.log('initShareOpts',rule);
		codeError.follow[rule.name]=codeError.custom[rule.name]=false;
		if(!codeError.share[rule.name])
		{
			$('.wbcWhoSel').css('color','#098DF4');
		}
		if(!skip)
		{
			$('#welcomeMsg').val((rule.config||{
				}).messageText||"");
			$('#btnTxt').val((rule.config||{
				}).buttonText||"");
		}
		$('.followDrop').hide();
		$('.optionsUrl').hide();
		$('.optionsId').hide();
	};

	var initFollowOpts = function(rule) {
		wom.log('initFollowOpts',rule);
		codeError.share[rule.name]=codeError.custom[rule.name]=false;
		if(!skip) {
			$('#welcomeMsg').val((rule.config||{
				}).messageTextFollow||"");
			$('#btnTxt').val((rule.config||{
				}).buttonTextFollow||"");
			$('#followId').val(rule.config.followIdFollow||"");
			$('#followSelect').val(rule.config.serviceFollow?rule.config.serviceFollow:followUrls[rule.rule.service]?rule.rule.service:"twitter");
		}
		$('.followDrop').css('display','inline-block');
		$('.optionsId').css('display','inline-block');
		$('.optionsUrl').hide();
		$('#followLabel').html($('#followSelect').val()!='rss'?($('#followSelect').val()+' Username:'):"RSS Feed URL");
		if(rule.enabled && $('#followId').val().length<2) {
			$('#followLabel').css('color','red');
			$('.wbcWhoSel').css('color','red');
			codeError.follow[rule.name]=true;
		} else {
			if(rule.enabled)$('#followLabel').css('color','#424242');
			$('.wbcWhoSel').css('color','#098DF4');
				codeError.follow[rule.name]=false;
		}
	};

	var initCustomOpts = function(rule) {
		wom.log('initCustomOpts',rule);
		codeError.share[rule.name]=codeError.follow[rule.name]=false;
		if(!skip){
			wom.log('adding the damn thing');
			wom.log(rule.config);
			$('#welcomeMsg').val((rule.config||{
			}).messageTextCustom||"");
			$('#btnTxt').val((rule.config||{
			}).buttonTextCustom||"");
			$('#btnUrl').val((rule.config||{
			}).buttonUrlCustom||"");
		}
		$('.optionsUrl').css('display','inline-block');
		$('.followDrop').hide();
		$('.optionsId').hide();
		if(rule.enabled && $('#btnUrl').val().length<3) {
				$('#urlLabel').css('color','red');
				$('.wbcWhoSel').css('color','red');
				codeError.custom[rule.name]=true;
		} else {
			if(rule.enabled) {
				$('#urlLabel').css('color','#424242');
			}
			$('.wbcWhoSel').css('color','#098DF4');
			codeError.custom[rule.name]=false;
		}
		if(rule.enabled && !validateUrl($('#btnUrl').val())) {
			$('#urlLabel').css('color','red');
			$('#urlValError').css('display','inline-block');
			$('.wbcWhoSel').css('color','red');
			codeError.custom[rule.name]=true;
		} else {
			if(rule.enabled) {
				$('#urlLabel').css('color','#424242');
			}
			$('#urlValError').hide();
			$('.wbcWhoSel').css('color','#098DF4');
			codeError.custom[rule.name]=false;
		}
	};

	var addthisBarReadyHandler = function(evt)
	{
		addthis.bar.initialize({ 'backgroundColor': '#000', 'rememberHide': false});
		addthis.addEventListener('addthis.bar.ready', function()
		{
//			if($('#wbRules').children().first().find('span').html() === ' All visitors') {
				$('#wbRules').children()[0].click(); //sorry!
//			} else {
//				$('#wbRules').children()[0].click(); //sorry!
//			}
			
		});
	};

	var recordInput = function(id, name) {
		switch($('#btnType').val())
		{
			case("share"):
			wombat_config[getServiceIndex()].config[name] = $("#"+id).val();
			break;
			case("follow"):
			wombat_config[getServiceIndex()].config[name+"Follow"] = $("#"+id).val();
			break;
			case("custom"):
			wombat_config[getServiceIndex()].config[name+"Custom"] = $("#"+id).val();
			break;
		}
		
		initOpts(wombat_config[getServiceIndex()]);
	};

	var defineConfig = function() {
        wc = (typeof window.wombat_config != 'undefined') ? window.wombat_config : {} ;
		/* Define wombat_config
		*/
		wom.log(wc);
		//wombat_config = [];
		
		wom.log(wc['default']);
		wombat_default = {};
		if('default' in wc) {
			wombat_default = toFake(wc['default']);
		} else {
			wombat_default.config = {
				barColor : "#464646",
				barTextColor : "#CCC",
				buttonColor : "#098DF4",
				buttonTextColor : "#FFF"
			};
		}
		
		wombat_config_original = [
		{	
			name : "All visitors",
			rule : {
				service : "preferred"
			},
			config : {
				messageText : "If you enjoy this page, do us a favor:",
				messageTextFollow : "We're on {{service}}, too!",
				messageTextCustom : "If you enjoy this page, do us a favor:",
				buttonText : "Click Here",
				buttonTextFollow : "Follow",
				buttonTextCustom : "Click Here",
				buttonType : "share",
				dismiss : false,
				service : "preferred"
			},
			enabled:true,
			custom:false
		},
		{

			name : "Twitter",
			rule : {
				service : "twitter"
			},
			config : {
				messageText : "If you find this page helpful:",
				messageTextFollow : "We're on Twitter, too!",
				messageTextCustom : "If you find this page helpful:", 
				buttonText : "Tweet it!",
				buttonTextFollow : "Follow",
				buttonTextCustom : "Click Here",
				buttonType: "share",
				service: "twitter"
			},
			enabled:true,
			custom:false
		},
		{
			name : "Facebook",
			rule : {
				service : "facebook"
			},
			config : {
				messageText : "Tell your friends about us:",
				messageTextFollow : "Connect with us on Facebook!",
				messageTextCustom : "Tell your friends about us:",
				buttonText : "Share on Facebook",
				buttonTextFollow : "Follow on Facebook",
				buttonTextCustom : "Click Here",
				buttonType: "share",
				service: "facebook"
			},
			enabled:true,
			custom:false
		},
		{
			name : "Google",
			rule : {
				url : "google.com"
			},
			config : {
				messageText : "If you like this page, let Google know:",
				messageTextFollow : "If you like this page, let Google know:",
				messageTextCustom : "If you like this page, let Google know:",
				buttonText : "+1",
				buttonTextFollow : "+1",
				buttonTextCustom : "+1",
				buttonType : "share",
				service : "google_plusone_share"
			},
			enabled:true,
			custom:false
		}];
		
		if(!$.isEmptyObject(wombat_config)) {
			wombat_config = [];
			var i;
			for(i in wc.rules) {
				wombat_config.push(toFake(wc.rules[i]));
			}
			for(i in wombat_config_original) {
				var originalName = wombat_config_original[i].name;
				var foundName = false;
				for(var j in wombat_config) {
					var name = wombat_config[j].name;
					if(name === originalName) {
						foundName = true;
						break;
					}
				}
				if(!foundName) {
					wombat_config_original[i].enabled = false;
					wombat_config.splice(i,0,wombat_config_original[i]);
				}	
			}
		} else {
			wombat_config = wombat_config_original;
		}
		

			
			var hidden_services = ["addressbar",
			"menu",
			"facebook_comment",
			"facebook_like",
			"facebook_uncomment",
			"windows",
			"print",
			"google_plusone",
			"google_plusone_badge"],
			
			wombat_pubid = "",
			current_selection = "",
			
			codeError = {
				follow : {
				},
				custom : {
				},
				share : {
				},
				dismiss : {
				}
			};
			/* end define wombat_config
			*/	
	};
	
	var initColorPicker = function() {
		wom.log('initColorPicker',wombat_default.config);
		$('#barColor').val(wombat_default.config.barColor);
		$('#messageColor').val(wombat_default.config.barTextColor);
		$('#buttonColor').val(wombat_default.config.buttonColor);
		$('#buttonTextColor').val(wombat_default.config.buttonTextColor);
		
		//$('#barColor').val()
		
		//Control: Color Picker 
		$(".color-picker").miniColors({
			letterCase: 'uppercase',
			change: function(hex, rgb)
			{
				
				wombat_default.config.barColor = $('#barColor').val();
				wombat_default.config.barTextColor = $('#messageColor').val();
				wombat_default.config.buttonColor = $('#buttonColor').val();
				wombat_default.config.buttonTextColor = $('#buttonTextColor').val();
				genCode();
			}
		});
	};

	var initDismissalTime = function() {
		wom.log('initDismissalTime');
	
		var isNumber = function(keyCode) {
			return(! (charCode > 31 && (charCode < 48 || charCode > 57)) );
		};
	


		
		if(typeof wc !== 'undefined' && 'default' in wc && 'hideAfter' in wc['default']) {
			$("#CBdisT").attr('checked','checked');
			$("#TBdisT").val(wc['default'].hideAfter)
		}
		
		//Control: Dismissal Time Enabler
		
		var changeHideAfter = function() {
			

			//var checked = $("#CBdisT").attr('checked');
			//if(typeof checked !== 'undefined' && checked === 'checked') {
			if ($('#CBdisT').is(':checked')) {
				var hideAfter = parseInt($("#TBdisT").val());
				if(hideAfter === NaN) {
					return;
				}
				if(hideAfter) {
					wombat_default.hideAfter = hideAfter;
				}
			} else {
				if('hideAfter' in wombat_default) {
					delete wombat_default.hideAfter;
				}
			}
			
			genCode();
			
		}
		
		$("#CBdisT").click(changeHideAfter);
		$("#TBdisT").change(changeHideAfter);
		changeHideAfter();
	
	};
	
	var initFormElements = function() {
		wom.log('initFormElements');
		initDismissalTime();
	
		//Control: Welcome Message Text
		$("#welcomeMsg").keyup(function()
		{
			recordInput("welcomeMsg","messageText");
			$("#welcomeMsg").focus();
		});
		//Control: Button Text
		$("#btnTxt").keyup(function()
		{
			recordInput("btnTxt","buttonText");
			$("#btnTxt").focus();
		});
		//Control: Button Url
		$("#btnUrl").keyup(function()
		{
			recordInput("btnUrl","buttonUrl");
			$("#btnUrl").focus();
		});
		$("#followSelect").change(function()
		{
			wombat_config[getServiceIndex()].config.serviceFollow = $('#followSelect').val();
			initOpts(wombat_config[getServiceIndex()]);
		});
		//Control: FollowId
		$("#followId").keyup(function()
		{
			wombat_config[getServiceIndex()].config.serviceFollow = $('#followSelect').val();
			recordInput("followId","followId");
			$("#followId").focus();
		});

		//Control: Button Type
		$('#btnType').change(function()
		{
			wombat_config[getServiceIndex()].config.buttonType = $(this).val();
			initOpts(wombat_config[getServiceIndex()],"select");
		});
		//Control: Code Block
		$('#wbCode').click(function() {
			//$('#wbCode').select();
			return false;
		});
		//Control: Follow Service Select
		$('#followSelect').change(function() {
			wombat_config[getServiceIndex()].config.service = $(this).val();
			initOpts(wombat_config[getServiceIndex()],"select");
		});
	
	
	};
	
	var whoPanelsClick = function(e) {
		var index;
		var target;
		var currentPanel = false;
		//assign target
		if(typeof e.srcElement === 'undefined') {
			if(typeof e.target === 'undefined') {
				currentPanel = 0;
			} else {
				target = e.target;
			}
		} else {
			target = e.target;
		}
		
                if (!Array.prototype.indexOf)
                {
                  Array.prototype.indexOf = function(elt /*, from*/)
                  {
                    var len = this.length >>> 0;

                    var from = Number(arguments[1]) || 0;
                    from = (from < 0)
                         ? Math.ceil(from)
                         : Math.floor(from);
                    if (from < 0)
                      from += len;

                    for (; from < len; from++)
                    {
                      if (from in this &&
                          this[from] === elt)
                        return from;
                    }
                    return -1;
                  };
                }
		//derive index if above didnt fail to find a target.
		if(typeof currentPanel !== 'number') {
			if(e.target.tagName === 'SPAN') {
				target = target.parentNode;
			}
			currentPanel = Array.prototype.indexOf.call(target.parentNode.children, target);

		}
		
		$(".wbcWhoSel").removeClass("wbcWhoSel").addClass("wbcWho");
		$(this).removeClass("wbcWho").addClass("wbcWhoSel");
		index = $(this).index()+1;
		initOpts(wombat_config[currentPanel]);
		
	};
	
	var renderWhoPanels = function() {
		wom.log('renderWhoPanels');
		
		$('#wbRules').empty();
		
		//Control: Who panels
		for(var i in wombat_config) {
			addRuleToWho(wombat_config[i]);
		}
		
	};

	var initWhoPanels = function() {
		wom.log('initWhoPanels');
	
		renderWhoPanels();
		
		$('#wbRules div').unbind('click',whoPanelsClick);
		$('#wbRules div').click(whoPanelsClick);

	
	};

	var initWhoPanelInputs = function() {
		//Control: Who panel inputs
		wom.log('initWhoPanelInputs');
		
		
		
		var whoInputDelegate = function() {

			var index = this.nodeName == "INPUT"?$(this).parent().index():$(this).index();
			wom.log('whoInputDeleaget index: ' + index);
			var svc = wombat_config[index];
			wombat_config[index].enabled = !svc.enabled;
			initOpts(wombat_config[index]);
		};
		
		$("#wbRules div input").unbind("click",whoInputDelegate);
		
		$("#wbRules div input").bind("click",whoInputDelegate);
	};

	var initNewServiceListener = function() {
	
		//Control: Add New Service
		$('.wbcAdd').click(function()
		{
			//Get rid of existing
			$(wombat_config).each(function(i,o)
			{
				if(o.rule.service)
				{
					$("#serviceSelect option[value='"+o.rule.service+"']").remove();
				}
			});
			$('#lightbox-panel').focus();
			$(hidden_services).each(function(i,o)
			{
				$("#serviceSelect option[value='"+o+"']").remove();
			});
			$("#lightbox, #lightbox-panel").fadeIn(300);
			
		});
	
	};
	
	var initLightBox = function() {
		$("a#close-panel").click(function()
		{
			$("#lightbox, #lightbox-panel").fadeOut(300);
		});
		$('#lightbox').click(function()
		{
			$("#lightbox, #lightbox-panel").fadeOut(300);
		});
		$('#lightbox-panel').blur(function()
		{
			$("#lightbox, #lightbox-panel").fadeOut(300);
		});
	};

	var initPopupTabNav = function() {
	
		//Control: Popup Tab Nav
		$(".lb-inner .tabs a").click(function()
		{
			var tab = parseInt(this.className.split('wbPopTabs')[1],10);
			$(".lb-inner .tabs a").removeClass("tab-active");
			$(this).addClass("tab-active");
			$(".wbPopMain div").each(function()
			{
				this.style.display = "none";
			});
			$(".wbPopMain").children()[tab].style.display = "block";
		});
	
	};

	var addServiceVisitor = function() {
		$("#BTwbpopsvc").click(function() {
			var svc = $("#serviceSelect").val();
			$(".wbcWhoSel").removeClass("wbcWhoSel").addClass("wbcWho");
			$("#wbRules").append('<div class="wbcWhoSel"><input type="checkbox" val="'+svc+'" checked="true" /><span class="welcomeNavName">'+$("#serviceSelect>option:selected").text()+'</span></div>');
			var newrule = {
				name : svc,
				rule : {
					service : svc
				},
				config : {
					messageText : "If you enjoy this page, do us a favor:",
					messageTextFollow : "We're on "+$("#serviceSelect>option:selected").text()+", too!",
					messageTextCustom: "If you enjoy this page, do us a favor:",
					buttonText : "Post on "+$("#serviceSelect>option:selected").text(),
					buttonTextFollow : "Follow us",
					buttonTextCustom : "Click Here",
					buttonType: "share",
					service : svc
				},
				enabled:true,
				custom:true
			};
			
			//wombat_config.splice(wombat_config.length-1,0,newrule);
			wombat_config.push(newrule);
			wom.log(wombat_config);
			initOpts(newrule);
			$("#lightbox, #lightbox-panel").fadeOut(300);
			genCode();
			
			initWhoPanels();
			initWhoPanelInputs();
			$('#wbRules').children().last().click();
			tracking.svcAdd = true;
			tracking.svcCnt += 1;
			resetChecks();
			
		});
	};

	var addUrlTextBoxListener = function() {
	
		//Control: Add url text box
		$("#urlSelect").focus(function()
		{
			if($('#urlSelect').val()=="ex: abcnews.com"||$('#urlSelect').val()=="Please enter an URL first."||$('#urlSelect').val()=="There is already a rule for this URL")$('#urlSelect').val("");
		});
		$("#urlSelect").keypress(function(e)
		{
			var code = e.which;
			if(code==13)
			{
				e.preventDefault();
				if($("#urlSelect").val() in {"Please enter an URL first.":1,"ex: abcnews.com":1,"There is already a rule for this URL":1})
				{
					$("#urlSelect").val("");
					return;
				}
				$("#BTwbpopurl").click();
				
				return false;
			}
		});
	
	};

	var addUrlVisitorListener = function() {
	
		//Control: Add url visitor
		$("#BTwbpopurl").click(function() {
			var url = $("#urlSelect").val(),
				dup = false;
			if(url in {"Please enter an URL first.":1,"ex: abcnews.com":1,"There is already a rule for this URL":1
			}||url === "")
			{
				$("#urlSelect").val("Please enter an URL first.");
				return;
			}
			$(wombat_config).each(function(i,o)
			{
				if(o.rule.url)
				{
					if($("#urlSelect").val().trim()==o.rule.url)
					{
						$("#urlSelect").val("There is already a rule for this URL");
						dup = true;
						return;
					}
				}
			});
			if(dup) {
				return;
			}
			$(".wbcWhoSel").removeClass("wbcWhoSel").addClass("wbcWho");
			$("#wbRules").append('<div class="wbcWhoSel"><input type="checkbox" val="'+url+'" checked="true" /><span class="welcomeNavName">'+$("#urlSelect").val()+'</span></div>');
			var newrule = {
				name : url,
				rule : {
					url : url
				},
				config : {
					buttonUrl: url,
					messageText : "If you enjoy this page, do us a favor:",
					messageTextFollow : "If you enjoy this page, do us a favor:",
					messageTextCustom: "If you enjoy this page, do us a favor:",
					buttonText : "Click Here",
					buttonTextFollow : "Follow us",
					buttonTextCustom : "Click Here",
					buttonType: "share"
				},
				enabled:true,
				custom:true
			};
			wombat_config.push(newrule);
			initOpts(newrule);
			//wombat_config.splice(wombat_config.length-1,0,newrule);
			
			$("#lightbox, #lightbox-panel").fadeOut(300);
			genCode();
			
			initWhoPanels();
			initWhoPanelInputs();
			$('#wbRules').children().last().click();
			tracking.urlAdd = true;
			tracking.urlCnt += 1;
			resetChecks();
		});
	
	};
	
	var initCodeBox = function() {
	
		//Control: Compress Code
		$("#codeCmp").click(function()
		{
			genCode(true);
		});
	
		//Control: Uncompress Code
		$("#codeBig").click(function()
		{
			genCode(false);
		});
	
	};

	var initProfileChangeListener = function() {
	
		//Control: Profile change
		$('#pub').change(function()
		{
			genCode();
		});
	
	};

	var checkForPub = function() {
		if($('#pub option').size()>1) {
			wombat_pubid = $('#pub').val();
			$('.wbcWhoFtrHide').css('display','block');
		}
	};

	var getServiceIndex = function() {

		if(!$('.wbcWhoSel').length) {
			$('.wbcWho').first().click();
			return 0;
		} else {
			return $('.wbcWhoSel').index();
		}
	};

	var init = function() {

		//map services to their config object
		serviceMap = {
			'twitter':0,
			'facebook':1,
			'google':2,
			'other':3
		};
		
	var loadServices = function() {
		window.loadServices = function(response) {
			wom.log('loadServices!');
		        var svc = document.getElementById("serviceSelect");
		        window.serviceList = [];
		        if((response||{}).data) {
		            for (var i = 0; i < response.data.length; i++) {
		                var el = document.createElement('option');
		                el.value = response.data[i].code;
		                el.innerHTML = response.data[i].name;
		                svc.appendChild(el);
		                window.serviceList[response.data[i].code] = response.data[i].name;
		            } 
		        }
		    };
		startServiceCheck();
	};
	
	
	var defineTemplates = function() {
		//a rule
		Jaml.register('rule-title', function(rule) {
			if(!rule.referringService) {
				rule = toReal(rule);
			}
		  div({cls:'wbcWho'},
			input({type:'checkbox',checked: 'true', id:'CB' + rule.match.referringService, value:rule.match.referringService}), //leaving the rule logic for the moment.. rule should be match I think
			span(' ' + rule.name)
			);
		});	
	};
	
	addRuleToWho = function(rule) {
		rule = Jaml.render('rule-title', rule);
		$('#wbRules').append(rule);	
	};
	
	var testWhoPanelRender = function() {
		
		var test = Jaml.render('rule-title', {
				"name": "Twitter",
				"match": {
					"referringService": "twitter"
				},
				"action": {
					"type": "button"
				}
			});		
		$('#wbRules').append(test);
	};
		
		current_selection = '';

		if (typeof wombat_config !== 'undefined') {
			defineConfig();
			defineTemplates();
			//testWhoPanelRender();
		
			initOpts(wombat_config[0]);	
			
			initColorPicker();
			initDismissalTime();
			initFormElements();
			initWhoPanels();
			initWhoPanelInputs();
			initNewServiceListener();
			initLightBox();
			initPopupTabNav();
			addServiceVisitor();
			resetChecks();
			addUrlTextBoxListener();
			addUrlVisitorListener();
			initCodeBox();
			initProfileChangeListener();
			checkForPub();
			loadServices();
		
			addthis.addEventListener('addthis.ready', addthisBarReadyHandler);
		}
	};
	
$ = jQuery;
$(document).ready(function() {
	init();
	$('#submit-button').click(function() {
		var all_checkboxes = $('#wbRules input[type="checkbox"]');
		if (all_checkboxes.filter(":checked").length == 0) {
			$('#rules-error').show();
			return false;
		}
		else {
			return true;
		}
	});
	
});



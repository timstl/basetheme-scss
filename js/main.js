/* adjust sizes to match bootstrap sizes */
var _ssm_settings = { 
	tablet_min: 768,
	desktop_min: 992
};

var _bt_mobile_run = false;
var _bt_tablet_run = false;
var _bt_tablet_or_bigger_run = false;
var _bt_desktop_run = false;

(function(){
	ssm.addState({
		id: 'mobile',
		query: '(max-width: ' + (parseInt(_ssm_settings.tablet_min, 10) - 1) + 'px)',
		onEnter: function()
		{ 
			runMobile(); 
		}
	});
	
	ssm.addState({
		id: 'tablet',
		query: '(min-width: ' + parseInt(_ssm_settings.tablet_min, 10) + 'px) and (max-width: ' + (parseInt(_ssm_settings.desktop_min, 10) - 1) + 'px)',
		onEnter: function() 
		{ 
			runTablet();
			runTabletOrBigger(); 
		}
	});
	
	ssm.addState({
		id: 'desktop',
		query: '(min-width: ' + parseInt(_ssm_settings.desktop_min, 10) + 'px)',
		onEnter: function() 
		{ 
			runDesktop();
			runTabletOrBigger(); 
		}
	});
}());

/* mobile */
function runMobile() {
	if (!_bt_mobile_run)
	{ 
		_bt_mobile_run = true;
	}
}

/* tablet */
function runTablet() {
	if (!_bt_tablet_run)
	{ 
		_bt_tablet_run = true;
	}
}

/* tablet or bigger */
function runTabletOrBigger() {
	if (!_bt_tablet_or_bigger_run)
	{ 
		_bt_tablet_or_bigger_run = true;
	}	
}

/* desktop */
function runDesktop() {
	if (!_bt_desktop_run)
	{ 
		_bt_desktop_run = true;
		
		/* jQuery(document).ready(function($) { }); */
	}
}

/* all sizes */
jQuery(document).ready(function($) { });
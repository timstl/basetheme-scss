/* adjust sizes to match _settings.scss */
var _ssm_settings = { 
	tablet_min: 768,
	desktop_min: 960
};

var _bt_menu_run = false;
var _bt_mobile_run = false;
var _bt_tablet_run = false;
var _bt_tablet_or_bigger_run = false;
var _bt_desktop_run = false;

(function(){
	ssm.addState({
		id: 'mobile',
		maxWidth: parseInt(_ssm_settings.tablet_min) - 1,
		onEnter: function()
		{ 
			initMobileMenu();
			runMobile(); 
		}
	});
	
	ssm.addState({
		id: 'tablet',
		minWidth: parseInt(_ssm_settings.tablet_min),
		maxWidth: parseInt(_ssm_settings.desktop_min) - 1,
		onEnter: function() 
		{ 
			initMobileMenu();
			runTablet();
			runTabletOrBigger(); 
		}
	});
	
	ssm.addState({
		id: 'desktop',
		minWidth: parseInt(_ssm_settings.desktop_min),
		onEnter: function() 
		{ 
			closeMobileMenu();
			runDesktop();
			runTabletOrBigger(); 
		}
	});

	ssm.ready();
}());

/* hamburger menu */
function initMobileMenu() {	
	if (!_bt_menu_run) {
		
		_bt_menu_run = true;
		
		jQuery(document).ready(function($) {			
			 var $mainnav = $('#main-nav-container');
			 	 
			 $('#mobmenu').on('click', function(e) 
			 {				 
				 e.preventDefault();
				 $mainnav.toggleClass('open');
			 });
		});
	}
}

function closeMobileMenu() {
	jQuery(document).ready(function($) {
		$('#main-nav-container').removeClass('open');
	});
}

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
(function(){
    ssm.addState({
        id: 'mobile',
        maxWidth: 767,
        onEnter: function()
        { 
        	runMobile(); 
        }
    });

    ssm.addState({
        id: 'tablet',
        minWidth: 768,
        maxWidth: 959,
        onEnter: function() 
        { 
        	runTablet();
        	runTabletOrBigger(); 
        }
    });

    ssm.addState({
        id: 'desktop',
        minWidth: 960,
        onEnter: function() 
        { 
			runDesktop();
        	runTabletOrBigger(); 
        }
    });

    ssm.ready();
}());


function initMobileMenu()
{
	jQuery(document).ready(function($)
	{
		 // mobile nav
		 var $mainnav = $('#main-nav-container');
		 	 
		 $('#mobmenu').on('click', function(e) 
		 {
			 e.preventDefault();
			 $mainnav.toggleClass('open');
		 });
	});
}

/* mobile */
var mobile_run = false;
function runMobile()
{
	if (!mobile_run)
	{ 
		mobile_run = true;
		initMobileMenu();
	}
}

/* tablet */
var tablet_run = false;
function runTablet()
{
	if (!tablet_run)
	{ 
		tablet_run = true;
		initMobileMenu();
	}
}

/* tablet or bigger */
var tablet_or_bigger_run = false;
function runTabletOrBigger()
{
	if (!tablet_or_bigger_run)
	{ 
		tablet_run = true;
	}	
}

/* desktop */
var desktop_run = false;
function runDesktop()
{
	if (!desktop_run)
	{ 
		desktop_run = true;
		
		jQuery(document).ready(function($)
		{
			
		});
	}
}

/* all sizes */
jQuery(document).ready(function($)
{

});
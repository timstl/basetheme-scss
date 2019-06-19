/**
 * jQuery plugin to monitor scroll distance and add class to an element after document scrolls to a position.
 * This is used for sticky headers, primarily. The "scorlled" state can then be styled in CSS.
 */
( function( $ ) {
	$.fn.scrollclass = function( options ) {
		var opts = $.extend({}, $.fn.scrollclass.defaults, options ),
			$this = this,
			state2 = false;

		$( document )
			.scroll( function() {
				if ( false == state2 && $( this ).scrollTop() > opts.pos ) {
					state2 = true;
					$this.addClass( opts.class );
				} else if ( $( this ).scrollTop() < opts.pos ) {
					state2 = false;
					$this.removeClass( opts.class );
				}
			})
			.trigger( 'scroll' );
	};

	// default options
	$.fn.scrollclass.defaults = {
		class: 'scrolled',
		pos: 50
	};
}( jQuery ) );

/**
 * Use scrollclass plugin on #header if it exists.
 */
jQuery( document ).ready( function( $ ) {
	const $header = $( '#header' );
	if ( 0 < $header.length ) {
		$header.scrollclass({
			pos: $header.outerHeight()
		});
	}
});

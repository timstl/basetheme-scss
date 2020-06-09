// Avoid `console` errors in browsers that lack a console.
// eslint-disable-next-line no-console
if ( ! ( window.console && console.log ) ) {
	( function() {
		const noop = function() {};
		const methods = [
			'assert',
			'clear',
			'count',
			'debug',
			'dir',
			'dirxml',
			'error',
			'exception',
			'group',
			'groupCollapsed',
			'groupEnd',
			'info',
			'log',
			'markTimeline',
			'profile',
			'profileEnd',
			'markTimeline',
			'table',
			'time',
			'timeEnd',
			'timeStamp',
			'trace',
			'warn',
		];
		let length = methods.length;
		const console = ( window.console = {} );
		while ( length-- ) {
			console[ methods[ length ] ] = noop;
		}
	}() );
}

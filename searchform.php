<?php
/**
 * Template for displaying search forms in Twenty Seventeen
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

?>

<?php
/**
 * In case there is more than 1 search form on a page.
 */
$unique_id = esc_attr( uniqid( 'search-form-' ) );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text"><?php _e( 'Search for:', 'basetheme' ); ?></span>
	</label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php _e( 'Search &hellip;', 'basetheme' ); ?>" value="<?php esc_attr_e( get_search_query() ); ?>" name="s" />
	<button type="submit" class="search-submit"><?php _e( 'Search', 'basetheme' ); ?></button>
</form>

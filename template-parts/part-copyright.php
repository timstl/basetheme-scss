<?php
/**
 * Output copyright with dynamic year.
 */
?>
<?php if ( function_exists( 'get_field' ) && get_field( 'footer_copyright', 'options' ) ) : ?>
<span class="copyright">
	<?php echo str_ireplace( '%year%', date( 'Y' ), get_field( 'footer_copyright', 'options' ) ); ?>
</span>
<?php endif; ?>

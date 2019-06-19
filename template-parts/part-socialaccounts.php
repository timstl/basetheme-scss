<?php
/**
 * Display social icons from ACF fields.
 */
?>
<?php if ( function_exists( 'have_rows' ) && have_rows( 'social_accounts', 'options' ) ) : ?>
<ul class="social">
	<?php
	while ( have_rows( 'social_accounts', 'options' ) ) :
		the_row();
		?>
	<li>
		<a href="<?php the_sub_field( 'url' ); ?>" target="_blank" aria-label="<?php the_sub_field( 'accessibility_text' ); ?>"><?php the_sub_field( 'icon' ); ?></a>
	</li>
	<?php endwhile; ?>
</ul>
<?php endif; ?>

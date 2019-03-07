<?php
/**
 * The template for displaying portfolio content
 *
 * @package Catch_Wheels
 */
?>

<?php
$enable_content = get_theme_mod( 'catch_wheels_portfolio_option', 'disabled' );

if ( ! catch_wheels_check_section( $enable_content ) ) {
	// Bail if portfolio content is disabled.
	return;
}
	$portfolio_posts = catch_wheels_get_posts( 'portfolio' );

	if ( empty( $portfolio_posts ) ) {
		return; 
	}

	$title     = get_option( 'jetpack_portfolio_title', esc_html__( 'Portfolio', 'catch-wheels' ) );
	$sub_title = get_option( 'jetpack_portfolio_content' );

$layout = 'layout-four';
?>

<div class="portfolio-section section">
	<div class="wrapper">
		<?php if ( '' !== $title || $sub_title ) : ?>
			<div class="section-heading-wrapper">
				<?php if ( '' !== $title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $title ); ?></h2>
					</div><!-- .page-title-wrapper -->
				<?php endif; ?>

				<?php if ( $sub_title ) : ?>
					<div class="section-description">
						<?php echo wp_kses_post( $sub_title ); ?>
					</div><!-- .section-description -->
				<?php endif; ?>
			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper <?php echo esc_attr( $layout ); ?>">

			<?php
				foreach ( $portfolio_posts as $post ) {
					setup_postdata( $post );
					// Include the portfolio content template.
					get_template_part( 'template-parts/portfolio/content', 'portfolio' );
				}

				wp_reset_postdata();
			
			?>

				<?php
				$target = get_theme_mod( 'catch_wheels_portfolio_target' ) ? '_blank': '_self';
				$link   = get_theme_mod( 'catch_wheels_portfolio_link', '#' );
				$text   = get_theme_mod( 'catch_wheels_portfolio_text', esc_html__( 'View All', 'catch-wheels' ) );

				if ( $text ) :
			?>
			<p class="view-all-button">
				<span class="more-button"><a class="more-link" target="<?php echo $target; ?>" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $text ); ?></a></span>
			</p>
			<?php endif; ?>
		</div><!-- .portfolio-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #portfolio-section -->

<?php
	 do_action( 'ncm_before_single_product' );
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		do_action( 'ncm_before_single_product_summary' );
	?>

	<div class="summary entry-summary">

		<?php
        do_action( 'ncm_single_product_summary' );
		?>

	</div>

	<?php
		do_action( 'ncm_after_single_product_summary' );
	?>

</div>

<?php do_action( 'ncm_after_single_product' ); ?>

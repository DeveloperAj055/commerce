<?php 

    // echo "<pre>";
    // $ncm_cart = $_COOKIE['NCM_Cart'];
    // $ncm_cart = stripslashes($ncm_cart);
    // print_r(json_decode($ncm_cart));
    // echo "</pre>";

    // global $ncm_narnoo_helper; 
    // //73/489?startDate=20-03-2018&endDate=24-03-2018&id=WT:330653:12
    // $api_response = $ncm_narnoo_helper->ncm_product_availability( '73', '489', 'WT:330653:12');
    // print_r(json_encode($api_response));

    // wp_get_post_parent_id( 228 );
    ?>


<?php get_header( 'ncm' ); ?>

    <?php do_action( 'ncm_before_main_content' ); ?>
    
    <?php while ( have_posts() ) : the_post(); ?>
    
            <?php  global $ncm_narnoo_helper, $post;
            // echo "<pre>"; 
            // print_r($post->narnoo_data);
            // echo "</pre>";

            // $bookingcode_arr = $post->narnoo_data->bookingData->bookingCodes;

            // echo "<pre>"; 
            // print_r($bookingcode_arr[0]->id);
            // echo "</pre>";

            // $post_id      = $post->ID;
            // echo 'op_id';
            // $op_id        = get_post_meta( $post_id, "narnoo_operator_id", true);
            // echo 'product_id';
            // $product_id   = get_post_meta( $post_id, "narnoo_product_id", true);
            // echo 'booking_id';
            // $booking_id   = get_post_meta( $post_id, "narnoo_booking_id", true);exit;
            //$availablitiy = $ncm_narnoo_helper->ncm_product_details( );
             ?>

            <h3><?php echo $post->post_title; ?></h3>
           <?php ncm_get_template("content-single-product"); ?>

    <?php endwhile; ?>

    <?php do_action( 'ncm_after_main_content' ); ?>

    <?php do_action( 'ncm_get_sidebar' ); ?>

<?php get_footer( 'ncm' ); ?>
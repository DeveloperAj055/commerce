<?php get_header( 'ncm' ); ?>

    <?php do_action( 'ncm_before_main_content' ); ?>
    <div class="entry">
        <header class="entry-header">
            <h1 class="page-title"><?php _e('shops', NCM_txt_domain); ?></h1>
        </header>
        
        <div class="entry-content">
            <div style = "min-width:100%; display:inline-block;" >
                <div style="width:40%; display:inline-block; float:left;" >
                <?php echo do_shortcode( '[ncm_search_product]' ); ?>
                </div>
            
                <div class="ncm_product_list" style="width: 60%; display:inline-block;">  
                    <?php 
                        $products = new WP_Query( array('posts_per_page'=>12,
                            'post_type'=>'narnoo_product',
                            'post_status' => 'publish',
                            'paged' => get_query_var('paged') ? get_query_var('paged') : 1) 
                        ); 
                        while ( $products->have_posts() ) : $products->the_post(); ?>
            
                            <div class="col-xs-12 col-lg-3">
                                
                                <a href="<?php echo get_post_permalink(); ?>">
                                    <div class="ncm_img_wrapper">
                                        <?php echo ncm_get_product_image( $post ); ?>
                                    </div>
                                    <h6 class="ncm_product_listing_link">
                                        <?php the_title(); ?>    
                                    </h6>
                                </a>
                                <?php //the_content(); ?>
                            </div>
                            
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                    <div class="nrm-pagination">
                        <?php
                        $big = 999999999; // need an unlikely integer
                         echo paginate_links( array(
                            'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                            'format' => '?paged=%#%',
                            'current' => max( 1, get_query_var('paged') ),
                            'total' => $products->max_num_pages
                        ) );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php do_action( 'ncm_after_main_content' ); ?>

    <?php do_action( 'ncm_get_sidebar' ); ?>
    
<?php get_footer( 'ncm' ); ?>
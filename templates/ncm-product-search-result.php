<div class="row" style="padding-top:20px !important">
 <div class="grid_12">
   <?php 

   /*$args = array(
    'post_type' => 'narnoo_product',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order'   => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'parent_post_id',
        'value' => $attractions_id
        )
      )
    );

   $product = new WP_Query($args);*/

   if ($product->have_posts()) { 

    ?>
    <h4>View Products</h4>
    <hr/>
    <?php

    while ($product->have_posts()) {
      $product->the_post();
      $post_id = get_the_ID();
      $price = get_post_meta($post_id, 'product_min_price', true);
      echo '<div class="row">';
      echo '<div class="col-md-6">';
      echo '<span class="linked_product_title"><a href="'. get_the_permalink() .'">'. get_the_title(). '</a></span><br/>';
      echo '</div>';
      echo '<div class="col-md-3">';
      if(!empty($price)){
        echo 'Price From: $'. $price;
      }
      echo '</div>';
      echo '<div class="col-md-3">';
      echo '<a href="'. get_the_permalink() .'">View Details</a>';
      echo '</div>';
      echo '</div>';
    }
    echo '<div><em>Price subject to change on availability.</em></div>';

    wp_reset_postdata();
  }

  ?>

</div>
</div>
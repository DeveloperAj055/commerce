<?php

if( !class_exists ( 'NCM_Shortcode' ) ) {



    class NCM_Shortcode {



        function __construct(){

        

            add_action( 'pre_get_posts', array( $this, 'ncm_product_post_query') );

        

            add_shortcode( "ncm_search_product", array( $this, "ncm_search_product_func" ) ); 

        

            add_shortcode( "ncm_product_availability", array( $this, "ncm_product_availability_func" ) );

        

            add_shortcode( "ncm_cart", array( $this, "ncm_cart_html_func") );



            add_shortcode( "ncm_checkout", array( $this, "ncm_checkout_html_func") );



            add_shortcode( "ncm_order", array( $this, "ncm_order_html_func") );

        

            add_shortcode( "ncm_cart_item", array( $this, "ncm_cart_item_func") );



            add_shortcode( "ncm_product_search", array( $this, "ncm_product_search_func" ) );



            add_action( "wp_ajax_ncm_product_search", array($this, "ncm_product_search_result") );



            add_action( "wp_ajax_nopriv_ncm_product_search", array($this, "ncm_product_search_result") );



        }



        function ncm_product_search_result( ) {



            global $wpdb;

            $post = $wpdb->prefix . 'posts';

            $post_meta = $wpdb->prefix . 'postmeta';



            $select = "SELECT ".$post.".ID FROM ".$post;

            $where = " WHERE co_posts.post_type = 'narnoo_product' ";



            if( isset($_REQUEST['ncm_search']) && !empty($_REQUEST['ncm_search']) ) {

                $keyword = $_REQUEST['ncm_search'];

                $where.= " AND post_title like '%".$keyword."%' ";

                $where.= " AND post_excerpt like '%".$keyword."%' ";

            }



            if( isset($_REQUEST['ncm_attractions_id']) && !empty($_REQUEST['ncm_attractions_id']) ) {

                $attraction_id = $_REQUEST['ncm_attractions_id'];

                $select.= " INNER JOIN ".$post_meta." as m1 ON ( co_posts.ID = m1.post_id )";

                $where.= " AND ( m1.meta_key='parent_post_id' AND m1.meta_value='".$attraction_id."' ) ";

            }



            /* For match exact start and end time 

            if( isset($_REQUEST['ncm_start_time']) && !empty($_REQUEST['ncm_start_time']) ) {

                $start_time = date("H:i:s", strtotime($_REQUEST['ncm_start_time']));

                $select.= " INNER JOIN ".$post_meta." as m2 ON ( co_posts.ID = m2.post_id )";

                $where.= " AND ( m2.meta_key='narnoo_product_start_time' AND m2.meta_value<='".$start_time."' ) ";

            }



            if( isset($_REQUEST['ncm_end_time']) && !empty($_REQUEST['ncm_end_time']) ) {

                $end_time = date("H:i:s", strtotime($_REQUEST['ncm_end_time']));

                $select.= " INNER JOIN ".$post_meta." as m3 ON ( co_posts.ID = m3.post_id )";

                $where.= " AND ( m3.meta_key='narnoo_product_end_time' AND m3.meta_value>='".$end_time."' ) ";

            } */





            if( ( isset($_REQUEST['ncm_start_time']) && !empty($_REQUEST['ncm_start_time']) ) || ( isset($_REQUEST['ncm_end_time']) && !empty($_REQUEST['ncm_end_time']) ) ) {

                $start_time = date("H:i:s", strtotime($_REQUEST['ncm_start_time']));

                $end_time = date("H:i:s", strtotime($_REQUEST['ncm_end_time']));



                $time_where = ( !empty($_REQUEST['ncm_start_time']) ) ? " AND TIME(m2.meta_value) >= '".$start_time."'" : '';

                $time_where.= ( !empty($_REQUEST['ncm_end_time']) ) ? " AND TIME(m2.meta_value) <= '".$end_time."'" : '';



                $select.= " INNER JOIN ".$post_meta." as m2 ON ( co_posts.ID = m2.post_id )";

                $where.= " AND ( m2.meta_key='narnoo_product_start_time' " . $time_where . " ) ";

            }



            $query = $select . $where . " GROUP BY co_posts.ID ORDER BY co_posts.post_title ASC";

            $data = $wpdb->get_col( $query );



            if( !empty($data) ) {

                $args = array(

                        'post_type'      => 'narnoo_product',

                        'posts_per_page' => -1,

                        'orderby'        => 'title',

                        'order'          => 'ASC',

                        'post__in'       => $data

                    );



                $field_data = array();

                $field_data['product'] = new WP_Query($args);



                $content = ncm_get_template_content("ncm-product-search-result", $field_data);



                $data = array( "status" => "success", "content" => $content);

                echo json_encode($data);

                die;

            } else {

                $content = '<div class="ncm_no_product msg"><center> No products found.</center></div>';

                $data = array( "status" => "success", "content" => $content);

                echo json_encode($data);

                die;

            }

        }



        function ncm_product_search_func( $atts = array(), $content = "" ) {

            global $ncm_controls;



            $atts = shortcode_atts( array(

                'search' => 'true',

                'date' => 'true',

            ), $atts );





            $attractions = get_queried_object();

            $attraction_id = $attractions->ID;



            $field_data = array();



            if( $atts['search'] == 'true' ) {

                $field_data['ncm_search'] = $ncm_controls->ncm_control(

                                        array(

                                            "type" => "text",

                                            "value" => "",

                                            "placeholder" => "",

                                            "name" => "ncm_search",

                                            "class" => "ncm_search form-control",

                                            "style" => "padding: 6px 5px;"

                                        )

                                    );

            }



            if( $atts['date'] == 'true' ) {

                $field_data['ncm_start_time'] = $ncm_controls->ncm_control(

                                        array(

                                            "type" => "text",

                                            "value" => "",

                                            "placeholder" => "",

                                            "name" => "ncm_time",

                                            "class" => "ncm_start_time form-control ncm_timepicker",

                                            "style" => "padding: 6px 5px;"

                                        )

                                    );

                $field_data['ncm_end_time'] = $ncm_controls->ncm_control(

                                        array(

                                            "type" => "text",

                                            "value" => "",

                                            "placeholder" => "",

                                            "name" => "ncm_time",

                                            "class" => "ncm_end_time form-control ncm_timepicker",

                                            "style" => "padding: 6px 5px;"

                                        )

                                    );

            }



            $args = array(

                    'post_type' => 'narnoo_product',

                    'posts_per_page' => -1,

                    'orderby' => 'title',

                    'order'   => 'ASC',

                    'meta_query' => array(

                        array(

                            'key' => 'parent_post_id',

                            'value' => $attraction_id

                        )

                    )

                );

            $products = new WP_Query($args);



            $product_data = array();

            $product_data['product'] = $products;



            $content.= '<div class="ncm_container" style="position: relative;">';

            if( $products->post_count > 7 ) { // condition for check if no of product more than 7 then display filter fileds 

                $content.= '<input type="hidden" name="ncm_attractions_id" id="ncm_attractions_id" class="ncm_attractions_id" value="'.$attraction_id.'">';

                $content.= ncm_get_template_content("ncm-product-search", $field_data);

            }

            $content.= '<div class="ncm_product_list" id="ncm_product_list" >';

            $content.= ncm_get_template_content("ncm-product-search-result", $product_data);

            $content.= '</div>';

            

            $content.= '<div id="ncm_container_loader" class="hide" >';

            $content.= '<div class="ncm_container_loader"><i class="ncm_fa ncm_fa-spinner ncm_fa-spin ncm_fa-4x ncm_prc_avl"></i></div>';

            $content.= '</div>';



            $content.= '</div>';





            return $content;

        }



        function ncm_cart_item_func( $atts = array(), $content = "" ) {

            global $ncm_cart, $ncm_payment_gateways;

            $atts = shortcode_atts( array(

                'type' => 'count',



                'link_text' => '',

                'if_cart_empty' => 'true'



            ), $atts );        

            $cart_total_item = count( $ncm_cart->ncm_get_cart_products() );

            if( $atts['type'] == 'link' ) {

                $cart_link = $ncm_payment_gateways->ncm_get_cart_page_link();



                $link_content = '<a href="' . $cart_link . '" class="ncm_cart_item_link">' . html_entity_decode( $atts['link_text'] );

                $link_content.= (!empty($cart_total_item)) ? '<span class="ncm_cart_total" >' . $cart_total_item . '</span>' : '';

                $link_content.= '</a>';

                if( $atts['if_cart_empty'] == 'true' ) {

                    $content.= $link_content; 

                } else if( $ncm_cart->ncm_get_cart_products() ) {

                    $content.= $link_content;

                }



            } else if( $atts['type'] == 'count' ) {



                $content = $cart_total_item;



            }

            return $content;

        }



        function ncm_product_post_query( $query ) {



            global $wpdb;

            $post = $wpdb->prefix . 'posts';



            // For shortcode of ncm_search_product search 

            if(isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'narnoo_product' /*&& get_post_type() == 'narnoo_product' */) {



                $query_research = isset($query->query_vars['s']) ? $query->query_vars['s'] : '';

                $query_meta_query = isset($query->query_vars['meta_query']) ? $query->query_vars['meta_query'] : '';



                $meta_query = array();



                $attraction_query = array();

                if( isset($_REQUEST['ncm_category']) && !empty($_REQUEST['ncm_category']) ) {

                    foreach ($_REQUEST['ncm_category'] as $value) {

                        $select = "SELECT ".$post.".ID FROM ".$post;

                        $where = " WHERE co_posts.post_type = 'narnoo_".$value."' ";

                        $parent_post_id = $wpdb->get_col( $select . $where );

                        if( !empty($parent_post_id) ) {

                            $attraction_query[] = array(

                                'key' => 'parent_post_id',

                                'value' => $parent_post_id,

                                'compare'   => 'IN',

                            );

                        }

                    }

                }



                if( isset($_REQUEST['ncm_attraction']) && !empty($_REQUEST['ncm_attraction']) ) {

                    foreach ($_REQUEST['ncm_attraction'] as $value) {

                        $attraction_query[] = array(

                            'key' => 'parent_post_id',

                            'value' => $value,

                            'compare' => '='

                        );

                    }

                }



                if( !empty($attraction_query) ){

                    $meta_query[] = array( 'relation' => 'OR', $attraction_query );

                }



                

                if( isset($_REQUEST['ncm_start_time']) && !empty($_REQUEST['ncm_start_time']) ) {

                    $meta_query[] = array(

                        array(

                            'key' => 'narnoo_product_start_time',

                            'value' => date("H:i:s", strtotime($_REQUEST['ncm_start_time'])),

                            'compare' => '>='

                        )

                    );

                }



                if( isset($_REQUEST['ncm_end_time']) && !empty($_REQUEST['ncm_end_time']) ) {

                    $meta_query[] = array(

                        array(

                            'key' => 'narnoo_product_start_time',

                            'value' => date("H:i:s", strtotime($_REQUEST['ncm_end_time'])),

                            'compare' => '<='

                        )

                    );

                }                 



                /* For match exact start and end time 



                if( isset($_REQUEST['ncm_start_time']) && !empty($_REQUEST['ncm_start_time']) ) {

                    $meta_query[] = array(

                        array(

                            'key' => 'narnoo_product_start_time',

                            'value' => date("H:i:s", strtotime($_REQUEST['ncm_start_time'])),

                            'compare' => '='

                        )

                    );

                }



                if( isset($_REQUEST['ncm_end_time']) && !empty($_REQUEST['ncm_end_time']) ) {

                    $meta_query[] = array(

                        array(

                            'key' => 'narnoo_product_end_time',

                            'value' => date("H:i:s", strtotime($_REQUEST['ncm_end_time'])),

                            'compare' => '='

                        )

                    );

                } */



                if( isset($_REQUEST['ncm_price']) && !empty($_REQUEST['ncm_price']) ) {

                    $price_arr = explode('-', $_REQUEST['ncm_price']);

                    $min_price = str_replace('$', '', $price_arr[0]);

                    $max_price = str_replace('$', '', $price_arr[1]);

                    $meta_query[] = array(

                        array(

                            'key' => 'product_min_price',

                            'value' => $min_price,

                            'type' => 'numeric',

                            'compare' => '>='

                        )

                    );

                    $meta_query[] = array(

                        array(

                            'key' => 'product_min_price',

                            'value' => $max_price,

                            'type' => 'numeric',

                            'compare' => '<='

                        )

                    );

                }



                // set search field

                if( isset( $_REQUEST['ncm_search'] ) && !empty( $_REQUEST['ncm_search'] ) && empty($query_research) ) {

                    $query->set( 's', $_REQUEST['ncm_search'] );

                }



                // set search meta

                if( !empty( $meta_query ) ) {

                    $query->set( 'meta_query', $meta_query );

                }

            }

        }



        function ncm_search_product_func ( $atts = array(), $content = "" ) {

            global $wpdb, $ncm_controls, $ncm_attraction, $ncm_template_loader;



            $action = $field = '';

            $attractions = $ncm_attraction->ncm_get_attraction();

            $ncm_categroies = get_option( 'narnoo_custom_post_types', array() );

            $ncm_max_price = $wpdb->get_var("SELECT max(cast(meta_value as unsigned)) FROM `".$wpdb->prefix ."postmeta` where meta_key = 'product_min_price'" ); 



            if( !$ncm_template_loader->ncm_product_listing ) {

                $action = get_site_url();

                $field = $ncm_controls->ncm_control(

                            array(

                                "type" => "hidden",

                                "value" => "narnoo_product",

                                "name" => "post_type",

                            )

                        );

            }



            $defaule_atts = array(

                "date_picker" => true,

                "category" => true,

                "attraction" => true,

            );



            $field_data = array();



            $field_data['ncm_search'] = $ncm_controls->ncm_control(

                                    array(

                                        "type" => "text",

                                        "value" => ( isset($_REQUEST['ncm_search']) && !empty($_REQUEST['ncm_search']) ) ? $_REQUEST['ncm_search'] : '',

                                        "placeholder" => "",

                                        "name" => "ncm_search",

                                        "class" => "ncm_search form-control",

                                        "style" => "padding: 6px 5px;"

                                    )

                                );



            $field_data['ncm_start_time'] = $ncm_controls->ncm_control(

                                    array(

                                        "type" => "text",

                                        "value" => ( isset($_REQUEST['ncm_start_time']) && !empty($_REQUEST['ncm_start_time']) ) ? $_REQUEST['ncm_start_time'] : '',

                                        "placeholder" => "",

                                        "name" => "ncm_start_time",

                                        "class" => "ncm_start_time form-control ncm_timepicker",

                                        "style" => "padding: 6px 5px;"

                                    )

                                );

            

            $field_data['ncm_end_time'] = $ncm_controls->ncm_control(

                                    array(

                                        "type" => "text",

                                        "value" => ( isset($_REQUEST['ncm_end_time']) && !empty($_REQUEST['ncm_end_time']) ) ? $_REQUEST['ncm_end_time'] : '',

                                        "placeholder" => "",

                                        "name" => "ncm_end_time",

                                        "class" => "ncm_end_time form-control ncm_timepicker",

                                        "style" => "padding: 6px 5px;"

                                    )

                                );



            $ncm_value = '[0,'.$ncm_max_price.']';

            $price = '$0 - '.$ncm_max_price;

            if( isset($_REQUEST['ncm_price']) && !empty($_REQUEST['ncm_price']) ){

                $price = $_REQUEST['ncm_price'];

                $price_arr = explode('-', $_REQUEST['ncm_price']);

                $min_price = str_replace('$', '', $price_arr[0]);

                $max_price = str_replace('$', '', $price_arr[1]);   

                $ncm_value = '['.$min_price.','.$max_price.']';

            }

            $ncm_price.= '<input type="text" id="ncm_price" name="ncm_price" value="'.$price.'" readonly data-ncm_max_price = "'.$ncm_max_price.'" data-ncm_value="'.$ncm_value.'">';

            $ncm_price.= '<div id="slider-range"></div>';

            $field_data['ncm_price'] = $ncm_price;





            $selected_category = isset($_REQUEST['ncm_category']) ? $_REQUEST['ncm_category'] : '';

            $ncm_categroies_html = '';

            foreach ($ncm_categroies as $cat_key => $cat_value) {

                $slug = isset( $cat_key ) ? $cat_key : $cat_key;

                $checked = ( !empty($selected_category) && in_array($slug, $selected_category) ) ? 'checked="checked"' : '';

                $ncm_categroies_html.= '<br/><label for="ncm_category_'.$slug.'">';

                $ncm_categroies_html.= '<input type="checkbox" value="'.$slug.'" name="ncm_category[]" id="ncm_category_'.$slug.'" class="ncm_category" '.$checked.' /> '.ucfirst($cat_key);

                $ncm_categroies_html.= '</label>';

            }

            $field_data['ncm_categroies'] = $ncm_categroies_html;





            $selected_attractions = isset($_REQUEST['ncm_attraction']) ? $_REQUEST['ncm_attraction'] : '';

            $ncm_attraction = '';

            foreach( $attractions as $key => $value ) {

                $checked = ( !empty($selected_attractions) && in_array($key, $selected_attractions) ) ? 'checked="checked"' : '';

                $ncm_attraction.= '<label for="ncm_attraction_'.$key.'">';

                $ncm_attraction.= '<input type="checkbox" value="'.$key.'" name="ncm_attraction[]" id="ncm_attraction_'.$key.'" class="ncm_attraction" '.$checked.' /> '.$value;

                $ncm_attraction.= '</label>';

            }

            $field_data['ncm_attraction'] = $ncm_attraction;



            $content.= '<div class="ncm_container">';

            $content.= '<form action="'.$action.'" class="" id="" method="GET">';

            $content.= $field;

            $content.= ncm_get_template_content("ncm-search-product", $field_data);

            $content.= '</form>';

            $content.= '</div>';

            return $content;

        }



        function ncm_product_availability_func( $atts = array(), $content = "" ) {

            global $ncm_template_product;

            ob_start();

            $ncm_template_product->ncm_single_product_summary_func();

            $content.= ob_get_contents();

            ob_end_clean();

            return $content;

        }



        function ncm_before_shortcode( $pagename ) {

            global $ncm_controls;

            $attr = '';

            if( $pagename == 'order' ) { $attr = ' style="display:none;"'; }

            $content = '<div class="ncm_main_content">';

            $content.= '<div class="ncm_main_container_loader">';

            $content.= $ncm_controls->ncm_control( array( "type"=>"hidden", "id"=>"ncm_page", "value"=>$pagename ) );



            $content.= '<div id="ncm_container_loader" '.$attr.'>';

            $content.= '<div class="ncm_container_loader"><i class="ncm_fa ncm_fa-spinner ncm_fa-spin ncm_fa-4x ncm_prc_avl"></i></div>';

            $content.= '</div>';

            return $content;

        }



        function ncm_after_shortcode() {

            $content = '</div>';

            $content.= '</div>';

            return $content;

        }



        function ncm_cart_html_func ( $atts = array(), $content = "" ) {

            global $ncm_cart;

            $content.= $this->ncm_before_shortcode('cart');

            $content.= $ncm_cart->ncm_ajax_container();

            $content.= $this->ncm_after_shortcode();

            return $content;

        }



        function ncm_checkout_html_func( $atts = array(), $content = "" ) {

    		global $ncm_payment_gateways,$ncm_post_id, $ncm_checkout;



            $content.= $this->ncm_before_shortcode('checkout');

            $content.= '<form action="" method="post" id="ncm_payment_form">';

            $content.= $ncm_checkout->ncm_checkout_main_func();

            $content.= '</form>';

            $content.= $this->ncm_after_shortcode();

            return $content;

        }



    	function ncm_order_html_func( $atts = array(), $content = "" ){

    		global $ncm, $ncm_cart, $ncm_order;

            $content.= $this->ncm_before_shortcode('order');

            $content.= $ncm_order->ncm_get_orders();

            $content.= $this->ncm_after_shortcode();

            return $content;

    	}



        function ncm_has_shortcode( $shortcode ) {

            global $post, $wp_query;

            // print_r( $wp_query->get_queried_object() );



            $return = false;

            if( !empty( $shortcode) ) {

                $post_content = isset($post->post_content) ? $post->post_content : '';

                if ( !empty($post_content) && has_shortcode( $post_content, $shortcode ) ) {

                    $return = true;

                } 

            }

            return $return;

        }

    }

    global $ncm_shortcode;

    $ncm_shortcode = new NCM_Shortcode();

}

?>
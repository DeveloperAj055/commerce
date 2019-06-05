<?php



if( !class_exists ( 'NCM_Template_Product' ) ) {







class NCM_Template_Product {







    function __construct() {



        add_action("ncm_before_single_product_summary", array($this, "ncm_before_single_summary_func") );







        add_action("ncm_single_product_summary", array($this, "ncm_single_product_summary_func") );







        add_action("ncm_after_single_product_summary", array($this, "ncm_after_single_summary_func") );



        add_action("ncm_display_availability", array($this, "ncm_display_availability_func"));



    }







    function ncm_before_single_summary_func() {



        global $post;



        $images = isset($post->product_gallery->images) ? $post->product_gallery->images : array();



        $large_images = '';



        $thumb_images = '';



        if( isset($images) && !empty($images) && is_array($images) ){



            



            foreach ($images as $img => $image) {



                $image_path = isset($image->image800) ? $image->image800 : '';

                $thumb_image_path = isset($image->cropImage) ? $image->cropImage : '';



                $image_alt  = isset($image->caption) ? $image->caption : '';



                $class = ($img <= 0) ? 'active' : '';







                $large_images.= '<div class="item '.$class.'" data-slide-number="'.$img.'">';



                $large_images.= '<img src="'.$image_path.'" alt="'.$image_alt.'"></div>';







                $thumb_images.= '<li class="col-sm-2"><a id="carousel-selector-'.$img.'">';



                $thumb_images.= '<img src="'.$thumb_image_path.'" alt="'.$image_alt.'"></a></li>';



            }



        }



        echo '<div class="narnoo_product_gallery">';







        $args = array(



            "post_id" => $post->ID,



            "product_gallery_large_images" => $large_images,



            "product_gallery_thumb_images" => $thumb_images



        );



        ncm_get_template( 'ncm-product-details-gallery', $args );







        echo "</div>";



    }







    function ncm_single_product_summary_func() {



        global $post, $ncm_controls, $ncm_settings, $ncm_payment_gateways;

        

        if(  !get_post_meta( $post->ID, 'narnoo_enable_reservation', true ) ) { 

            return false;

        }



        $args = array();

        $args['ncm_notice_islive_false'] = '';

        if( isset($post->narnoo_data->bookingData->isLive) && !$post->narnoo_data->bookingData->isLive ) {

            $ncm_general_data = $ncm_settings->ncm_get_settings_func();

            $ncm_notice_islive_false = isset($ncm_general_data['ncm_setting_notice_islive_false']) ? $ncm_general_data['ncm_setting_notice_islive_false'] : '';

            $args['ncm_notice_islive_false'] = '<span><i class="ncm_fa ncm_fa-info-circle"></i>'.$ncm_notice_islive_false.'</span>';

        } 



        $post_id = $post->ID;



        $hidden_fields = '';



        $popup_content = '';



        $ncm_bookingCodes = '';



        $ncm_product_type = 'multiple';



        if( isset( $post->narnoo_data->bookingData ) ) {



            $bookingdata = $post->narnoo_data->bookingData;



            if( $bookingdata->bookingCodesCount > 1 ) {



                $ncm_bookingCodes = '';



                $ncm_product_type = 'multiple';



            } else {



                $bookingcode_arr = isset($bookingdata->bookingCodes) ? $bookingdata->bookingCodes : '';



                $bookingCodes = isset($bookingcode_arr[0]->id) ? $bookingcode_arr[0]->id : '';



                $productTimes_arr = isset($bookingdata->productTimes) ? $bookingdata->productTimes : '';



                $productTimes = isset($productTimes_arr[0]->id) ? ':'.$productTimes_arr[0]->id : ':TT';







                $ncm_bookingCodes = $bookingCodes.$productTimes;



                $ncm_product_type = 'single';



            }



        }











        $hidden_fields.= $ncm_controls->ncm_control(



                            array(



                                "type" => "hidden",



                                "name" => "ncm_product_type",



                                "id" => "ncm_product_type",



                                "value" => $ncm_product_type,



                            )



                        );







        $hidden_fields.= $ncm_controls->ncm_control(



                            array(



                                "type" => "hidden",



                                "name" => "ncm_post_id",



                                "id" => "ncm_post_id",



                                "value" => $post_id,



                            )



                        );







        $hidden_fields.= $ncm_controls->ncm_control(



                            array(



                                "type" => "hidden",



                                "name" => "ncm_bookingCodes",



                                "id" => "ncm_bookingCodes",



                                "value" => $ncm_bookingCodes,



                            )



                        );







        $hidden_fields.= $ncm_controls->ncm_control(



                            array(



                                "type" => "hidden",



                                "name" => "ncm_link",



                                "id" => "ncm_link",



                                "value" => $ncm_payment_gateways->ncm_get_cart_page_link(),



                            )



                        );







        $post->ncm_popup_content = $popup_content;



        echo $hidden_fields;



        echo '<div class="product-info">';



        ncm_get_template("summary-single-product", $args);



        echo '</div>';



    }







    function ncm_after_single_summary_func() {



        $all_tabs = $this->ncm_get_tabs();



        $args = array();



        $tabs = '';



        $tabs_content = '';



        $simple_content = '';



        foreach ($all_tabs as $key => $value) {



            $args[$key] = $value;



            if( isset( $value['content'] ) && !empty( $value['content'] ) ) {



                $tabs.= '<li class="ncm-tab" aria-controls="'.$key.'">';



                $tabs.= '<a href="#tab-description">'.$value['title'].'</a>';



                $tabs.= '</li>';







                $tabs_content.= '<div class="ncm-tab-content" id="'.$key.'">';



                //$tabs_content.= 'testt '.$key;



                $tabs_content.= do_shortcode($value['content']);



                $tabs_content.= '</div>';



                $simple_content.= '<p>'.do_shortcode($value['content']).'</p>';

            }



        }



        if( $tabs != '' && $tabs_content != '' ) {

    

            $args['ncm_tabs'] = $tabs;

            $args['ncm_tabs_content'] = $tabs_content;

            $args['ncm_simple_content'] = $simple_content;

        

            ncm_get_template("ncm-product-content", $args);



        }



    }





    function ncm_display_availability_func() {

        global $ncm_settings;

        $content = '';

        $general_setting = $ncm_settings->ncm_get_settings_func();

        $ncm_narnoo_display_calendar = isset($general_setting['ncm_narnoo_display_calendar']) ? $general_setting['ncm_narnoo_display_calendar'] : '';

        if( $ncm_narnoo_display_calendar ) {

            $content = ncm_get_template_content('ncm_display_availability_calendar');

        } else {

            $content = ncm_get_template_content('ncm_display_availability_datepicker');

        }

        echo $content;

    }





    function ncm_get_tabs() {



        global $post;



        $post_id = $post->ID;







        $summery     = $post->post_excerpt;



        $descr       = $post->post_content;



        $transport   = get_post_meta( $post_id, "narnoo_product_transport", true);



        $purchases   = get_post_meta( $post_id, "narnoo_product_purchase", true);



        $packing     = get_post_meta( $post_id, "narnoo_product_packing", true);



        $health      = get_post_meta( $post_id, "narnoo_product_health", true);



        $children    = get_post_meta( $post_id, "narnoo_product_children", true);



        $itinerary   = get_post_meta( $post_id, "product_itinerary", true);



        $information = get_post_meta( $post_id, "narnoo_product_additional", true);







        $tabs = array( 



            "post_excerpt" => array(



                'title' => __('Summery', NCM_txt_domain), 



                'content' => $summery



            ),



            "descr" => array(



                'title' => __('Description', NCM_txt_domain), 



                'content' => $descr



            ),



            "transport" => array(



                'title' => __('Transport', NCM_txt_domain), 



                'content' => $transport



            ),



            "purchases" => array(



                'title' => __('Purchases', NCM_txt_domain), 



                'content' => $purchases



            ),



            "packing" => array(



                'title' => __('Packing', NCM_txt_domain), 



                'content' => $packing



            ),



            "health" => array(



                'title' => __('Health', NCM_txt_domain), 



                'content' => $health



            ),



            "children" => array(



                'title' => __('Children', NCM_txt_domain), 



                'content' => $children



            ),



            "itinerary" => array(



                'title' => __('Itinerary', NCM_txt_domain), 



                'content' => $itinerary



            ),



            "information" => array(



                'title' => __('Additional Information', NCM_txt_domain), 



                'content' => $information



            ),



        );







        return $tabs;



    }







}







global $ncm_template_product;



$ncm_template_product = new NCM_Template_Product();







}







if ( ! function_exists( 'ncm_get_product_image' ) ) :



    function ncm_get_product_image( $post ) {



        $image_path = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );



        $image_alt = get_the_title();



        if( $post->ID && $image_path!='' ) {



            $product_gallery = get_post_meta( $post->ID, 'narnoo_product_gallery', true );



            $gallery_arr = !empty($product_gallery) ? json_decode( $product_gallery ) : '';



            $images = ( !empty($gallery_arr) && isset($gallery_arr->images) ) ? $gallery_arr->images : array();



            if( isset($images) && !empty($images) && is_array($images) ){



                foreach ($images as $img => $image) {



                    if( $image_path == '' ) {



                        $image_path = isset($image->xcrop_image_path) ? $image->xcrop_image_path : '';



                        $image_alt  = isset($image->image_caption) ? $image->image_caption : '';



                    }



                }



            }



        }







        if( $image_path == '' ) {



            $image_path = NCM_IMAGES_URL.'no-image.jpg';



            $image_alt = 'No Image';



        }







        /* if( isset( $post->narnoo_data ) && isset( $post->narnoo_data->productInformation ) ) {







            $product_info = $post->narnoo_data->productInformation;



            if( isset( $product_info->productImages ) && !empty($product_info->productImages) ) {







                $product_images = $product_info->productImages;



                if( isset( $product_images[0] ) && !empty( $product_images[0] ) ) {



                    $images = $product_images[0];







                    $image_path = ( isset($images->cropImagePath) && !empty($images->cropImagePath) ) ? $images->cropImagePath : '';



                }



            }



        } */







        if( !empty($image_path) ) {



            return '<img src="'.$image_path.'" alt="'.$image_alt.'" />';



        } else {



            return '<img src="'.$image_path.'" alt="'.$image_alt.'" />';



        }



    }



endif;







?>
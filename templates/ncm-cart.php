<div class="ncm_cart_table table-responsive">



    <table class="table table-striped table-bordered">



        <thead>



            <tr>



                <th><span class="action"><?php _e('Action', NCM_txt_domain); ?></span></th>



                <th><span class="tour_code"><?php _e('Tour Code', NCM_txt_domain); ?></span></th>



                <th><span class="tour_name"><?php _e('Tour Name', NCM_txt_domain); ?></span></th>



                <th><span class="tour_date"><?php _e('Travel Date', NCM_txt_domain); ?></span></th>



                <th><span class="ncm_pickup"><?php _e('Pickup Location', NCM_txt_domain); ?></span></th>



                <?php /*<th><span class="ncm_dropoff"><?php _e('Dropoff Location', NCM_txt_domain); ?></span></th> */?>



                <th><span class="subtotal"><?php _e('Sub Total', NCM_txt_domain); ?></span></th>



                <?php /* <th><?php _e('Levy', NCM_txt_domain); ?></th> */ ?>



                <th><span class="total"><?php _e('Total', NCM_txt_domain); ?></span></th>



            </tr>



        </thead>



        <tbody>



            <?php do_action('ncm_cart_items'); ?>



        </tbody>



    </table>



</div>







<div class="inner-box">



    <h3><?php _e("Passenger Information", NCM_txt_domain); ?></h3>



    <?php do_action('ncm_cart_passenger'); ?>



</div>







<div class="cart_totals">



    <h3><?php _e("Cart totals", NCM_txt_domain); ?></h3><hr/>



    <div class="col-md-12">



        <div class="row">



            <div class="col-md-6">



                <div class="table-responsive">



                    <table cellspacing="0" class="table shop_table shop_table_responsive">



                        <tbody>



                            <tr class="cart-subtotal">



                                <th><?php _e("Subtotal", NCM_txt_domain); ?></th>



                                <td data-title="Subtotal">



                                    <?php ncm_cart_subtotal(); ?>



                                </td>



                            </tr>







                            <?php /* <tr class="cart-subtotal">



                                <th><?php _e("Levies", NCM_txt_domain); ?></th>



                                <td data-title="Levies">



                                    <?php ncm_cart_leviestotal(); ?>



                                </td>



                            </tr> */ ?>



                        



                            <tr class="order-total">



                                <th><?php _e("Total", NCM_txt_domain); ?></th>



                                <td data-title="Total">



                                    <?php ncm_cart_total(); ?>



                                </td>



                            </tr>



                        </tbody>



                    </table>



                </div>



            </div>



        </div> 



        <div class="row">



            <div class="col-md-12 col-xs-12">







                <div class="ncm_cart_shop_btns">



                



                    <?php do_action( "ncm_continue_shopping", __("Continue Shopping", NCM_txt_domain) ); ?>







                    <?php do_action( "ncm_proceed_to_checkout", __("Proceed to checkout", NCM_txt_domain) ); ?>







                </div>







            </div>



        </div>  



    </div>



</div>




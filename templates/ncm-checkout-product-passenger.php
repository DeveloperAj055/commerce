<div class="inner-box">



    <h3><?php _e("Your Order", NCM_txt_domain); ?></h3>



    <hr/>



    <div class="table-responsive checkout_table_custom">



        <table class="table table-striped table-bordered">



            <thead>



                <tr>



                    <th><span class="tour_code"><?php _e('Tour Code', NCM_txt_domain); ?></span></th>



                    <th><span class="tour_name"><?php _e('Tour Name', NCM_txt_domain); ?></span></th>



                    <th><span class="tour_date"><?php _e('Travel Date', NCM_txt_domain); ?></span></th>



                    <th><span class="ncm_pickup"><?php _e('Pickup Location', NCM_txt_domain); ?></span></th>



                    <?php /*<th><span class="ncm_dropoff"><?php _e('Dropoff Location', NCM_txt_domain); ?></span></th>*/?>



                    <th><span class="ncm_passenger"><?php _e('Passenger', NCM_txt_domain); ?></span></th>



                    <th><span class="subtotal"><?php _e('Sub Total', NCM_txt_domain); ?></span></th>



                    <?php /* <th><?php _e('Levy', NCM_txt_domain); ?></th> */ ?>



                    <th><span class="total"><?php _e('Total', NCM_txt_domain); ?></span></th>



                </tr>



            </thead>



            <tbody>



                <?php do_action('ncm_checkout_product'); ?>



            </tbody>



        </table>



    </div>







    







    <div class="col-md-12">



        <table cellspacing="0" class="shop_table shop_table_responsive">



            <tbody>



                <tr class="cart-subtotal">



                    <th><?php _e("Subtotal", NCM_txt_domain); ?></th>



                    <td data-title="Subtotal">



                        <?php ncm_cart_subtotal(); ?>



                    </td>



                </tr>







                <?php /*



                <tr class="cart-subtotal">



                    <th><?php _e("Levies", NCM_txt_domain); ?></th>



                    <td data-title="Levies">



                        <?php ncm_cart_leviestotal(); ?>



                    </td>



                </tr>



                */ ?>



            



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
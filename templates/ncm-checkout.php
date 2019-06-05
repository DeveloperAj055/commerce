<?php global $ncm_shortcode,$ncm_payment_gateways,$ncm_post_id, $ncm_controls, $ncm_product;



/* $success,$error, 

<div class="inner-box">

	<span class="ncm-payment-success"><?php echo isset($success)?$success:''; ?></span>

</div>

*/

?>



<div class="inner-box wrapper-form-custom">

    <h3><?php _e("Customer Information", NCM_txt_domain); ?></h3><hr/>

    <div class="row">

        <?php foreach ($ncm_user_fields as $ncm_field) { ?>

            <div class="col-md-12">

                <div class="form-group">

                    <div class="col-sm-4 col-md-4 d-inline-block">

                        <label class="control-label" for="ncm-first_name"><?php echo $ncm_field['label']; ?></label>

                    </div>

                    <div class="col-sm-8 col-md-8 d-inline-block">

                        <div class="field-wrapper-50">

                            <?php echo $ncm_field['control']; ?>

                            <p class="text-danger"></p>

                        </div>

                    </div>

                </div>

            </div>

            <?php

        }

        ?>

    </div>

</div>



<?php do_action('ncm_checkout_product_passenger'); ?>



<div class="inner-box">

    <div class="col-md-12">

        <div class="panel-group" id="accordion">

            <?php do_action('ncm_checkout_payment'); ?>

        </div> 

    </div>

</div> 



<div class="col-xs-12 col-md-12">

    <?php do_action('ncm_submit_button'); ?>

</div>
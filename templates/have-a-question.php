<!-- Modal -->

<div id="have_a_question" class="modal fade" role="dialog">

    <div class="modal-dialog">



        <!-- Modal content-->

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <h4 class="modal-title"><?php _e('Have A Question?', NCM_txt_domain); ?></h4>

            </div>

            <div class="modal-body">

                <form id="ncm_question_form" method="post" _lpchecked="1">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="col-lg-12 alert alert-danger alert-dismissible hidden" id="hidden-error">

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

                                Whoops! There was a problem with your payment. Please enter your payment details again.<br>

                                <i class="fa fa-asterisk"></i><em id="error_message"></em> 

                            </div>

                            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">

                                <div class="form-group">

                                    <label class="product-title">

                                        <?php _e('Your Name', NCM_txt_domain); ?><small style="color: #00416e"> * </small>

                                    </label>

                                    <input type="text" name="booking_name" id="booking_name" class="full-width" value="" />

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">

                                <div class="form-group">

                                    <label class="product-title">

                                        <?php _e('Email Address', NCM_txt_domain); ?> <small style="color: #00416e"> * </small>

                                    </label>

                                    <input type="email" name="booking_email" id="booking_email" class="full-width" value="" />

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">

                                <div class="form-group">

                                    <label class="product-title">

                                        <?php _e('Phone Number', NCM_txt_domain); ?> <small style="color: #00416e"> * </small>

                                    </label>

                                    <input type="text" name="booking_phone" id="booking_phone" class="full-width" value="" />

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">

                                <div class="form-group">

                                    <label class="product-title"> 

                                        <?php _e('Accommodation', NCM_txt_domain); ?> <small style="color: #00416e"> * </small>

                                    </label>

                                    <input type="text" name="booking_hotel" id="booking_hotel" class="full-width" value="" />

                                </div>

                            </div>

                            <div class="col-lg-12">

                                <div class="form-group">

                                    <label class="product-title"> <?php _e('Questions or Comments', NCM_txt_domain); ?> </label>

                                    <textarea name="booking_comments" class="full-width"></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary" name="submit" id="ncm_question_submit"> 

                    <?php _e('Submit', NCM_txt_domain); ?> 

                </button>

                    

                <button type="button" class="btn btn-default" data-dismiss="modal">

                    <?php _e('Close', NCM_txt_domain); ?>

                </button>

            </div>

        </div>



    </div>

</div>




<!-- Display option list if option list is more -->

<div id="ncm_option_list" class="modal fade" role="dialog">
    
    <div class="modal-dialog">
    
        <div class="modal-content" id="ncm_option_list_conent">
    
        </div>
    
    </div>
    
</div>
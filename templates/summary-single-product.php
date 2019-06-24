<?php global $post, $ncm_product;  ?>

<?php 
//echo '<pre>';
//print_r($post); 

/*if( isset( $post->narnoo_data->bookingData ) ) {
    $bookingdata = $post->narnoo_data->bookingData;
    $productTimes_arr = isset($bookingdata->productTimes) ? $bookingdata->productTimes : '';
    print_r($productTimes_arr);
}*/
?>

<p class="price">

    <?php _e('TODAY\'S RATES FROM', NCM_txt_domain ); echo ' '.(isset($post->avg_price) ? $post->avg_price : 0); ?>

    <br/><small><?php _e('Price is per adult and includes all levies, fees & taxes',NCM_txt_domain); ?></small>

</p>

<?php 
if( isset( $post->narnoo_data->bookingData ) ) {

$bookingdata = $post->narnoo_data->bookingData;
$productTimes_arr = isset($bookingdata->productTimes) ? $bookingdata->productTimes : '';

    if(count($productTimes_arr) > 1){ ?>
        <div class="ncm_product_time_select">
            <label class="ncm-label">Pick Product Time</label>
            <select name="pruduct_time" id="pruduct_time">
            <?php  foreach($productTimes_arr as $time){ 
                if($time->default == 1 ){
                    $selected = "selected='selected'";
                }else{
                    $selected = "";
                } ?>
                <option value="<?php echo $time->id ?>" <?php echo $selected;?> ><?php echo $time->time ?></option>
            <?php  } ?>
            </select>
        <div>
    <?php }
}
?>

<?php do_action( 'ncm_display_availability' ); ?>



<?php if($ncm_notice_islive_false != '') { ?>

<p class="ncm_info">

    <? echo $ncm_notice_islive_false; ?>

</p>

<?php } ?>



<p class="ncm-date">

<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#have_a_question">

    <?php _e('Have A Question?', NCM_txt_domain); ?>

</button>

</p>



<!-- Modal For display price check_my_price_now_popup -->

<div id="check_my_price_now_popup" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <h4 class="modal-title"> 

                    <?php _e('Product Availability And Prices', NCM_txt_domain); ?> 

                </h4>

            </div>

            <div class="modal-body check_my_price_now_content" >

                <div class="ncm_loader ncm_price_availability_loader" style="display:none;">

                    <i class="ncm_fa ncm_fa-spinner ncm_fa-spin ncm_fa-4x ncm_prc_avl"></i>

                </div>

                <div class="row modal-container">

                    <div class="col-md-12" id="check_my_price_now_content">

                        <?php echo $post->ncm_popup_content; ?>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <?php /* <button type="submit" class="btn btn-primary" name="ncm_book_my_tour" id="ncm_book_my_tour"> 

                    <?php _e('Book My Tour', NCM_txt_domain); ?></button>

                <span class="ncm_book_my_tour_loader ncm_display_loader">

                    <i class="ncm_fa-li ncm_fa ncm_fa-spinner ncm_fa-spin"></i>

                </span> */ ?>

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', NCM_txt_domain); ?></button>

            </div>

        </div>

    </div>

</div>





<?php ncm_get_template("have-a-question"); ?>
<script type="text/javascript">
jQuery(document).ready(function($) {  
    
    var getHidVal = jQuery('#ncm_bookingCodes').val();
    var getHidFinal = getHidVal.split(":");
    //console.log(getHidFinal);

    jQuery('#pruduct_time').on('change', function (e){
        var selectTime =  jQuery(this).val();
        getHidFinal.pop();
        getHidFinal.push(selectTime);
        var inputVal = getHidFinal.join(":");
        //console.log(inputVal);
        jQuery('#ncm_bookingCodes').val(inputVal);
    });

});    
</script>
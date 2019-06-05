<tr>
	
	<td><?php echo $product_id; ?></td>
	
	<td><?php echo $tour_name; ?></td>
	
	<td><?php echo $booking_date; ?></td>
	
	<td><?php echo $pickup; ?></td>
	
	<?php /*<td><?php echo $dropoff; ?></td>*/?>
	
	<td><?php echo $passenger; ?></td>
	
	<td><?php echo $subtotal; ?></td>
	
	<?php /* <td><?php echo $levy; ?></td> */ ?>
	
	<td><?php echo $total; ?></td>
	
</tr>
<?php /* if( !empty ($ncm_passenger) ) { ?>
<tr>
<td colspan="9">
<h5><?php _e('Passenger Information', NCM_txt_domain); ?></h5>
<table>
<thead>
<tr>
<th>First name</th>
<th>last name</th>
<th>Country</th>                    </tr>                </thead>                <tbody>                    <?php do_action( "ncm_checkout_passenger", $ncm_passenger ); ?>                </tbody>            </table>        </td>    </tr><?php } */ ?>
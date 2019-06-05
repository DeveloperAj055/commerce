<tr>

    <?php foreach ($passenger_fields as $field_label) { ?>
        <th><input type="text" <?php echo ncm_set_attribute($field_label); ?> /></th>
    <?php } ?>
    <?php /* <th>
        <input type="text" <?php echo ncm_set_attribute($ncm_attr_firstname); ?> />
    </th>
    <th>
        <input type="text" <?php echo ncm_set_attribute($ncm_attr_lastname); ?> />
    </th>
    <th>
        <input type="text" <?php echo ncm_set_attribute($ncm_attr_country); ?> />
    </th> */ ?>
</tr>
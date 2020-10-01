<div class="ap-tab-content">
<table width="100%" border="0">
    <tr>
      <td width="200"><strong><?php _e('Enable','lms');?></strong></td>
      <td><input type="checkbox" name="lms_woocommerce_enabled" value="yes" <?php echo ($lms_woocommerce_enabled == 'yes'?'checked':''); ?>> <?php _e('Check this to enable woocommerce integration','lms');?>
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Submit','lms');?>"></td>
    </tr>
</table>
</div>
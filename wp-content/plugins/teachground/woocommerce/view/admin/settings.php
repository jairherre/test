<div class="ap-tab-content">
<table width="100%" border="0">
    <tr>
      <td width="200"><strong><?php _e('Enable','teachground');?></strong></td>
      <td><input type="checkbox" name="tg_woocommerce_enabled" value="yes" <?php echo ($tg_woocommerce_enabled == 'yes'?'checked':''); ?>> <?php _e('Check this to enable woocommerce integration','teachground');?>
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Submit','teachground');?>"></td>
    </tr>
</table>
</div>
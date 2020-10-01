<div class="ap-tab-content">
<table width="100%" border="0">
    <tr>
      <td width="200"><strong><?php _e('CopeCart API KEY','lms');?></strong></td>
      <td><input type="text" name="lms_copecart_api_key" value="<?php echo $lms_copecart_api_key;?>" class="widefat"></td>
    </tr>
    <tr>
      <td><strong>Webhook URL</strong> </td>
	  <td><?php echo site_url('/?cclmsapi=true');?></td>
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
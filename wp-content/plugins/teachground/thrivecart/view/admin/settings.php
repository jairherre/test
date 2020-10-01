<div class="ap-tab-content">
<table width="100%" border="0">
    <tr>
      <td width="200"><strong><?php _e('Thrivecart ID','teachground');?></strong></td>
      <td><input type="text" name="tg_thrivecart_id" value="<?php echo $tg_thrivecart_id;?>" class="widefat"></td>
    </tr>
    <tr>
      <td width="200"><strong><?php _e('Thrivecart API KEY','teachground');?></strong></td>
      <td><input type="text" name="tg_thrivecart_api_key" value="<?php echo $tg_thrivecart_api_key;?>" class="widefat"></td>
    </tr>
    <tr>
      <td><strong>Webhook URL</strong> </td>
	  <td><?php echo site_url('/?thtgapi=true');?></td>
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
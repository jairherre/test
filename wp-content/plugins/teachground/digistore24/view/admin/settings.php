<div class="ap-tab-content">
<table width="100%" border="0">
    <tr>
      <td width="200"><strong><?php _e('Digistore24 API KEY','teachground');?></strong></td>
      <td><input type="text" name="tg_digistore24_api_key" value="<?php echo $tg_digistore24_api_key;?>" class="widefat"></td>
    </tr>
    <tr>
      <td><strong>Webhook URL</strong> </td>
	  <td><?php echo site_url('/?ds24tgapi=true');?></td>
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
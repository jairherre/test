<table width="100%" border="0">
    <tr>
      <td width="200"><strong><?php _e('Import Data from Excel','teachground');?></strong></td>
      <td><input type="file" name="import_data"></td>
    </tr>
    <tr>
      <td width="200"><strong><?php _e('Import Data from Google Sheets','teachground');?></strong></td>
      <td><input type="text" name="import_data_gs" class="widefat"></td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td><a href="<?php echo plugins_url( TG_DIR_NAME . '/sample-data-import/tg-data.xlsx' );?>" target="_blank"><?php _e('Download sample data','teachground');?></a></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Submit','teachground');?>"></td>
    </tr>
</table>
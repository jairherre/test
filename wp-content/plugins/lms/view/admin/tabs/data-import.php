<table width="100%" border="0">
    <tr>
      <td width="200"><strong><?php _e('Import Data from Excel','lms');?></strong></td>
      <td><input type="file" name="import_data"></td>
    </tr>
    <tr>
      <td width="200"><strong><?php _e('Import Data from Google Sheets','lms');?></strong></td>
      <td><input type="text" name="import_data_gs" class="widefat"></td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td><a href="<?php echo plugins_url( LMS_DIR_NAME . '/sample-data-import/lms-data.xlsx' );?>" target="_blank"><?php _e('Download sample data','lms');?></a></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Submit','lms');?>"></td>
    </tr>
</table>
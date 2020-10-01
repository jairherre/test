<table width="100%" border="0">
    <tr>
      <td width="200" valign="top"><strong><?php _e('Login URL','lms');?></strong></td>
      <td><input type="text" name="lms_login_url" value="<?php echo $lms_login_url;?>" class="widefat">
      <br>
      <?php _e('Please use #login_url# in email templates and it will be replaced by the URL you put here.','lms');?>
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="200" valign="top"><strong><?php _e('Login Redirect URL','lms');?></strong></td>
      <td><input type="text" name="lms_login_redirect_url" value="<?php echo $lms_login_redirect_url;?>" class="widefat">
      <br>
      <?php _e('User will be redirected to the above URL after successful login. If left empty then user will stay on the same page.','lms');?>
      <br><br>
      <strong><?php _e('Login Shortcode','lms');?></strong> [lms_login], <strong><?php _e('Forgot Password Shortcode','lms');?></strong> [lms_forgot_password]
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="200" valign="top"><strong><?php _e('Forgot Password URL','lms');?></strong></td>
      <td><input type="text" name="lms_forgot_password_url" value="<?php echo $lms_forgot_password_url;?>" class="widefat">
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="200" valign="top"><strong><?php _e('Register URL','lms');?></strong></td>
      <td><input type="text" name="lms_register_url" value="<?php echo $lms_register_url;?>" class="widefat">
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
<table width="100%" border="0">
    <tr>
      <td width="200" valign="top"><strong><?php _e('Login URL','teachground');?></strong></td>
      <td><input type="text" name="tg_login_url" value="<?php echo $tg_login_url;?>" class="widefat">
      <br>
      <?php _e('Please use #login_url# in email templates and it will be replaced by the URL you put here.','teachground');?>
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="200" valign="top"><strong><?php _e('Login Redirect URL','teachground');?></strong></td>
      <td><input type="text" name="tg_login_redirect_url" value="<?php echo $tg_login_redirect_url;?>" class="widefat">
      <br>
      <?php _e('User will be redirected to the above URL after successful login. If left empty then user will stay on the same page.','teachground');?>
      <br><br>
      <strong><?php _e('Login Shortcode','teachground');?></strong> [tg_login], <strong><?php _e('Forgot Password Shortcode','teachground');?></strong> [tg_forgot_password]
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="200" valign="top"><strong><?php _e('Forgot Password URL','teachground');?></strong></td>
      <td><input type="text" name="tg_forgot_password_url" value="<?php echo $tg_forgot_password_url;?>" class="widefat">
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="200" valign="top"><strong><?php _e('Register URL','teachground');?></strong></td>
      <td><input type="text" name="tg_register_url" value="<?php echo $tg_register_url;?>" class="widefat">
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="200" valign="top"><strong><?php _e('Assign Admins to all Courses','teachground');?></strong></td>
      <td><input type="checkbox" name="tg_global_admin_access" value="Yes" <?php echo ($tg_global_admin_access == 'Yes'?'checked':'');?>>
      <?php _e('Check to assign all admins of the site to all courses.','teachground');?>
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
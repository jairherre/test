<table width="100%" border="0">
    <!-- <tr>
      <td width="200"><strong><?php _e('Admin Email','lms');?></strong></td>
      <td><input type="text" name="lms_admin_email" placeholder="admin@example.com" value="<?php echo $lms_admin_email;?>" class="widefat"></td>
    </tr> -->
    <tr>
      <td width="200"><strong><?php _e('From Email','lms');?></strong></td>
      <td><input type="text" name="lms_from_email" placeholder="no-reply@example.com" value="<?php echo $lms_from_email;?>" class="widefat"></td>
    </tr>
    <tr>
      <td width="200"><strong><?php _e('From Name','lms');?></strong></td>
      <td><input type="text" name="lms_from_name" placeholder="LMS" value="<?php echo $lms_from_name;?>" class="widefat"></td>
    </tr>
    
    <!-- user emails -->
    <tr>
      <td colspan="2"><hr></td>
    </tr>
    <tr>
      <td colspan="2"><h3><?php _e('Account created email','lms');?></h3></td>
    </tr>
    <tr>
      <td colspan="2"><?php _e('This email will be sent each time a new account is created on the site.','lms');?></td>
    </tr>
   <?php /*?> <tr>
      <td><h4><?php _e('Access Assigned Email','lms');?></h4></td>
      <td><label><input type="checkbox" name="lms_enable_access_assigned_email_user" value="Yes" <?php echo lms_is_checked( $lms_enable_access_assigned_email_user );?> onClick="toggelEmail( 'lms_enable_access_assigned_email_user')"> <?php _e('Enable','lms');?></label></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div id="div_lms_enable_access_assigned_email_user" style="display:none;">
            	<table width="100%" border="0">
                	<tr>
                      <td valign="top" width="200"><strong><?php _e('Access Assigned to user Email Subject','lms');?></strong></td>
                      <td><input type="text" name="lms_access_assign_subject" value="<?php echo stripslashes($lms_access_assign_subject);?>" class="widefat">
                      </td>
                    </tr>
    				<tr>
                      <td valign="top"><strong><?php _e('Access Assigned to user Email Body','lms');?></strong><p><i><?php _e('User will get this email','lms');?></i></p></td>
                      <td><textarea name="lms_access_assign_body" class="widefat" rows="10"><?php echo stripslashes($lms_access_assign_body);?></textarea>
                      <i><?php _e('Email template can be found at','lms');?> <?php echo LMS_DIR_NAME;?>/templates/emails/user_assigned.php</i><br>
                      <strong><?php _e('Available Codes','lms');?></strong> #display_name#, #user_email#, #course_link#, #course_name#, #site_url#, #reset_pass_url#
                      </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    
    <tr>
      <td colspan="2"><hr></td>
    </tr>
    <tr>
      <td><h4><?php _e('Access Unassigned Email','lms');?></h4></td>
      <td><label><input type="checkbox" name="lms_enable_access_unassign_email_user" value="Yes" <?php echo lms_is_checked( $lms_enable_access_unassign_email_user );?> onClick="toggelEmail( 'lms_enable_access_unassign_email_user')"> <?php _e('Enable','lms');?></label></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div id="div_lms_enable_access_unassign_email_user" style="display:none;">
            	<table width="100%" border="0">
                	<tr>
                      <td valign="top" width="200"><strong><?php _e('Access Unassigned from user Email Subject','lms');?></strong></td>
                      <td><input type="text" name="lms_access_unassign_subject" value="<?php echo $lms_access_unassign_subject;?>" class="widefat">
                      </td>
                    </tr>
                    <tr>
                      <td valign="top"><strong><?php _e('Access Unassigned to user Email Body','lms');?></strong><p><i><?php _e('User will get this email','lms');?></i></p></td>
                      <td><textarea name="lms_access_unassign_body" class="widefat" rows="10"><?php echo stripslashes($lms_access_unassign_body);?></textarea>
                      <i><?php _e('Email body template can be found at','lms');?> <?php echo LMS_DIR_NAME;?>/templates/emails/user_unassigned.php</i><br>
                      <strong><?php _e('Available Codes','lms');?></strong> #display_name#, #user_email#, #course_link#, #course_name#, #site_url#, #reset_pass_url#
                      </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
      <td colspan="2"><hr></td>
    </tr><?php */?>
    <tr>
      <td><h4><?php _e('Send to user','lms');?></h4></td>
      <td><label><input type="checkbox" name="lms_enable_new_user_created_email_user" value="Yes" <?php echo lms_is_checked( $lms_enable_new_user_created_email_user );?> onClick="toggelEmail( 'lms_enable_new_user_created_email_user')"> <?php _e('Enable','lms');?></label></td>
    </tr>
     <tr>
    	<td colspan="2">
        	<div id="div_lms_enable_new_user_created_email_user" style="display:none;">
            	<table width="100%" border="0">
                	   <tr>
                          <td valign="top" width="200"><strong><?php _e('Email subject','lms');?></strong></td>
                          <td><input type="text" name="lms_new_user_inserted_subject" value="<?php echo $lms_new_user_inserted_subject;?>" class="widefat">
                          </td>
                        </tr>
                        <tr>
                          <td valign="top"><strong><?php _e('Email content','lms');?></strong><p><i><?php _e('User will get this email','lms');?></i></p></td>
                          <td><textarea name="lms_new_user_inserted_body" class="widefat" rows="10"><?php echo stripslashes($lms_new_user_inserted_body);?></textarea>
                          <i><?php _e('Email body template can be found at','lms');?> <?php echo LMS_DIR_NAME;?>/templates/emails/user_inserted.php</i><br>
                          <strong><?php _e('Available Codes','lms');?></strong> #display_name#, #first_name#, #last_name#, #user_email#, #user_password#, #site_url#, #reset_pass_url#, #login_url#
                          </td>
                        </tr>
                </table>
            </div>
        </td>
    </tr> 
    <tr>
				<td colspan="2">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php _e('Use the following option if you want to manually resend this email to selected users','lms');?>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<strong><?php _e('Search User','lms');?></strong>
				</td>
				<td>
					<select class="lms-account-created-email widefat" name="email_account_created_users[]" multiple="multiple">
					  <?php echo $this->get_users_as_options();?>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;
				</td>
				<td>
					<input type="button" name="send_account_created_mail" value="<?php _e('Resend Email','lms');?>" class="button" onClick="sendAccountCreatedForceEmails();">
				</td>
			</tr>
    
    <script>
    jQuery(function() {
		//toggelEmail('lms_enable_access_assigned_email_user');
		//toggelEmail('lms_enable_access_unassign_email_user');
		toggelEmail('lms_enable_new_user_created_email_user');
    });

		jQuery(document).ready(function() {
			jQuery('.lms-account-created-email').select2();
		});

    function sendAccountCreatedForceEmails(){
			var email_account_created_users = jQuery('select[name="email_account_created_users[]"]').val(); 
			if( email_account_created_users != null ){
				jQuery.ajax( {
					method: "POST",
					dataType: "json",
					beforeSend: function () {},
					data: {
						option: 'sendAccountCreatedForceEmails',
						email_account_created_users: email_account_created_users,
					}
				} )
				.done( function ( res ) {
          jQuery('select[name="email_account_created_users[]"]').val(null).trigger('change');
          alert(res.status);
				} );
			} else {
				alert('Please select users');
			}
		}	
    </script>
    
    <!-- user emails -->
    
    <!-- admin emails -->
    <?php /*?><tr>
      <td colspan="2"><h3><?php _e('Admin Emails','lms');?></h3></td>
    </tr>
    <tr>
      <td><h4><?php _e('Access Assigned Email','lms');?></h4></td>
      <td><label><input type="checkbox" name="lms_enable_access_assigned_email_admin" value="Yes" <?php echo lms_is_checked( $lms_enable_access_assigned_email_admin );?> onClick="toggelEmail( 'lms_enable_access_assigned_email_admin')"> <?php _e('Enable','lms');?></label></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div id="div_lms_enable_access_assigned_email_admin" style="display:none;">
            	<table width="100%" border="0">
                     <tr>
                      <td valign="top" width="200"><strong><?php _e('Access Assigned to user Email Subject Admin','lms');?></strong></td>
                      <td><input type="text" name="lms_access_assign_subject_admin" value="<?php echo $lms_access_assign_subject_admin;?>" class="widefat">
                      </td>
                    </tr>
                    <tr>
                      <td valign="top"><strong><?php _e('Access Assigned to user Email Body Admin','lms');?></strong> <p><i><?php _e('Admin will get this email','lms');?></i></p></td>
                      <td><textarea name="lms_access_assign_body_admin" class="widefat" rows="10"><?php echo stripslashes($lms_access_assign_body_admin);?></textarea>
                      <i><?php _e('Email template can be found at','lms');?> <?php echo LMS_DIR_NAME;?>/templates/emails/user_assigned_admin.php</i><br>
                      <strong><?php _e('Available Codes','lms');?></strong> #display_name#, #user_email#, #course_link#, #course_name#, #site_url#, #reset_pass_url#
                      </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr> 
    <tr>
      <td colspan="2"><hr></td>
    </tr>
    <tr>
      <td><h4><?php _e('Access Unassigned Email','lms');?></h4></td>
      <td><label><input type="checkbox" name="lms_enable_access_unassigned_email_admin" value="Yes" <?php echo lms_is_checked( $lms_enable_access_unassigned_email_admin );?> onClick="toggelEmail( 'lms_enable_access_unassigned_email_admin')"> <?php _e('Enable','lms');?></label></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div id="div_lms_enable_access_unassigned_email_admin" style="display:none;">
            	<table width="100%" border="0">
                     <tr>
                      <td valign="top" width="200"><strong><?php _e('Access Unassigned to user Email Subject Admin','lms');?></strong></td>
                      <td><input type="text" name="lms_access_unassign_subject_admin" value="<?php echo $lms_access_unassign_subject_admin;?>" class="widefat">
                      </td>
                    </tr>
                    <tr>
                      <td valign="top"><strong><?php _e('Access Unassigned to user Email Body Admin','lms');?></strong> <p><i><?php _e('Admin will get this email','lms');?></i></p></td>
                      <td><textarea name="lms_access_unassign_body_admin" class="widefat" rows="10"><?php echo stripslashes($lms_access_unassign_body_admin);?></textarea>
                      <i><?php _e('Email template can be found at','lms');?> <?php echo LMS_DIR_NAME;?>/templates/emails/user_unassigned_admin.php</i><br>
                      <strong><?php _e('Available Codes','lms');?></strong> #display_name#, #user_email#, #course_link#, #course_name#, #site_url#, #reset_pass_url#
                      </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr> 
    <tr>
      <td colspan="2"><hr></td>
    </tr>
     <tr>
      <td><h4><?php _e('New User Created Email','lms');?></h4></td>
      <td><label><input type="checkbox" name="lms_enable_new_user_created_email_admin" value="Yes" <?php echo lms_is_checked( $lms_enable_new_user_created_email_admin );?> onClick="toggelEmail( 'lms_enable_new_user_created_email_admin')"> <?php _e('Enable','lms');?></label></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div id="div_lms_enable_new_user_created_email_admin" style="display:none;">
            	<table width="100%" border="0">
                     <tr>
                      <td valign="top" width="200"><strong><?php _e('New User Inserted Email to Admin Subject','lms');?></strong></td>
                      <td><input type="text" name="lms_new_user_inserted_subject_admin" value="<?php echo $lms_new_user_inserted_subject_admin;?>" class="widefat">
                      </td>
                    </tr>
                    <tr>
                      <td valign="top"><strong><?php _e('New User Inserted Email to Admin Body','lms');?></strong> <p><i><?php _e('Admin will get this email','lms');?></i></p></td>
                      <td><textarea name="lms_new_user_inserted_body_admin" class="widefat" rows="10"><?php echo stripslashes($lms_new_user_inserted_body_admin);?></textarea>
                      <i><?php _e('Email template can be found at','lms');?> <?php echo LMS_DIR_NAME;?>/templates/emails/user_inserted_admin.php</i><br>
                      <strong><?php _e('Available Codes','lms');?></strong> #display_name#, #user_email#, #user_password#, #site_url#, #reset_pass_url#
                      </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr> 
    <?php */?>
    <script>
    jQuery(function() {
		//toggelEmail('lms_enable_access_assigned_email_admin');
		//toggelEmail('lms_enable_access_unassigned_email_admin');
		//toggelEmail('lms_enable_new_user_created_email_admin');
    });
    </script>
    
    <!-- admin emails -->    
    
    <!-- reset password emails -->
    <tr>
      <td colspan="2"><div style="width:100%; height:2px; background-color:#000;"></div></td>
    </tr>
    <tr>
      <td colspan="2"><h3><?php _e('Reset Password Emails','lms');?></h3></td>
    </tr>
    <tr>
    	<td colspan="2">
            <table width="100%" border="0">
                 <tr>
                  <td valign="top" width="200"><strong><?php _e('Reset Password Link Mail Subject','lms');?></strong></td>
                  <td><input type="text" name="lms_reset_password_subject" value="<?php echo $lms_reset_password_subject;?>" class="widefat">
                  </td>
                </tr>
                <tr>
                  <td valign="top"><strong><?php _e('Reset Password Link Mail Body','lms');?></strong></td>
                  <td><textarea name="lms_reset_password_body" class="widefat" rows="10"><?php echo stripslashes($lms_reset_password_body);?></textarea>
                  <i><?php _e('Email template can be found at','lms');?> <?php echo LMS_DIR_NAME;?>/templates/emails/user_reset_password.php</i><br>
                  <strong><?php _e('Available Codes','lms');?></strong> #site_url#, #user_name#, #display_name#, #first_name#, #last_name#, #resetlink#, #login_url#
                  </td>
                </tr>
            </table>
        </td>
    </tr> 
    <tr>
    	<td colspan="2">
            <table width="100%" border="0">
                 <tr>
                  <td valign="top" width="200"><strong><?php _e('New Password Mail Subject','lms');?></strong></td>
                  <td><input type="text" name="lms_new_password_subject" value="<?php echo $lms_new_password_subject;?>" class="widefat">
                  </td>
                </tr>
                <tr>
                  <td valign="top"><strong><?php _e('New Password Mail Body','lms');?></strong></td>
                  <td><textarea name="lms_new_password_body" class="widefat" rows="10"><?php echo stripslashes($lms_new_password_body);?></textarea>
                  <i><?php _e('Email template can be found at','lms');?> <?php echo LMS_DIR_NAME;?>/templates/emails/user_new_password.php</i><br>
                  <strong><?php _e('Available Codes','lms');?></strong> #site_url#, #user_name#, #display_name#, #first_name#, #last_name#, #resetlink#, #login_url#
                  </td>
                </tr>
            </table>
        </td>
    </tr> 
    <!-- reset password emails -->
    
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" class="button button-primary button-large" value="<?php _e('Submit','lms');?>"></td>
    </tr>
</table>
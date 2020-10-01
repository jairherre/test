<div class="log_forms <?php echo $wid_id;?>">
	<?php $this->error_message();?>
            
    <form name="lms_login" id="lms_login" method="post" action="" autocomplete="off">
    <?php wp_nonce_field( 'lms_form_action', 'lms_form_field' ); ?>
    <input type="hidden" name="option" value="lms_user_login" />
    <input type="hidden" name="redirect" value="<?php echo $this->gen_redirect_url(); ?>" />
    <div class="log-form-group">
        <label for="userusername"><?php _e('Username','lms');?> </label>
        <input type="text" name="userusername" id="userusername" required/>
    </div>
    <div class="log-form-group">
        <label for="userpassword"><?php _e('Password','lms');?> </label>
        <input type="password" name="userpassword" id="userpassword" required/>
    </div>
    
    <?php do_action('login_form');?>
    
    <?php $this->add_remember_me();?>
    
    <div class="log-form-group"><input name="login" type="submit" value="<?php _e('Login','lms');?>"/></div>
    <div class="log-form-group extra-links">
        <?php $this->add_extra_links();?>
    </div>
    </form>
</div>
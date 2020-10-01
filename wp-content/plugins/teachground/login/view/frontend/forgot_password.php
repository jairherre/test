<div class="forgot-pass-form">
	<?php $this->error_message();?>
    <form name="forgot" id="forgot" method="post" action="" autocomplete="off">
    <?php wp_nonce_field( 'tg_form_action', 'tg_form_field' ); ?>
    <input type="hidden" name="option" value="tg_forgot_pass" />
        <div class="forgot-pass-form-group">
        <label for="userusername"><?php _e('Email','teachground');?> </label>
        <input type="email" name="userusername" id="userusername" required/>
        </div>
        
        <div class="forgot-pass-form-group"><input name="forgot" type="submit" value="<?php _e('Submit','teachground');?>"/></div>
        
        <div class="forgot-pass-form-group">
            <div class="forgot-text">
                <?php _e('Please enter your email. The password reset link will be provided in your email.','teachground');?>
            </div>
        </div>
    </form>
</div>
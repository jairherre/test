<table width="100%" border="0" class="ap-table">
<tr>
  <td><h3><?php _e('TeachGround Settings', 'teachground');?></h3></td>
</tr>
<tr>
  <td><div class="ap-tabs">
      <div class="ap-tab">
        <?php _e('General Settings','teachground');?>
      </div>
      <div class="ap-tab">
        <?php _e('Course Start Rules','teachground');?>
      </div>
      <div class="ap-tab">
        <?php _e('Emails','teachground');?>
      </div>
      <div class="ap-tab">
        <?php _e('Display Settings','teachground');?>
      </div>
      <div class="ap-tab">
        <?php _e('Import Data','teachground');?>
      </div>
      <div class="ap-tab">
        <?php _e('Category','teachground');?>
      </div>
      <div class="ap-tab">
        <?php _e('Translations','teachground');?>
      </div>
      <?php do_action('tg_custom_settings_tab');?>
    </div>
    <div class="ap-tabs-content">
      <div class="ap-tab-content">
        <?php include( TG_DIR_PATH . '/view/admin/tabs/general-settings.php' ); ?>
      </div>
      <div class="ap-tab-content">
        <?php include( TG_DIR_PATH . '/view/admin/tabs/course-start-rules.php' ); ?>
      </div>
      <div class="ap-tab-content">
       <?php include( TG_DIR_PATH . '/view/admin/tabs/emails.php' ); ?>
      </div>
      <div class="ap-tab-content">
        <?php include( TG_DIR_PATH . '/view/admin/tabs/display-settings.php' ); ?>
      </div>
      <div class="ap-tab-content">
        <?php include( TG_DIR_PATH . '/view/admin/tabs/data-import.php' ); ?>
      </div>
      <div class="ap-tab-content">
        <?php include( TG_DIR_PATH . '/view/admin/tabs/category.php' ); ?>
      </div>
      <div class="ap-tab-content">
        <?php include( TG_DIR_PATH . '/view/admin/tabs/translations.php' ); ?>
      </div>
      <?php do_action('tg_custom_settings_tab_content');?>
    </div></td>
</tr>
</table>
<?php

global 
$tg_access_assign_subject_default, 
$tg_access_assign_body_default, 
$tg_access_assign_body_admin_default,
$tg_access_unassign_subject_default, 
$tg_access_unassign_body_default,
$tg_access_unassign_body_admin_default,
$tg_new_user_inserted_subject_default,
$tg_new_user_inserted_body_default,
$tg_new_user_inserted_body_admin_default,
$tg_forgot_password_link_mail_body_default,
$tg_forgot_password_link_mail_subject_default,
$tg_new_password_mail_body_default,
$tg_new_password_mail_subject_default
;

// user assigned to course email subject & body //

if( defined('WPLANG') or get_option( 'WPLANG' ) != '' ){

    $lang = (get_option( 'WPLANG' ) == ''?WPLANG:get_option( 'WPLANG' ));

    if( $lang == 'de_DE' ){ // Language for de_DE

        $tg_access_assign_subject_default = 'DE You have been enrolled to #access_name#';
        $tg_access_assign_body_default = '
        Hallo #first_name#,

        und herzlich Willkommen zu #access_name#!

        Der Zugang wurde soeben für dich freigeschaltet!

        Deine Zugangsdaten hast du bereits in einer separaten E-Mail erhalten. 

        Viel Erfolg!';
        // user assigned to course email body //
    
        // user assigned to course email body admin //
        $tg_access_assign_body_admin_default = '
        Dear Admin,
    
        #display_name# is assigned to #access_name#
    
        Kind regards,
        <strong>TeachGround</strong>';
        // user assigned to course email body admin //
    
        // user unassigned from course email subject & body //
        $tg_access_unassign_subject_default = 'You have been unenrolled from #access_name#';
        $tg_access_unassign_body_default = '
        Hallo #first_name#,

        dein Zugang zu #access_name# wurde deaktiviert!

        Wenn du Fragen dazu hast, wende dich bitte an unser Support-Team.

        Vielen Dank';
        // user unassigned from course email body //
    
        // user unassigned from course email body admin //
        $tg_access_unassign_body_admin_default = '
        Dear Admin,
    
        #display_name# is unassigned from #access_name#
    
        Kind regards,
        <strong>TeachGround</strong>';
        // user unassigned from course email body admin //
    
        // user inserted email body user //
        $tg_new_user_inserted_subject_default = 'Deine Zugangsdaten';
        $tg_new_user_inserted_body_default = '
        Hallo #first_name#,

        dein Zugang zu #site_url# wurde erfolgreich angelegt!

        Hier sind deine Zugangsdaten:

        Benutzername:: #user_email#
        Passwort: #user_password#
        Login URL: #login_url#

        Wenn du dein Passwort zurücksetzen willst, kannst du das hier machen: #reset_pass_url#

        Viele Grüße';
        // user inserted email body user //
    
        // user inserted email body admin //
        $tg_new_user_inserted_body_admin_default = '
        Dear Admin,
    
        New user is added on #site_url#
        Username: #user_email#
    
        Kind regards,
        <strong>TeachGround</strong>';
        // user inserted email body admin //
    
        // forgot password emails // 
        $tg_forgot_password_link_mail_subject_default = 'Passwort zurücksetzen';
        $tg_forgot_password_link_mail_body_default = '
        Du hast die Zurücksetzung deines Passworts angefordert.

        Wenn dies ein Versehen war, lösche diese E-Mail einfach.

        Um dein Passwort zurückzusetzen klicke bitte den folgenden Link:
        #resetlink#

        Vielen Dank';
        
        $tg_new_password_mail_subject_default = 'Neues Passwort';
        $tg_new_password_mail_body_default = '
        Du hast soeben dein Passwort erfolgreich zurückgesetzt.

        Hier sind deine neuen Zugangsdaten:

        Benutzername:: #user_email#
        <strong>Neues</strong> Passwort: #user_password#

        Du kannst dich damit ab sofort hier einloggen:
        #login_url#

        Vielen Dank';
    
        // forgot password emails // 

    } elseif ( $lang == 'da_DK' ) { // Language for da_DK

        $tg_access_assign_subject_default = 'DA You have been enrolled to #access_name#';
        $tg_access_assign_body_default = '
        Dear #display_name#,
    
        You are assigned to #access_name#
    
        Please click here to login: #site_url#
    
        Kind regards,
        <strong>TeachGround</strong>';
        // user assigned to course email body //
    
        // user assigned to course email body admin //
        $tg_access_assign_body_admin_default = '
        Dear Admin,
    
        #display_name# is assigned to #access_name#
    
        Kind regards,
        <strong>TeachGround</strong>';
        // user assigned to course email body admin //
    
        // user unassigned from course email subject & body //
        $tg_access_unassign_subject_default = 'You have been unenrolled from #access_name#';
        $tg_access_unassign_body_default = '
        Dear #display_name#,
    
        You are unassigned from #access_name#
    
        Please contact our support if you have any questions.
    
        Kind regards,
        <strong>TeachGround</strong>';
        // user unassigned from course email body //
    
        // user unassigned from course email body admin //
        $tg_access_unassign_body_admin_default = '
        Dear Admin,
    
        #display_name# is unassigned from #access_name#
    
        Kind regards,
        <strong>TeachGround</strong>';
        // user unassigned from course email body admin //
    
        // user inserted email body user //
        $tg_new_user_inserted_subject_default = 'New user created';
        $tg_new_user_inserted_body_default = '
        Dear #display_name#,
    
        You are successfully registered to the site.
        Username: #user_email#
        Password: #user_password#
        Site URL: #site_url#
    
        Kind regards,
        <strong>TeachGround</strong>';
        // user inserted email body user //
    
        // user inserted email body admin //
        $tg_new_user_inserted_body_admin_default = '
        Dear Admin,
    
        New user is added on #site_url#
        Username: #user_email#
    
        Kind regards,
        <strong>TeachGround</strong>';
        // user inserted email body admin //
    
        // forgot password emails // 
        $tg_forgot_password_link_mail_subject_default = 'Reset Password Link';
        $tg_forgot_password_link_mail_body_default = '
        You have requested that the password be reset for the following account:
        #site_url#
        Username: #user_name#
        If this was a mistake, just ignore this email and nothing will happen.
        To reset your password, visit the following address:
        #resetlink#
    
        Kind regards,
        <strong>TeachGround</strong>';
        
        $tg_new_password_mail_subject_default = 'Neues Passwort';
        $tg_new_password_mail_body_default = '
        Your new password for the account at:
    
        #site_url#
    
        Username: #user_name#
        Password: #user_password#
    
        You can now login with your new password at:
        #site_url#
    
        Kind regards,
        <strong>TeachGround</strong>';
    
        // forgot password emails // 
    }
    
} else { // Default language 

    $tg_access_assign_subject_default = 'You have been enrolled to #access_name#';
    $tg_access_assign_body_default = '
    Dear #display_name#,

    You are assigned to #access_name#

    Please click here to login: #site_url#

    Kind regards,
    <strong>TeachGround</strong>';
    // user assigned to course email body //

    // user assigned to course email body admin //
    $tg_access_assign_body_admin_default = '
    Dear Admin,

    #display_name# is assigned to #access_name#

    Kind regards,
    <strong>TeachGround</strong>';
    // user assigned to course email body admin //

    // user unassigned from course email subject & body //
    $tg_access_unassign_subject_default = 'You have been unenrolled from #access_name#';
    $tg_access_unassign_body_default = '
    Dear #display_name#,

    You are unassigned from #access_name#

    Please contact our support if you have any questions.

    Kind regards,
    <strong>TeachGround</strong>';
    // user unassigned from course email body //

    // user unassigned from course email body admin //
    $tg_access_unassign_body_admin_default = '
    Dear Admin,

    #display_name# is unassigned from #access_name#

    Kind regards,
    <strong>TeachGround</strong>';
    // user unassigned from course email body admin //

    // user inserted email body user //
    $tg_new_user_inserted_subject_default = 'New user created';
    $tg_new_user_inserted_body_default = '
    Dear #display_name#,

    You are successfully registered to the site.
    Username: #user_email#
    Password: #user_password#
    Site URL: #site_url#

    Kind regards,
    <strong>TeachGround</strong>';
    // user inserted email body user //

    // user inserted email body admin //
    $tg_new_user_inserted_body_admin_default = '
    Dear Admin,

    New user is added on #site_url#
    Username: #user_email#

    Kind regards,
    <strong>TeachGround</strong>';
    // user inserted email body admin //

    // forgot password emails // 
    $tg_forgot_password_link_mail_subject_default = 'Reset Password Link';
    $tg_forgot_password_link_mail_body_default = '
    You have requested that the password be reset for the following account:
    #site_url#
    Username: #user_name#
    If this was a mistake, just ignore this email and nothing will happen.
    To reset your password, visit the following address:
    #resetlink#

    Kind regards,
    <strong>TeachGround</strong>';
    
    $tg_new_password_mail_subject_default = 'New Password Email';
    $tg_new_password_mail_body_default = '
    Your new password for the account at:

    #site_url#

    Username: #user_name#
    Password: #user_password#

    You can now login with your new password at:
    #site_url#

    Kind regards,
    <strong>TeachGround</strong>';

    // forgot password emails // 

}
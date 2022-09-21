<?php

/*
Plugin Name: Проверка IP комментариев
Description:
Version: 0.2
Author: Войцеховский Вячеслав
Author URI: https://vyacheslav-v.ru
*/


add_action('wp_enqueue_scripts', 'addJsToTheme');
function addJsToTheme()
{
    $pluginDirUrl = plugin_dir_url(__FILE__);
    wp_enqueue_script('google-map', "{$pluginDirUrl}/script.js", false, false, true);
}

add_filter('comment_form_defaults', 'addIpFieldToComent');
function addIpFieldToComent(array $defaults): array
{
    $defaults['fields']['ip'] = "<input type='hidden' name='client-ip' />";
    return $defaults;
}

add_filter('pre_comment_approved', 'checkCommentIp');
function checkCommentIp($approved)
{
    if (!isset($_POST['client-ip'])) {
        return new WP_Error('comment_closed', __('Sorry, we can not detected client-ip field.'), 403);
    }
    $clientIp = getIPAddress();
    if ($clientIp !== $_POST['client-ip']) {
        return new WP_Error('comment_closed', __('Sorry, comments are closed for this item.'), 403);
    }
    return $approved;
}

function getIPAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
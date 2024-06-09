<?php

/**
 * @package Integrao com Sistema
 */
/*
Plugin Name: Point PRO7
Plugin URI: https://pointpro7.com/
Description: Plugin criado para integração e sincronismo de dados para a api
Version: 1.0
Author: Thiago Lovatine
Author URI: https://pointpro7.com/
License: GPLv2 or later
Text Domain: pointpro7
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/



function user_updated_profile($user_id = null)
{
    $user = get_userdata('', $user_id);

    $curl = curl_init('https://api.universojuridico.net.br/api/woocommerce_membership_updated');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, array('user' => $user, 'user_id' => $user_id));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
}

add_action('woocommerce_update_customer', 'user_updated_profile');

function pw_load_scripts()
{

    if ($user = wp_get_current_user()) {

        wp_enqueue_script('uj-script', plugin_dir_url(__FILE__) . 'js/uj-script.js');
        wp_localize_script(
            'uj-script',
            'pw_script_vars',
            array(
                'alert' => $user,
                'message' => __('You have clicked the other button. Good job!', 'pippin')
            )
        );
    }
}
add_action('wp_enqueue_scripts', 'pw_load_scripts');

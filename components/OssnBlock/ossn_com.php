<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.Open Source Social Network.org/licence
 * @link      http://www.Open Source Social Network.org/licence
 */

/* Define Paths */
define('__OSSN_BLOCK__', ossn_route()->com . 'OssnBlock/');

/* Load OssnBlock Class */
require_once(__OSSN_BLOCK__ . 'classes/OssnBlock.php');

/**
 * Initialize the block component.
 *
 * @return void;
 * @access private;
 */
function ossn_block() {
    //callbacks
    ossn_register_callback('page', 'load:profile', 'ossn_user_block_menu', 100);

    //hooks
    ossn_add_hook('page', 'load', 'ossn_user_block');

    //actions
    if (ossn_isLoggedin()) {
        ossn_register_action('block/user', __OSSN_BLOCK__ . 'actions/user/block.php');
        ossn_register_action('unblock/user', __OSSN_BLOCK__ . 'actions/user/unblock.php');
    }

}

/**
 * User block menu item in profile.
 *
 * @return void;
 * @access private;
 */
function ossn_user_block_menu($name, $type, $params) {
    $user = ossn_user_by_guid(ossn_get_page_owner_guid());
    if (OssnBlock::isBlocked(ossn_loggedin_user(), $user)) {
        $unblock = ossn_site_url("action/unblock/user?user={$user->guid}", true);
        ossn_register_menu_link('block', ossn_print('user:unblock'), $unblock, 'profile_extramenu');
    } else {
        $block = ossn_site_url("action/block/user?user={$user->guid}", true);
        ossn_register_menu_link('block', ossn_print('user:block'), $block, 'profile_extramenu');
    }
}

/**
 * Check user blocks.
 *
 * @return void;
 * @access private;
 */
function ossn_user_block($name, $type, $return, $params) {

    /*
    * Deny from visiting profile
    */
    if ($params['handler'] == 'u') {
        $user = ossn_user_by_username($params['page'][0]);
        if (OssnBlock::UserBlockCheck($user)) {
            ossn_error_page();
        }
    }
    /*
    * Deny from sending messages
    */
    if ($params['handler'] == 'messages' && isset($params['page'][1])) {
        $user = ossn_user_by_username($params['page'][1]);
        if ($user && OssnBlock::UserBlockCheck($user)) {
            ossn_error_page();
        }
    }
    /*
    * Deny from viewing user wall posts
    */
    if ($params['handler'] == 'post' && $params['page'][0] == 'view' && com_is_active('OssnWall')) {
        $post = new OssnWall;
        $post = $post->GetPost($params['page'][1]);
        $user = ossn_user_by_guid($post->owner_guid);
        if (OssnBlock::UserBlockCheck($user)) {
            ossn_error_page();
        }
    }
    /*
    * Deny from viewing profile photos album and albums
    */
    if ($params['handler'] == 'album') {
        //check if album is profile photos
        if ($params['page'][0] == 'profile') {
            $user = ossn_user_by_guid($params['page'][1]);
            //if album is not profile photos album then it means it simple album
        } elseif ($params['page'][0] == 'view') {
            $album = new OssnAlbums;
            $album = $album->GetAlbum($params['page'][1]);
            $user = ossn_user_by_guid($album->album->owner_guid);
        }
        if (isset($user) && OssnBlock::UserBlockCheck($user)) {
            ossn_error_page();
        }
    }
}

ossn_register_callback('ossn', 'init', 'ossn_block');

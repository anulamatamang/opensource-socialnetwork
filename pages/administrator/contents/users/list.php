<?php
/**
 * Open Source Social Network
 *
 * @package   (Informatikon.com).ossn
 * @author    OSSN Core Team <info@opensource-socialnetwork.org>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
echo ossn_view_form('admin/users/list_search', array(
    'action' => ossn_site_url('administrator/users'),
    'class' => 'ossn-admin-form',
));
echo ossn_view_form('admin/users/list', array(
    'action' => ossn_site_url('action/admin/users/delete'),
    'class' => 'ossn-admin-form',
));
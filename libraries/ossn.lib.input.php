<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */

/**
 * Get input from user; using secure method;
 * @params: $input = name of input;
 * @params:  $validate = if you don't want to encode to html entities then add 1 as second arg in function;
 * @last edit: $arsalanshah
 * @Reason: Initial;
 *
 */
function input($input, $validate = '') {
    $replacements = array(
        "\x00" => '\x00',
        "\n" => '\n',
        "\r" => '\r',
        "\\" => '\\\\',
        "'" => "\'",
        '"' => '\"',
        "\x1a" => '\x1a'
    );
    if (isset($_REQUEST[$input]) && empty($validate)) {
        $data = htmlentities($_REQUEST[$input], ENT_QUOTES, 'UTF-8');
        return strtr($data, $replacements);
    } elseif ($validate == 1) {
        return strtr($input, $replacements);
    }
    return false;
}
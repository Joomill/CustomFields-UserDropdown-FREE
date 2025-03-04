<?php
/*
 *  package: Custom Fields - User Dropdown plugin - FREE  Version
 *  copyright: Copyright (c) 2023. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\Factory;

$value = $field->value;
$displayname = $field->fieldparams->get('displayname', 'both');

if ($value == '') {
    return;
}

$value = (array)$value;
$texts = array();

foreach ($value as $userId) {
    if (!$userId) {
        continue;
    }

    $user = Factory::getUser($userId);

    if ($user) {

        switch ($displayname) {
            case 'name':
                $texts[] = $user->name;
                break;
            case 'username':
                $texts[] = $user->username;
                break;
            case 'both':
            default:
                $texts[] = $user->name . ' (' . $user->username . ')';
                break;
        }


        continue;
    }

    // Fallback and add the User ID if we get no JUser Object
    $texts[] = $userId;
}

echo htmlentities(implode($field->fieldparams->get('separator', ', '), $texts));
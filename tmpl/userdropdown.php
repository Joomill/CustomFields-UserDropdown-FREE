<?php
/**
 * Custom Fields - Userdropdown plugin for Joomla
 *
 * @author Joomill (info@joomill-extensions.com)
 * @copyright Copyright (c) 2017 Joomill
 * @license GNU Public License
 * @link https://www.joomill-extensions.com/
 */

defined('_JEXEC') or die;

$value = $field->value;
$displayname = $field->fieldparams->get('displayname', 'both');

if ($value == '')
{
	return;
}

$value = (array) $value;
$texts = array();

foreach ($value as $userId)
{
	if (!$userId)
	{
		continue;
	}

	$user = JFactory::getUser($userId);

	if ($user)
	{

		switch ($displayname)
				{
					case 'name':
						$texts[] = $user->name;
						break;
					case 'username':
						$texts[] = $user->username;
						break;
					case 'both':
					default:
						$texts[] = $user->name.' ('. $user->username .')';
						break;
				}


		continue;
	}

	// Fallback and add the User ID if we get no JUser Object
	$texts[] = $userId;
}

echo htmlentities(implode($field->fieldparams->get('separator', ', '), $texts));
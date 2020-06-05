<?php
/**
 * Custom Fields - Userdropdown plugin for Joomla
 *
 * @author Joomill (info@joomill-extensions.com)
 * @copyright Copyright (c) 2017 Joomill
 * @license GNU Public License
 * @link https://www.joomill-extensions.com/
 */

defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldUserdropdown extends JFormFieldList
{

	protected function getOptions()
	{

		// Get selected parameters.
		$usergroup = $this->getAttribute('usergroup', "");
		$ordering = $this->getAttribute('ordering', "name");
		$dropdownname = $this->getAttribute('dropdownname', "both");
		$multiple = $this->getAttribute('multiple','false');
		
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user profile table where usergroup is the selected usergroup.
		$query->select ($db->quoteName(array('u.id', 'u.name', 'u.username')));
		$query->from($db->quoteName('#__users', 'u'));
	
		// Don't compare usergroup when "all"-option is selected.
		if ($usergroup != "") {
			$query->join('INNER', $db->quoteName('#__user_usergroup_map', 'm') . ' ON (' . $db->quoteName('u.id') . ' = ' . $db->quoteName('m.user_id') . ')');
			$query->where (($db->quoteName('m.group_id')) .'='. $usergroup);
		}
		// Group by id to show user once in dropdown.
		$query->group($db->quoteName(array('u.id')));

		switch ($ordering)
		{
			case 'id':
				$query->order('u.id ASC');
				break;
			case 'username':
				$query->order('u.username ASC');
				break;
			case 'name':
			default:
				$query->order('u.name ASC');
				break;
		}

		

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects.
		$results = $db->loadObjectList();

		// Prepare the empty array
		$options = array();
		
		// "Please select" option when parameter multiple is false.
		if ($multiple == "false") {
			$options[] = JHTML::_('select.option', '', '- Please select -' );
		}

		foreach ($results as $result) 
		{
			switch ($dropdownname)
				{
					case 'name':
						$options[] = JHtml::_('select.option', $result->id, $result->name);
						break;
					case 'username':
						$options[] = JHtml::_('select.option', $result->id, $result->username);
						break;
					case 'both':
					default:
						$options[] = JHtml::_('select.option', $result->id, $result->name.' ('. $result->username .')');
						break;
				}
		}

		return $options;
	}

}

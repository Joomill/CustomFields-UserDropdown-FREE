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
use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;

FormHelper::loadFieldClass('list');

class JFormFieldUserdropdown extends ListField
{

    protected function getOptions()
    {

        // Get selected parameters.
        $currentusergroup = $this->getAttribute('currentusergroup', "");
        $user = Factory::getUser();
        $groups = $user->groups;
        $currentusergroups = join(', ', $groups);

        $usergroup = $this->getAttribute('usergroup', "");
        $ordering = $this->getAttribute('ordering', "name");
        $dropdownname = $this->getAttribute('dropdownname', "both");
        $multiple = $this->getAttribute('multiple', 'false');

        // Get a db connection.
        $db = Factory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);

        // Select all records from the user profile table where usergroup is the selected usergroup.
        $query->select($db->quoteName(array('u.id', 'u.name', 'u.username')));
        $query->from($db->quoteName('#__users', 'u'));

        // Select all records from the user current users usergroups
        if ($currentusergroup != "") {
            $query->join('INNER', $db->quoteName('#__user_usergroup_map', 'm') . ' ON (' . $db->quoteName('u.id') . ' = ' . $db->quoteName('m.user_id') . ')');
            $query->where(($db->quoteName('m.group_id')) . ' IN (' . $currentusergroups . ')');
        } // Don't compare usergroup when "all"-option is selected.
        elseif ($usergroup != "") {
            $query->join('INNER', $db->quoteName('#__user_usergroup_map', 'm') . ' ON (' . $db->quoteName('u.id') . ' = ' . $db->quoteName('m.user_id') . ')');
            $query->where(($db->quoteName('m.group_id')) . ' IN (' . $usergroup . ')');
        }
        // Group by id to show user once in dropdown.
        $query->group($db->quoteName(array('u.id')));

        switch ($ordering) {
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
            $options[] = HTMLHelper::_('select.option', '', '- Please select -');
        }

        foreach ($results as $result) {
            switch ($dropdownname) {
                case 'name':
                    $options[] = HTMLHelper::_('select.option', $result->id, $result->name);
                    break;
                case 'username':
                    $options[] = HTMLHelper::_('select.option', $result->id, $result->username);
                    break;
                case 'both':
                default:
                    $options[] = HTMLHelper::_('select.option', $result->id, $result->name . ' (' . $result->username . ')');
                    break;
            }
        }

        return $options;
    }

}

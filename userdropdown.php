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

JLoader::import('components.com_fields.libraries.fieldsplugin', JPATH_ADMINISTRATOR);

class PlgFieldsUserdropdown extends FieldsPlugin
{


	public function onCustomFieldsPrepareDom($field, DOMElement $parent, JForm $form)
	{
		$fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);

		if (!$fieldNode)
		{
			return $fieldNode;
		}

		$form->addFieldPath(JPATH_PLUGINS . '/fields/userdropdown/elements/');

		$fieldNode->setAttribute('type', 'Userdropdown');
		
		return $fieldNode;
	}

}

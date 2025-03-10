<?php

/*
 *  package: Custom Fields - User Dropdown plugin - FREE Version
 *  copyright: Copyright (c) 2025. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

namespace Joomill\Plugin\Fields\Userdropdown\Extension;

// No direct access.
\defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormHelper;
use Joomla\Component\Fields\Administrator\Plugin\FieldsPlugin;

/**
 * Fields Text Plugin
 *
 * @since  3.7.0
 */
final class Userdropdown extends FieldsPlugin
{
	public function onCustomFieldsPrepareDom($field, \DOMElement $parent, Form $form)
	{
		$fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);

		if (!$fieldNode)
		{
			return $fieldNode;
		}

		// Get selected parameter for multiple selection.
		$multiple = $field->fieldparams->get('multiple', 'false');
		$fieldNode->setAttribute('multiple', $multiple);

		FormHelper::addFieldPrefix('Joomill\Plugin\Fields\Userdropdown\Field');
		return $fieldNode;
	}
}

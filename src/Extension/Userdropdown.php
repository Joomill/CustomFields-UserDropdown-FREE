<?php

/*
 *  package: Custom Fields - User Dropdown plugin - FREE Version
 *  copyright: Copyright (c) 2025. Jeroen Moolenschot | Joomill
 *  license: GNU General Public License version 3 or later
 *  link: https://www.joomill-extensions.com
 */

namespace Joomill\Plugin\Fields\Userdropdown\Extension;

use Joomla\CMS\Form\Form;
use Joomla\Component\Fields\Administrator\Plugin\FieldsPlugin;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

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

        if (!$fieldNode) {
            return $fieldNode;
        }

        $form->addFieldPath(JPATH_PLUGINS . '/fields/userdropdown/elements/');

        $fieldNode->setAttribute('type', 'Userdropdown');

        // Get selected parameter for multiple selection.
        $multiple = $field->fieldparams->get('multiple', 'false');
        $fieldNode->setAttribute('multiple', $multiple);

        return $fieldNode;
    }
}

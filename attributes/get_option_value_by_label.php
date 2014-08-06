<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * PHP Version 5.3
 *
 * @category  Mothership
 * @package   Mothership_Gists
 * @author    Don Bosco van Hoi <vanhoi@mothership.de>
 * @copyright 2014 Mothership GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.mothership.de/
 */

/**
 * If you need to get the option value. use this one
 *
 * @param string $attribute_code
 * @param string $attribute_value
 *
 * @return string|bool
 */
public function attributeValueExists($attribute_code, $attribute_value)
{
    $attribute_model        = \Mage::getModel('eav/entity_attribute');
    $attribute_options_model= \Mage::getModel('eav/entity_attribute_source_table') ;

    $attribute_id         = $attribute_model->getIdByCode('catalog_product', $attribute_code);
    $attribute              = $attribute_model->load($attribute_id);

    $attribute_options_model->setAttribute($attribute);
    $options                = $attribute_options_model->getAllOptions(false);

    foreach($options as $option)
    {
        if ($option['label'] == $attribute_value)
        {
            return $option['value'];
        }
    }

    return false;
}
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
 * You have a parent product and want to have all the children products, so the full product models
 */
$parent_product_id  = 1;
$parentProductModel = Mage::getModel('catalog/product')->load($parent_product_id);
$childProducts      = Mage::getModel('catalog/product_type_configurable')
                        ->getUsedProducts(null, $parentProduct);

foreach ($childProducts as $child) {
    print_r($child->getName());
}

/**
 * If you instead only need the ids, this would be more suitable.
 */
$childProducts = Mage::getModel('catalog/product_type_configurable')->getChildrenIds($parent_product_id);
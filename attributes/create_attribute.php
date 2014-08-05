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

// define some store ids
$store_id_de = 1;
$store_id_en = 2;
$store_id_fr = 3;


/**
 * You can use the following script to programmatically create one or more attributes.
 */
$attributes = array(
    array (
        //You can use any value for the attribute_code as long it is unique.
        'attribute_code'                => 'example',

        /**
         * You can choose between int, varchar, text, datetime or static. PYou neet to ensure that the
         * backend_type matches the frontend_input.
         *
         * For example:
         *
         * (boolean)     frontend -> (int) backend
         * (date)        frontend -> (datetime) backend
         * (media_image) frontend -> (varchar) backend
         * (price)       frontend -> (decimal) backend
         *
         * If you are not sure which one to use, just check the eav_attribute table and search for some examples.
         *
         */
        'backend_type'                  => 'int',
        'frontend_input'                => 'boolean',

        /**
         * The frontend label defines the labels for each store_id. This should
         * be self explained. Just put the labels with the store_ids as key and this should do the trick
         */
        'frontend_label'                => array (
                                            $store_id_de => 'Beispiel',
                                            $store_id_en => 'Example',
                                            $store_id_fr => 'Exemple',
                                        ),
        /**
         * Source models are an interesting concept. Most attributes will not need a source model
         * as you will only save simple informations. But there are scenarios where a source model might be useful.
         *
         * For example if you have the backend_type int, you could save any valid integer value. This is due to the
         * eav-model of magento which only supports a very limited amount of different data types. If you want to ensure
         * to only save a specific type of data, you need to specify a source model, which in this case is a boolean one.
         * You can also define your own source models like 'mothership/my_own_model'.
         *
         */
        'source_model'                  => 'eav/entity_attribute_source_boolean',

        /**
         * You can define the following scopes
         *
         * const SCOPE_STORE    = 0;
         * const SCOPE_GLOBAL   = 1;
         * const SCOPE_WEBSITE  = 2;
         */
        'global'                        => \Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,

        /**
         * Please check the magento backend for a more detailed description
         */
        'is_global'                     => 1,
        'is_visible'                    => 1,
        'is_searchable'                 => 0,
        'is_filterable'                 => 0,
        'is_comparable'                 => 0,
        'is_visible_on_front'           => 0,
        'is_html_allowed_on_front'      => 1,
        'is_used_for_price_rules'       => 0,
        'is_filterable_in_search'       => 0,
        'used_in_product_listing'       => 1,
        'used_for_sort_by'              => 0,

        // should this attribute be used for creating configurable products
        'is_configurable'               => 0,

        // to which product types should it be applied?
        'apply_to'                      => 'simple,configurable',
        'is_visible_in_advanced_search' => 0,
        'position'                      => 0,
        'is_wysiwyg_enabled'            => 0,
        'is_used_for_promo_rules'       => 0,
    ),
    // feel free to add new attributes
);

/**
 * Iterate the attributes save them in the shop
 */
foreach ($attributes as $attribute_data) {
    $model = \Mage::getModel('catalog/resource_eav_attribute');
    $model->addData($attribute_data);
    $model->setEntityTypeId(\Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId());
    $model->setIsUserDefined(1);
    $model->save();

    /**
     * You should use this if you have options
     */
    $setup = new \Mage_Eav_Model_Entity_Setup('core_setup');
    foreach ($options as $key => $option) {
        $attribute_options['value'][$attribute_data['attribute_code']][0] = $option;
        $setup->addAttributeOption($attribute_options);
    }

    $model->setStoreLabels($frontend_label)->save();
}

// Do it the fancy way. Just execute magerun dev:setup:script:attribute catalog_product color to export a sample script
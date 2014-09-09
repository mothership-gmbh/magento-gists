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

class Category
{
    const STORE_DE = 1;
    const STORE_EN = 2;
    const ROOT_CATEGORY_ID = 2;

    /**
     * Define an recursive directory structure
     *
     * @var array
     */
    protected $_categories
        = array (
            'name'     => 'test',
            'url-key'  => 'test',
            'children' => array (
                'name'     => 'test 2',
                'url-key'  => 'test 2',
                'children' => array (
                    'name'    => 'test 3',
                    'url-key' => 'test 3',

                )
            )
        );

    /**
     * Start the category import
     */
    public function process()
    {
        $this->addCategory(self::ROOT_CATEGORY_ID, $this->_categories);
    }

    /**
     * Get the parent category of the current category ids
     */

    /**
     * This is the recursive function for the new category and should be started in the
     * process() method
     *
     * @param int   $parentCategoryId
     * @param mixed $categoryData
     *
     * @return void
     */
    public function addCategory($parentCategoryId, $categoryData)
    {
        /*  @var $installer Mothership_Migration_Model_Setup */
        $parentCategoryId = $this->create($parentCategoryId, $categoryData);

        if (!array_key_exists('children', $categoryData)) {
            return;
        }

        // If there are children, start the recursive import
        foreach ($categoryData['children'] as $childrenCategoryData) {
            $this->addCategory($parentCategoryId, $childrenCategoryData);
        }
    }

    /**
     * Create and save a new category
     *
     * @param int   $parentId
     * @param mixed $categoryData
     *
     * @return int  The category id of the created category
     */
    protected function create($parent_id, $category_data)
    {
        $parentCategory = \Mage::getModel('catalog/category')->load($parent_id);

        \Mage::app()->getStore()->setId(0);

        /* @var Mage_Core_Model $category */
        $category = \Mage::getModel('catalog/category');
        $category->setPath($parentCategory->getPath());
        $general['name']             = $category_data['name'];
        $general['display_mode']     = "PRODUCTS_AND_PAGE"; //static block and the products are shown on the page
        $general['is_active']        = 1;
        $general['is_anchor']        = 1;

        $general['url_key']          = $category_data['url_key']; //url to be used for this category's page by magento.
        $category->addData($general);
        $category->save();

        // will be needed later for the return
        $category_id = $category->getId();

        // If you have another language, then set it here
        \Mage::app()->getStore()->setId(self::STORE_DE);
        $general['name']  = $category_data['name'];
        $category->addData($general);
        $category->save();

        \Mage::app()->getStore()->setId(self::STORE_EN);
        $general['name']  = $category_data['name'];
        $category->addData($general);
        $category->save();

        // This is the most important part for the working recursion as the script needs the category id
        return $category_id;
    }
}


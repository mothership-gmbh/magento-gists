magento-gists
=============

helpful magento gists


Skin JS
=========
A bunch of useful plugins we use in almost every Magento project. Some of them need som tweaks or custom css to fit the projects environment.

# Local Storage Popup
* A popup function which displays a popup in in the middle of the screen after 3 page visits and sets an entry in the user's local storage for 24 hours.

# Image Reveal
* This is useful for long pages with many or big images. Images are initially loaded with an placeholder and the actual image is revealed if it'svisible in the viewport.

# Mail Disguise
* This little email spam protection, allows you to use an almost blank email link in the templates or CMS pages, so that bots aren't able to scrape them.

# Mobile Dropdown Menu
* In Magento we use a lot of menus made of list elements. But when it comes to mobile devices these are not very user friendly. In this case list elements are transformed into select elements which are much better to use on mobile devices.

# Responsive Images
* Many sliders or content images are quite big or in wrong proportions for mobile freindly views. This allows to integrate special images for different viewports.

# Truncate
* Description texts can be quite long, so it is useful to have them truncated. This allows to set a certain text Length and shows a 'read more' button

# Mage Zoom
* This is a zoom / popup plugin for product images on the product details page. It is customized for magento but might work in other projects as well, after a few tweaks.

# Use Storage
* A lightweight javascript class to call when working with local/session Storage. 
* * Read data from storage `UseStorage.getData('storageType', key)` returns Object
* * Write data to storage `UseStorage.setData('storageType', key, value)` writes JSON String
* * Update data `UseStorage.updateData('storageType', key, property, value)` updates property Value in JSON
* * Remove data `UseStorage.removeData('storageType', key)` clears storage entry by key
* * Clear data `UseStorage.clearData('storageType')` clears full storage for domain
* 
# Constants Mage_Catalog_Model_Product_Visibility

```
  const VISIBILITY_NOT_VISIBLE    = 1;
  const VISIBILITY_IN_CATALOG     = 2;
  const VISIBILITY_IN_SEARCH      = 3;
  const VISIBILITY_BOTH           = 4;
```

# Constants Mage_Catalog_Model_Product_Status

```
  const STATUS_ENABLED    = 1;
  const STATUS_DISABLED   = 2;
```

# Constants Mage_Catalog_Model_Product_Type

```
  const TYPE_SIMPLE       = 'simple';
  const TYPE_BUNDLE       = 'bundle';
  const TYPE_CONFIGURABLE = 'configurable';
  const TYPE_GROUPED      = 'grouped';
  const TYPE_VIRTUAL      = 'virtual';

  const DEFAULT_TYPE      = 'simple';
  const DEFAULT_TYPE_MODEL    = 'catalog/product_type_simple';
  const DEFAULT_PRICE_MODEL   = 'catalog/product_type_price';
```

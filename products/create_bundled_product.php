<?php
/**
 * Initialize the bundle, and set the default settings
 *
 * http://stackoverflow.com/questions/3130499/how-to-set-sku-type-price-type-of-bundle-product-programmatically-in-magento
 *
 * Für Übersetzungen: $this->__("Engagementring")
 */
$bundledProduct = Mage::getModel('catalog/product');

$sku = 'CHAIN-' . uniqid();

$bundledData = array(
    'sku_type'          => 0,
    'sku'               => $sku,
    'name'              => $sku,
    'description'       => $sku,
    'short_description' => $sku,
    'type_id'           => 'bundle',
    'attribute_set_id'  =>  \AppModel::ATTRIBUTE_SET_ID_CHAIN,
    'weight_type'       => 0,
    'visibility'        => 1,
    'price_type'        => 0,
    'price_view'        => 0,
    'status'            => 1,
    'created_at'        => strtotime('now'),
    'category_ids'      => array(2), // Standard Hauptkategorie
    'store_id'          => Mage::app()->getStore()->getId(),
    'website_ids'       => array(1),
    'inventory_stock_availability' => 1,

    'categorych_id'     => $data['Chain']['CCID'],
    'from_chain'        => $data['Chain']['from_chain'],
    /**
     * Komma separierte Liste von Elementen. Das ist eigentlich Legacy, da dieses Attribut
     * bereits durch die verknüpften Kinderprodukte gelöst wird.
     */
    'elements'          => $data['Chain']['elements'],

    /**
     * Auch dieses Element ist eigentlich Legacy. das entsprechende Counterpart sind nun Fäden als
     * verknüpfte Kinderprodukte
     */
    'thread'            => $data['Chain']['thread'],
    'length'            => $data['Chain']['length'],
    'creator_id'        => $data['Chain']['creator_id'],
);

$bundledProduct->setData($bundledData);
Mage::register('product', $bundledProduct);


/**
 * Registriert die Optionen für die verküpften Produkte
 *
 * Required Properties of Bundle Options are:-
 * 1. title
 * 2. option_id
 * 3. delete
 * 4. type
 * 5. required
 * 6. position
 * 7. default_title
 */
$optionRawData = array();
$optionRawData[0] = array(
    'required'      => 0,
    'option_id'     => '',
    'position'      => 0,
    'type'          => 'select',
    'title'         => 'Faden',
    'default_title' => 'Faden',
    'delete'        => '',
);

$optionRawData[1] = array(
    'required'      => 0,
    'option_id'     => '',
    'position'      => 0,
    'type'          => 'select',
    'title'         => 'Ring',
    'default_title' => 'Ring',
    'delete'        => '',
);

$optionRawData[2] = array(
    'required'      => 0,
    'option_id'     => '',
    'position'      => 1,
    'type'          => 'select',
    'title'         => 'Element (Anhänger)',
    'default_title' => 'Element (Anhänger)',
    'delete'        => '',
);


/**
 * Alle Elemente durchgehen und je nachdem um was es sich für Elemente handelt, werden die entsprechend eingeordnet.
 * Ordne die Elemente nach Attribut-Set ein
 *
 * Ringe sind zum Beispiel als Ring einzuordnen.
 */

foreach ($data['Elements'] as $key => $value) {
    $product = Mage::getModel('catalog/product')->load($value['EID']);
    switch ($product->getAttributeSetId()) {

        case \AppModel::ATTRIBUTE_SET_ID_THREAD:
            $selectionRawData[0][] = array(
                'product_id'               => $value['EID'],
                'selection_qty'            => 1,
                'selection_can_change_qty' => 0,
                'position'                 => 0,
                'is_default'               => 1,
                'selection_id'             => '',
                'selection_price_type'     => 0,
                'selection_price_value'    => 0.0,
                'option_id'                => '',
                'delete'                   => ''
            );
            break;


        case \AppModel::ATTRIBUTE_SET_ID_RING:
            $product_id = $this->_getRingBySizeAndParentEntityId($value['EID'], $value['ring_size']);
            $selectionRawData[1][] = array(
                'product_id'               => $product_id,
                'selection_qty'            => 1,
                'selection_can_change_qty' => 0,
                'position'                 => 0,
                'is_default'               => 1,
                'selection_id'             => '',
                'selection_price_type'     => 0,
                'selection_price_value'    => 0.0,
                'option_id'                => '',
                'delete'                   => ''
            );
            break;


        case \AppModel::ATTRIBUTE_SET_ID_PENDANT:
            $selectionRawData[2][] = array(
                'product_id'               => $value['EID'],
                'selection_qty'            => 1,
                'selection_can_change_qty' => 0,
                'position'                 => 0,
                'is_default'               => 1,
                'selection_id'             => '',
                'selection_price_type'     => 0,
                'selection_price_value'    => 0.0,
                'option_id'                => '',
                'delete'                   => ''
            );
            break;

        default:
            $selectionRawData[3][] = array(
                'product_id'               => $value['EID'],
                'selection_qty'            => 1,
                'selection_can_change_qty' => 0,
                'position'                 => 0,
                'is_default'               => 1,
                'selection_id'             => '',
                'selection_price_type'     => 0,
                'selection_price_value'    => 0.0,
                'option_id'                => '',
                'delete'                   => ''
            );
            break;
    }
}

if (!empty($data['Thread'])) {
    $selectionRawData[0][] = array(
        'product_id'               => $data['Thread']['EID'],
        'selection_qty'            => 1,
        'selection_can_change_qty' => 0,
        'position'                 => 0,
        'is_default'               => 1,
        'selection_id'             => '',
        'selection_price_type'     => 0,
        'selection_price_value'    => 0.0,
        'option_id'                => '',
        'delete'                   => ''
    );
}


\Mage::unregister('product');
\Mage::unregister('current_product');

// important due http://stackoverflow.com/questions/13584034/magento-programmaticaly-create-bundle-product
\Mage::register('product', $bundledProduct);
\Mage::register('current_product', $bundledProduct);

$bundledProduct->setCanSaveConfigurableAttributes(false);
$bundledProduct->setCanSaveCustomOptions(true);

$bundledProduct->setBundleOptionsData($optionRawData);
$bundledProduct->setBundleSelectionsData($selectionRawData);

$bundledProduct->save();
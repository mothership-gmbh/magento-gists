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

$_customer = array (
    'firstname'     => 'Max',
    'lastname'      => 'Mustermann',
    'email'         => 'max@mustermann.de',
    'password'      => '123abc!',
    'password_hash' => 'b7a9552802ce455e170a1c73a47796e4:6c',
    'add_date'      => '2010-01-21 13:37:00',
    'birth_date'    => '1980-01-01',
    'gender'        => 1, // Male (1) or Female (2)

    // billing address
    'street'        => 'Nymphenburgerstraße',
    'street_number' => '86',
    'address_info'  => '1. Floor',
    'city'          => 'Munich',
    'company'       => 'Mothership GmbH',
    'postcode'      => '80636',
    'country_id'    => 'DE',
    'telephone'     => '+49 (0) 160 938 29 815',
    'fax'           => ''
);

$websiteId = \Mage::app()->getWebsite()->getId();
$store     = \Mage::app()->getStore();

/**
 * Create the customer
 */
$customer = \Mage::getModel('customer/customer');
$customer->setWebsiteId($websiteId)
    ->setStore($store)
    ->setFirstname(   $_customer['firstname'])
    ->setLastname(    $_customer['lastname'])
    ->setEmail(       $_customer['email'])
    ->setPasswordHash($_customer['password'])
    ->setCreatedAt(   $_customer['add_date'])
    ->setDob(         $_customer['birth_date'])
    ->setGender(      $_customer['gender']);
try {
    $customer->save();
    $customer->setConfirmation(null); // confirm the account, AFTER it has been created
    $customer->setStatus(1); // enable the account, AFTER it has been created
    $customer->save();

    // set billing address
    $_custom_address = array (
        'firstname'  => $_customer['firstname'],
        'lastname'   => $_customer['lastname'],
        'street'     => array (
            '0' => $_customer['street'] . ' ' . $_customer['street_number'],
            '1' => $_customer['address_info']
        ),
        'city'       => $_customer['city'],
        'company'    => $_customer['company'],
        'postcode'   => $_customer['zip'],
        'country_id' => $_customer['country_id'],
        'telephone'  => $_customer['telephone'],
        'fax'        => $_customer['fax'],

    );
    $customAddress   = \Mage::getModel('customer/address');
    $customAddress->setData($_custom_address)
        ->setCustomerId($customer->getId())
        ->setIsDefaultBilling('1')
        ->setSaveInAddressBook('1');
    $customAddress->save();


    // if you have an alternate shipping address, use the following code in addition
    //\Mage::getSingleton('checkout/session')->getQuote()->setShippingAddress(
    //    \Mage::getSingleton('sales/quote_address')->importCustomerAddress($customAddress)
    //);
} catch (Exception $e) {
    Zend_Debug::dump($e->getMessage());
}
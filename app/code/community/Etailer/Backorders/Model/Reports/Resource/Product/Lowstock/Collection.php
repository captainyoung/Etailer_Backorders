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
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Reports
 * @copyright  Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product Low Stock Report Collection
 *
 * @category    Mage
 * @package     Mage_Reports
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Etailer_Backorders_Model_Reports_Resource_Product_Lowstock_Collection extends Mage_Reports_Model_Resource_Product_Lowstock_Collection 
{
    /**
     * Add Notify Stock Qty Condition to collection
     *
     * @param int $storeId
     * @return Mage_Reports_Model_Resource_Product_Lowstock_Collection
     */
    public function useNotifyStockQtyFilter($storeId = null)
    {
      	$this->joinInventoryItem(array('qty'));
        $notifyStockExpr = $this->getConnection()->getCheckSql(
            $this->_getInventoryItemField('use_config_notify_stock_qty') . ' = 1',
            (int)Mage::getStoreConfig(Mage_CatalogInventory_Model_Stock_Item::XML_PATH_NOTIFY_STOCK_QTY, $storeId),
            $this->_getInventoryItemField('notify_stock_qty')
        );
        $where = $this->_inventoryItemTableAlias . '.qty < ?';
        $this->getSelect()->where($where, $notifyStockExpr);
        return $this;
    }
}

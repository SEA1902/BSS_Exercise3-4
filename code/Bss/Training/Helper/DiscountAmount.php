<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bss\Training\Helper;

use Magento\Customer\Api\GroupManagementInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\Store;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
/**
 * MinSaleQty value manipulation helper
 */
class DiscountAmount extends AbstractHelper
{
    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Math\Random
     */
    protected $mathRandom;

    /**
     * @var GroupManagementInterface
     */
    protected $groupManagement;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Math\Random $mathRandom
     * @param GroupManagementInterface $groupManagement
     * @param Json|null $serializer
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Math\Random                     $mathRandom,
        GroupManagementInterface                           $groupManagement,
        Json                                               $serializer = null
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->mathRandom = $mathRandom;
        $this->groupManagement = $groupManagement;
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
    }

    /**
     * Retrieve fixed qty value
     *
     * @param int|float|string|null $qty
     * @return float|null
     */
    protected function fixQty($qty)
    {
        return !empty($qty) ? (float)$qty : null;
    }

    /**
     * Generate a storable representation of a value
     *
     * @param int|float|string|array $value
     * @return string
     */
    protected function serializeValue($value)
    {
        if (is_numeric($value)) {
            $data = (float)$value;
            return (string)$data;
        } elseif (is_array($value)) {
            $data = [];
            foreach ($value as $groupId => $qty) {
                if (!array_key_exists($groupId, $data)) {
                    $data[$groupId] = $this->fixQty($qty);
                }
            }
            if (count($data) == 1 && array_key_exists($this->getAllCustomersGroupId(), $data)) {
                return (string)$data[$this->getAllCustomersGroupId()];
            }
            return $this->serializer->serialize($data);
        } else {
            return $value;
        }
    }

    /**
     * Create a value from a storable representation
     *
     * @param int|float|string $value
     * @return array
     */
    protected function unserializeValue($value)
    {
        if (is_numeric($value)) {
            return [$this->getAllCustomersGroupId() => $this->fixQty($value)];
        } elseif (is_string($value) && !empty($value)) {
            return $this->serializer->unserialize($value);
        } else {
            return [];
        }
    }

    /**
     * Check whether value is in form retrieved by _encodeArrayFieldValue()
     *
     * @param string|array $value
     * @return bool
     */
    protected function isEncodedArrayFieldValue($value)
    {
        if (!is_array($value)) {
            return false;
        }
        unset($value['__empty']);
        foreach ($value as $row) {
            if (!is_array($row)
                || !array_key_exists('customer_group_id', $row)
                || !array_key_exists('discount_amount', $row)
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Encode value to be used in \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param array $value
     * @return array
     */
    protected function encodeArrayFieldValue(array $value)
    {
        $result = [];
        foreach ($value as $groupId => $qty) {
            $resultId = $this->mathRandom->getUniqueHash('_');
            $result[$resultId] = ['customer_group_id' => $groupId, 'discount_amount' => $this->fixQty($qty)];
        }
        return $result;
    }

    /**
     * Decode value from used in \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param array $value
     * @return array
     */
    protected function decodeArrayFieldValue(array $value)
    {
        $result = [];
        unset($value['__empty']);
        foreach ($value as $row) {
            if (!is_array($row)
                || !array_key_exists('customer_group_id', $row)
                || !array_key_exists('discount_amount', $row)
            ) {
                continue;
            }
            $groupId = $row['customer_group_id'];
            $qty = $this->fixQty($row['discount_amount']);
            $result[$groupId] = $qty;
        }
        return $result;
    }

    /**
     * Make value readable by \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param string|array $value
     * @return array
     */
    public function makeArrayFieldValue($value)
    {
        $value = $this->unserializeValue($value);
        if (!$this->isEncodedArrayFieldValue($value)) {
            $value = $this->encodeArrayFieldValue($value);
        }
        return $value;
    }

    /**
     * Make value ready for store
     *
     * @param string|array $value
     * @return string
     */
    public function makeStorableArrayFieldValue($value)
    {
        if ($this->isEncodedArrayFieldValue($value)) {
            $value = $this->decodeArrayFieldValue($value);
        }
        $value = $this->serializeValue($value);
        return $value;
    }

    /**
     * Return the all customer group id
     *
     * @return int$store
     */
    protected function getAllCustomersGroupId()
    {
        return $this->groupManagement->getAllCustomersGroup()->getId();
    }

    public function getData() {
        return $this->scopeConfig->getValue(
            "general/discount_price_per_customer_group",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,null
        );
    }
}

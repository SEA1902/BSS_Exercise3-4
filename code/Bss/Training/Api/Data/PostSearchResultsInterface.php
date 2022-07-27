<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Bss\Training\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms page search results.
 * @api
 * @since 100.0.2
 */
interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return \Bss\Training\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param \Bss\Training\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

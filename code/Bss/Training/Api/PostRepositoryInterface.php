<?php
namespace Bss\Training\Api;

use Bss\Training\Api\Data\PostInterface;

interface PostRepositoryInterface
{
    /**
     * Return a filtered product.
     *
     * @param int $id
     * @return \Bss\Training\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id);

    /**
     * Return a filtered product.
     * @return \Bss\Training\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bss\Training\Api\Data\PostSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
    /**
     * Set descriptions for the products.
     *
     * @param \Bss\Training\Api\Data\PostInterface $post
     * @return \Bss\Training\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(PostInterface $post);

    /**
     * Delete post.
     *
     * @param \Bss\Training\Api\Data\PostInterface $post
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Bss\Training\Api\Data\PostInterface $post);
    /**
     * Delete post by ID.
     *
     * @param int $postId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($postId);
}

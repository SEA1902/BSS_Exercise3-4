<?php

namespace Bss\Training\Model;

use Bss\Training\Api\Data\PostInterface;
use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel implements PostInterface
{
    protected function _construct()
    {
        $this->_init(\Bss\Training\Model\ResourceModel\Post::class);
    }

    /**
     * @inheritDoc
     */
    public function setContent(string $value)
    {
        $this->setData(self::CONTENT, $value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function getPostId(): int
    {
        return (int) $this->getData(self::POST_ID);
    }

    /**
     * @inheritDoc
     */
    public function setPostId($id): \Bss\Training\Api\Data\PostInterface
    {
        return $this->setData(self::POST_ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): \Bss\Training\Api\Data\PostInterface
    {
        return $this->setData(self::TITLE, $title);
    }
    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $created): \Bss\Training\Api\Data\PostInterface
    {
        return $this->setData(self::CREATED_AT, $created);
    }
    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updated): \Bss\Training\Api\Data\PostInterface
    {
        return $this->setData(self::UPDATED_AT, $updated);
    }
}

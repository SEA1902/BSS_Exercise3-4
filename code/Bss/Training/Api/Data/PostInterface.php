<?php

namespace Bss\Training\Api\Data;

interface PostInterface
{
    const CONTENT = 'content';
    const POST_ID = 'post_id';
    const TITLE = 'title';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setContent(string $value);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return int
     */
    public function getPostId(): int;

    /**
     * @param mixed $id
     * @return $this
     */
    public function setPostId($id): self;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $created
     * @return $this
     */
    public function setCreatedAt(string $created): self;
    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updated
     * @return $this
     */
    public function setUpdatedAt(string $updated): self;
}

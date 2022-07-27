<?php
namespace Bss\Training\Model;
use Bss\Training\Api\PostRepositoryInterface;
use Bss\Training\Api\Data\PostInterface;
use Bss\Training\Api\Data\PostInterfaceFactory;
use Bss\Training\Api\Data\PostSearchResultsInterface;
use Bss\Training\Api\Data\PostSearchResultsInterfaceFactory;
use Bss\Training\Model\Api\SearchCriteria\PostCollectionProcessor;
use Bss\Training\Model\ResourceModel\Post as ResourcePost;
use Bss\Training\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class PostRepository implements PostRepositoryInterface
{
    protected $date;
    /**
     * @var ResourcePost
     */
    protected $resource;
    /**
     * @var PostFactory
     */
    private $postFactory;
    /**
     * @var PostCollectionFactory
     */
    private $postCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var PostSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var PostInterfaceFactory
     */
    protected $dataPostFactory;
    /**
     * @var ResourceModel\Post
     */
    private $postResourceModel;

    /**
     * @param ResourcePost $resource
     * @param PostFactory $postFactory
     * @param PostInterfaceFactory $dataPageFactory
     * @param PostCollectionFactory $pageCollectionFactory
     * @param Data\PostSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
    \Magento\Framework\Stdlib\DateTime\DateTime $date,
    ResourcePost $resource,
    PostFactory $postFactory,
    PostInterfaceFactory $dataPostFactory,
    Post $postResourceModel,
    CollectionProcessorInterface $collectionProcessor = null,
    PostSearchResultsInterfaceFactory $searchResultsFactory,
    PostCollectionFactory $postCollectionFactory
    ) {
        $this->date = $date;
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->dataPostFactory = $dataPostFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->postResourceModel = $postResourceModel;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * {@inheritdoc}
     */
    public function save(PostInterface $post)
    {
        $currentTime = $this->date->gmtDate();
        if (!empty($post->getPostId())) {
            $post = $this->getById((int) $post->getPostId());
        } else{
            $post->setData(PostInterface::CREATED_AT, $currentTime);
        }
        $post->setData(PostInterface::UPDATED_AT, $currentTime);

        $this->postResourceModel->save($post);
        return 'success';
        //Customize the code as per your requirement.

    }
    /**
     * Load Page data by given Page Identity
     *
     * @param string $postId
     * @return Post
     * @throws NoSuchEntityException
     */
    public function getById($postId)
    {
        $post = $this->postFactory->create();
        $this->postResourceModel->load($post, $postId);

        if (!$post->getPostId()) {
            throw new NoSuchEntityException(__("Post not found!"));
        }

        return $post;
    }
    /**
     * Load Post data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return PostSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->postCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
    /**
     * Delete Page
     *
     * @param PostInterface $post
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(PostInterface $post)
    {
        try {
            $this->resource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the page: %1', $exception->getMessage())
            );
        }
        return true;
    }
    /**
     * Delete Page by given Page Identity
     *
     * @param string $postId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($postId)
    {
        return $this->delete($this->getById($postId));
    }
    /**
     * Retrieve collection processor
     *
     * @deprecated 102.0.0
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            // phpstan:ignore "Class Bss\Training\Model\Api\SearchCriteria\PostCollectionProcessor not found."
            $this->collectionProcessor = ObjectManager::getInstance()
                ->get(PostCollectionProcessor::class);
        }
        return $this->collectionProcessor;
    }
}

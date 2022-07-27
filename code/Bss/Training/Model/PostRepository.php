<?php
namespace Bss\Training\Model;
use Bss\Training\Api\PostRepositoryInterface;
use Bss\Training\Api\Data\PostInterface;
use Bss\Training\Api\Data\PostInterfaceFactory;
use Bss\Training\Api\Data\PostSearchResultsInterface;
use Bss\Training\Api\Data\PostSearchResultsInterfaceFactory;
use Bss\Training\Model\Api\SearchCriteria\PostCollectionProcessor;
use Bss\Training\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\NoSuchEntityException;

class PostRepository implements PostRepositoryInterface
{
    protected $date;
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
     * @var ResourceModel\Post
     */
    private $postResourceModel;

    public function __construct(
    \Magento\Framework\Stdlib\DateTime\DateTime $date,
    \Bss\Training\Model\PostFactory $postFactory,
    \Bss\Training\Model\ResourceModel\Post $postResourceModel,
    CollectionProcessorInterface $collectionProcessor = null,
    PostSearchResultsInterfaceFactory $searchResultsFactory,
    PostCollectionFactory $postCollectionFactory
    ) {
        $this->date = $date;
        $this->postFactory = $postFactory;
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
        if (!empty($post->getPostId())) {
            $post = $this->getById((int) $post->getPostId());
        }
        $currentTime = $this->date->gmtDate();
        $post->setData(PostInterface::CREATED_AT, $currentTime);
        $post->setData(PostInterface::UPDATED_AT, $currentTime);

        $this->postResourceModel->save($post);
        return 'success';
        //Customize the code as per your requirement.

    }

    public function getById(int $id)
    {
        $post = $this->postFactory->create();
        $this->postResourceModel->load($post, $id);

        if (!$post->getPostId()) {
            throw new NoSuchEntityException(__("Post not found!"));
        }

        return $post;
    }

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

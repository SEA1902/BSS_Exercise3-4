<?php
namespace Bss\Training\Model;
use Bss\Training\Api\BssPostInterface;
class BssPost implements BssPostInterface
{
    protected $date;
    public function __construct(
    \Magento\Framework\Stdlib\DateTime\DateTime $date,
    ) {
    $this->date = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        $post_id =  $data['post_id'];
        $title =$data['title'];
        $content =$data['content'];
        $created_at = $this->date->gmtDate();
        $updated_at = $this->date->gmtDate();

        //Customize the code as per your requirement.

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('bss_customer_posts');

        $sql = "Insert Into " . $tableName . " (post_id, title, content, created_at, updated_at) Values ('1','hello','50','2022-07-26 19:37:34','2022-07-26 19:37:34')";
        $connection->query($sql);
        return 'successfully saved';
    }
    public function getData()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('bss_customer_posts');

        $sql = "Select * From " . $tableName . " ";

        $connection->query($sql);
        return 'successfully';
    }
}

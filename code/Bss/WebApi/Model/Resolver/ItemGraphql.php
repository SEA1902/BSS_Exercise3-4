<?php

namespace Bss\WebApi\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;

class ItemGraphql implements ResolverInterface
{

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     * @throws GraphQlInputException
     */

    public function resolve(
        Field       $field,
                    $context,
        ResolveInfo $info,
        array       $value = null,
        array       $args = null)
    {
        $array = [
            [
                "id" => 1,
                "name" => "item1",
                "class" => "item1",
            ],
            [
                "id" => 2,
                "name" => "item2",
                "class" => "item2",
            ],
            [
                "id" => 3,
                "name" => "item3",
                "class" => "item3",
            ],
            [
                "id" => 4,
                "name" => "item4",
                "class" => "item4",
            ],
            [
                "id" => 5,
                "name" => "item5",
                "class" => "item5",
            ],
        ];
        $output = [];
        foreach ($array as $arr){
            if($arr["id"] == $args["id"]){
                $output['id'] = $arr['id'];
                $output['name'] = $arr['name'];
                $output['class'] = $arr['class'];
            }
        }

        return $output;
    }
}

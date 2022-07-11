<?php

namespace Bss\WebApi\Model;

class ItemManagement implements \Bss\WebApi\Api\ItemManagementInterface
{
    /**
     * {@inheritdoc}
     */
    public function getItem()
    {
        dd('test');
        try{
            $response = [
                'name' => 'long',
                'age' => '25',
                'job' => 'developer'
            ];
        } catch (\Exception $e) {
            $response=['error' => $e->getMessage()];
        }
        return json_encode($response);
    }
}

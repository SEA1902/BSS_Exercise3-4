<?php
namespace Bss\Training\Api;

interface BssPostInterface
{
    /**
     *
     * @api
     * @param array $data
     * @return string Greeting message with users name.
     */

    public function setData($data);
    /**
     * @api
     * @return string Greeting message with users name.
     */
    public function getData();

}

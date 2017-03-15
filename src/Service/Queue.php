<?php

namespace Ilpaijin\Service;

use Exception;
use Redis;

/**
 * Class Queue
 * @package Ilpaijin\Service
 */
class Queue
{
    /**
     *
     */
    const QUEUE_LIST = 'ilpaiijn:api:concatented-sms';

    /**
     * @var
     */
    private $conn;

    /**
     * Queue constructor.
     */
    public function __construct()
    {
        try {
            $this->conn = new Redis();
            $this->conn->connect('redis');
        } catch (Exception $e) {
            throw new Exception('Redis connection fault');
            // log it
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function push($data)
    {
        $llen = $this->conn->llen(self::QUEUE_LIST);
        $newllen = $this->conn->lpush(self::QUEUE_LIST, json_encode($data));

        return $newllen == $llen+1;
    }

    /**
     * @return array
     */
    public function show()
    {
        return $this->conn->lrange(self::QUEUE_LIST, 0, -1);
    }
}
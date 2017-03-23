<?php

namespace Ilpaijin\Service;

use MessageBird\Objects\Message as BirdMessage;
use Exception;
use Redis;

/**
 * Class Queue
 * @package Ilpaijin\Service
 */
class MessageQueue
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
     * @param BirdMessage $message
     * @return bool
     */
    public function send(BirdMessage $message)
    {
        $messageSegments = $this->packMessage($message);

        $counter = 0;
        foreach ($messageSegments as $segment ) {
            ++$counter;
            $udh = '050003CC02' . dechex($counter);
            $message->setBinarySms($udh, $segment);

            $llen = $this->conn->llen(self::QUEUE_LIST);
            $newllen = $this->conn->lpush(self::QUEUE_LIST, $message);

            if ($newllen !== $llen+1) {
                return false;
            }
        }

        return true;

    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->conn->lrange(self::QUEUE_LIST, 0, -1);
    }

    /**
     * @param BirdMessage $message
     * @return array
     */
    private function packMessage(BirdMessage $message)
    {
        $bytesString = "";
        foreach (str_split($message->body) as $char) {
            $binaryUnpadded = decbin(ord($char));
            $bytesString .= str_pad($binaryUnpadded, 7, 0, STR_PAD_LEFT);
        }

        $packed = '';
        foreach (str_split($bytesString, 8) as $byte) {
            $packed .= chr(bindec($byte));
        }

        return str_split($packed, 153);
    }
}
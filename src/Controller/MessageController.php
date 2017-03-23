<?php

namespace Ilpaijin\Controller;

use Exception;
use Ilpaijin\Exception\UnprocessableEntityException;
use MessageBird\Objects\Message as BirdMessage;
use Ilpaijin\Validator\Constraints\MessageConstraint as MessageConstraint;

/**
 * Class MessageController
 * @package Ilpaijin\Controller
 */
class MessageController extends ControllerDIAware
{
    /**
     * @return array
     */
    public function getAll()
    {
        $queue = $this->container->get('message-queue');
        return ['data' => ['messages' => array_map(function($item) { return json_decode($item); }, $queue->getAll())]];
    }

    /**
     * @param $request
     * @return array
     * @throws UnprocessableEntityException
     */
    public function post($request) {
        $message = $this->deserializeIntoMessage($request);
        $validator = $this->container->get('validator');

        if (!$validator->validate($message, new MessageConstraint)) {
            throw new UnprocessableEntityException('tell me what went wrong');
        }

        if($this->enqueueMessage($message)) {

        }

        return ['data' => 'Message has been processed', 'status' => '202 Accepted'];
    }

    /**
     * @param $data
     * @return BirdMessage
     */
    private function deserializeIntoMessage ($data)
    {
        $data = json_decode($data, true);

        $message = new BirdMessage();
        $message->loadFromArray($data);

        return $message;
    }

    /**
     * @param BirdMessage $message
     * @return bool
     */
    private function enqueueMessage(BirdMessage $message)
    {
        $messageQueue = $this->container->get('message-queue');

        if (!$messageQueue->send($message)) {
            //log
            //throw error
            return false;
        }

        return true;
    }
}
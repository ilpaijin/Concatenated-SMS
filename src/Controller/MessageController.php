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
        $message->originator = isset($data['originator']) ? $data['originator'] : '';
        $message->recipients = isset($data['recipients']) ? $data['recipients'] : '';
        $message->body = isset($data['msg']) ? $data['msg'] : '';
        $message->datacoding = isset($data['datacoding']) ? $data['datacoding'] : '';

        return $message;
    }

    /**
     * @param $message
     * @return bool
     */
    private function enqueueMessage($message)
    {
        $queue = $this->container->get('queue');

        $messageSegments = str_split($message->body, 153);

        $counter = 0;
        foreach ($messageSegments as $segment ) {
            ++$counter;
            $udh = '050003CC02' . dechex($counter);
            $message->setBinarySms($udh, $segment);

            if (!$queue->push($message)) {
                return false;
            }
        }

        var_dump($queue->show());

        return true;
    }
}
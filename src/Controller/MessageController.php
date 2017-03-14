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
     * @return string
     */
    public function getAll()
    {
        $messageService = $this->container->get('messagebird');
        $validator = $this->container->get('validator');

        try{
            $message             = new BirdMessage();
            $message->originator = 'MessageBird';
            $message->recipients = array('0034684125308');
            $message->body       = 'LØrem aeconsectetur adipiscing elit. Morbi a commodo est. Curabitur imperdiet lacinia tristique. Orci varius natoque penatibus et magnis dis parturient montes, nascetur massa nunc.';
            $message->datacoding = 'unicode';
//            $messageResult = $messageService->messages->create($message);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }

        if (!$validator->validate($message, new MessageConstraint)) {
            throw new UnprocessableEntityException();
        }

        var_dump(mb_strlen($message->body, '8bit'));
        exit;

//        return ['data' => ['service-result' => $messageResult]];
    }

    public function post() {

    }
}
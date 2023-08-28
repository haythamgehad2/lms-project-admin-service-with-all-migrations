<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse extends Response
{
    /**
     * Messages.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Meta Data.
     *
     * @var array
     */
    protected $meta = [];

    public function create(): JsonResponse
    {

        return new JsonResponse(
            [
                'code' => $this->getCode(),
                'errors' => $this->getErrors(),
                'messages' => $this->getMessages(),
                'data' => $this->getData(),
                'meta' => $this->getMeta()
            ],
            $this->getCode()
        );
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setMessages($messages): ApiResponse
    {
        $this->messages = $messages;
        return $this;
    }

    public function getMeta():array
    {
        return $this->meta;
    }

    public function setMeta(array $meta): ApiResponse
    {

        $this->meta = $meta;
        return $this;
    }
}

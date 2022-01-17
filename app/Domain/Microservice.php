<?php

namespace Domain;

class Microservice
{
    public function __construct(
        private string $id,
        private string $url,
    )
    {}

    public static function fromCache(array $microservice): self
    {
        return new self(
            id: $microservice['id'],
            url: $microservice['url'],
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}

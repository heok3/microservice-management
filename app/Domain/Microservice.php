<?php

namespace Domain;

class Microservice
{
    public function __construct(
        private string $id,
        private string $url,
        private int    $healthMs,
    )
    {
    }

    public static function fromCache(array $microservice): self
    {
        return new self(
            id: $microservice['id'],
            url: $microservice['url'],
            healthMs: $microservice['health-ms'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'health-ms' => $this->healthMs,
        ];
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

    /**
     * @return int
     */
    public function getHealthMs(): int
    {
        return $this->healthMs;
    }

    /**
     * @param int $healthMs
     */
    public function setHealthMs(int $healthMs): void
    {
        $this->healthMs = $healthMs;
    }
}

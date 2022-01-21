<?php

namespace Domain;

use Carbon\Carbon;

class Microservice
{
    public function __construct(
        private string $id,
        private string $url,
        private int    $healthMs,
        private Carbon $updatedAt,
        private Carbon $createdAt,
    )
    {
    }

    public static function fromCache(array $microservice): self
    {
        return new self(
            id: $microservice['id'],
            url: $microservice['url'],
            healthMs: $microservice['health_ms'],
            updatedAt: Carbon::createFromTimestamp($microservice['updated_at']),
            createdAt: Carbon::createFromTimestamp($microservice['created_at']),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'health_ms' => $this->healthMs,
            'updated_at' => $this->updatedAt->timestamp,
            'created_at' => $this->createdAt->timestamp,
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
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @param int $healthMs
     */
    public function setHealthMs(int $healthMs): void
    {
        $this->healthMs = $healthMs;
        $this->updatedAt = Carbon::now();
    }
}

<?php

namespace App\WeatherProvider;

use App\Exception\WeatherProviderException;
use App\WeatherProvider\WeatherProviderInterface;
use Psr\Log\LoggerInterface;

abstract class BaseWeatherProvider implements WeatherProviderInterface
{
    protected readonly string $apiKey;
    protected readonly string $apiBaseUrl;
    protected LoggerInterface $logger;
    protected array $result = [];
    protected string $url;

    /**
     * @param string $apiKey
     * @param string $apiBaseUrl
     * @param LoggerInterface $logger
     */
    public function __construct(string $apiKey, string $apiBaseUrl, LoggerInterface $logger)
    {
        $this->apiKey = $apiKey;
        $this->apiBaseUrl = $apiBaseUrl;
        $this->logger = $logger;
    }

    abstract protected function call(): void;

    abstract protected function parseResponse(string $response): void;


    public function getWeather(string $city): array
    {
        $this->url = sprintf('%s?key=%s&q=%s', $this->apiBaseUrl, $this->apiKey, urlencode($city));
        $this->call();
        return $this->result;
    }
}
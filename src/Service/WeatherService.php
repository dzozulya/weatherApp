<?php

namespace App\Service;

use App\WeatherProvider\WeatherProviderInterface;

/**
 * @property WeatherProviderInterface $weatherProvider
 */
class WeatherService
{
    private WeatherProviderInterface $weatherProvider;

    /**
     * @param WeatherProviderInterface $weatherProvider
     */
    public function __construct(WeatherProviderInterface $weatherProvider)
    {
        $this->weatherProvider = $weatherProvider;
    }

    public function getWeather(string $city): array
    {
        return $this->weatherProvider->getWeather($city);

    }


}
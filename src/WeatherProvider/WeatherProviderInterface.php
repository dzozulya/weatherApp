<?php

namespace App\WeatherProvider;

interface WeatherProviderInterface
{
    public function getWeather(string $city): array;

}
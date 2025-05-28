<?php

namespace App\Tests\Service;

use App\Service\WeatherService;
use App\WeatherProvider\WeatherProviderInterface;
use PHPUnit\Framework\TestCase;

class WeatherServiceTest extends TestCase
{
    public function testGetWeatherReturnsExpectedData()
    {
        $city = 'Kyiv';
        $expectedResult = [
            'city' => 'Kyiv',
            'country' => 'Ukraine',
            'temperature' => 20,
            'condition' => 'Sunny',
            'humidity' => 50,
            'wind_speed' => 10,
            'last_updated' => '2024-05-28 12:00',
        ];

        $weatherProviderMock = $this->createMock(WeatherProviderInterface::class);
        $weatherProviderMock->expects($this->once())
            ->method('getWeather')
            ->with($city)
            ->willReturn($expectedResult);

        $weatherService = new WeatherService($weatherProviderMock);

        $actualResult = $weatherService->getWeather($city);

        $this->assertSame($expectedResult, $actualResult);
    }
}
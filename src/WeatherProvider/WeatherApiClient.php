<?php

namespace App\WeatherProvider;

use App\Exception\WeatherProviderException;
use App\WeatherProvider\BaseWeatherProvider;

class WeatherApiClient extends BaseWeatherProvider
{

    /**
     * @throws WeatherProviderException
     */
    protected function call(): void
    {
        $this->logger->info('Weather API request', ['url' => $this->url]);
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $errorMessage = curl_error($ch);
            curl_close($ch);
            throw new WeatherProviderException("Curl error: $errorMessage");
        }

        curl_close($ch);

        if (empty($response)) {
            throw new WeatherProviderException('Empty or invalid response from weather API.');
        }

        $this->parseResponse($response);
    }

    /**
     * @throws WeatherProviderException
     */
    protected function parseResponse(string $response): void
    {

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new WeatherProviderException('JSON decode error: ' . json_last_error_msg());
        }

        if (isset($data['error'])) {
            $message = $data['error']['message'] ?? 'Unknown API error';
            throw new WeatherProviderException("API Error: $message");
        }

        $this->result = [
            'city' => $data['location']['name'],
            'country' => $data['location']['country'],
            'temperature' => $data['current']['temp_c'],
            'condition' => $data['current']['condition']['text'],
            'humidity' => $data['current']['humidity'],
            'wind_speed' => $data['current']['wind_kph'],
            'last_updated' => $data['current']['last_updated'],
        ];


        $this->logger->info('Weather fetched', [
            'city' => $this->result['city'],
            'temperature' => $this->result['temperature'],
        ]);


    }
}
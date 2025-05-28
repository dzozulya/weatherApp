# Symfony Weather App

## Встановлення

```
bash
git clone git@github.com:dzozulya/weatherApp.git
cd weatherApp
composer install
cp .env .env.local
додати WEATHER_API_KEY(свій ключ АПІ) до .env.local
symfony server:start - локальний сервер розробки
```
[Перейдіть у браузері на:](http://localhost:8000/weather?city=Kyiv)

запуск тесту: php bin/phpunit

## Основні компоненти
```
Controller: WeatherController

Сервіс: WeatherService, що використовує WeatherProviderInterface(сервісний рівень абстракції для роботи з Апі)

API клієнт: WeatherApiClient на основі BaseWeatherProvider(низкоривнева робота з Апі, логування та робота з помилкамибщось типу репозіторія для Апі, підтримка Solid)

Винятки: WeatherClientException

Шаблон: templates/weather/show.html.twig

Тести: tests/Service/WeatherServiceTest.php

```
## Конфігурація
```
Використовується ручна реєстрація сервісу WeatherApiClient, оскільки в конструктор передаються строкові параметри (apiKey, apiBaseUrl):
використовуєтся файли оточення .env для безпечного зберыгання конфеденційних даних в залежності від середи розробки
```
## Приміткі
```
Залишив cURL, а не Symfony HttpClient. Особисто для мене це більш надійне решення
Параметри, визначені лише в weather.yaml, не потрапляють в DI-контейнерб вони є примитивними елементими які автоматично не потрапляють в контейнер залежності - експортував  їх у services.yaml

```
## Автор 
````
Дмитро Зозуля
Цей додаток створено як тестове завдання на позицію Symfony Developer.


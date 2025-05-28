<?php
namespace App\Controller;

use App\Exception\WeatherProviderException;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{

private WeatherService $weatherService;

public function __construct(WeatherService $weatherService)
{
    $this->weatherService = $weatherService;
}
#[Route('/weather', name: 'weather')]
public function show(Request $request,): Response
{
$city = $request->query->get('city', 'London');

try {
$weather = $this->weatherService->getWeather($city);
} catch (WeatherProviderException $e) {
return $this->render('weather/show.html.twig', [
'error' => $e->getMessage(),
]);
}

return $this->render('weather/show.html.twig', [
'weather' => $weather,
]);
}
}
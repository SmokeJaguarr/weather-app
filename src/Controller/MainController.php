<?php


namespace App\Controller;


use App\modules\IpLocationApi;
use App\modules\WeatherApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @route("/")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->render('main/index.html.twig');
    }

}
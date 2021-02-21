<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IMCController extends AbstractController
{

    /**
     * @Route("/imc", name="app_index")
     */
    public function index(Request $request): Response
    {
        $height = $request->request->get('_altura');
        $weight = $request->request->get('_peso');

        if ($request->isMethod('POST')) {
            return $this->redirectToRoute('app_imc', [
                'height' => $height,
                'weight' => $weight
            ], 307);
        }
        return $this->render('main/index.html.twig', [

        ]);
    }

    /**
     * @Route("/imc/{height}/{weight}", name="app_imc")
     */
    public function imc($height, $weight): Response
    {
        $height_for = number_format($height / 100, 2);
        $imc = $weight / ($height_for * $height_for);
        $imc_for = number_format($imc, 2);

        $desc = null;
        if ($imc_for < 18.5) {
            $desc = "Você é considerado(a) magro(a).";
        } elseif ($imc_for > 18.5 and $imc_for < 24.9) {
            $desc = "Você está com o peso normal.";
        } elseif ($imc_for > 24.9 and $imc_for < 30) {
            $desc = "Você é considerado(a) com sobrepeso.";
        } elseif ($imc_for > 30) {
            $desc = "Você é considerado(a) obeso(a).";
        }

        return $this->render('main/imc.html.twig', [
            'imc' => $imc_for,
            'height' => $height_for,
            'weight' => $weight,
            'desc' => $desc
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\AgentRepository;
use App\Repository\RemorqueRepository;
use App\Repository\FournisseurRepository;
use App\Repository\ClientRepository;
use App\Repository\TransactionRepository;
use App\Entity\Agent;
use App\Entity\Client;
use App\Entity\Fourgon;
use App\Entity\Fournisseur;
use App\Entity\Parking;
use App\Entity\Remorque;
use App\Entity\Transaction;
use App\Repository\FourgonRepository;
use App\Repository\ParkingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class AdministrationController extends AbstractController
{
    /**
     * @Route("/YMNA", name="app_administration")
     */
    public function index(AgentRepository $AgentRepository, ClientRepository $ClientRepository, TransactionRepository $TransactionRepository, ChartBuilderInterface $chartBuilder, FournisseurRepository $fourniRepository,   RemorqueRepository $RemorqueRepository, FourgonRepository $fourgonRepository, ParkingRepository $parkingRepository): Response
    {
        $dailyResults =  $TransactionRepository->findAll();

        $labels = [];
        $data = [];
        foreach ($dailyResults as $dailyResult) {
            $labels[] = $dailyResult->getDateTransit()->format('d/m/Y');
            $data[] = $dailyResult->getMontant();
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Transit',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([]);

        return $this->render('administration/index.html.twig', [

            'countAgent' => $AgentRepository->countAllAgent(),
            'countClient' => $ClientRepository->countAllClient(),
            'countTransit' => $TransactionRepository->countAllTransit(),
            'chart' => $chart,
            'countFourni' => $fourniRepository->countAllFourni(),
            'countRemorque' => $RemorqueRepository->countAllRemorque(),
            'countFourgon' => $fourgonRepository->countAllFourgon(),
            'countParking' => $parkingRepository->countAllParking(),
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TransactionRepository;

class GraphController extends AbstractController
{
    /**
     * @Route("/graph", name="app_graph")
     */
    public function index(ChartBuilderInterface $chartBuilder, TransactionRepository $transactionRepository): Response
    {
        $dailyResults =  $transactionRepository->findAll();

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
                    'label' => 'Transaction',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([]);


        return $this->render('chart/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Fourgon;
use App\Form\FourgonType;
use App\Repository\FourgonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

/**
 * @Route("YMNA/fourgon")
 */
class FourgonController extends AbstractController
{
    /**
     * @Route("/", name="app_fourgon_index", methods={"GET"})
     */
    public function index(FourgonRepository $fourgonRepository): Response
    {

        return $this->render('fourgon/index.html.twig', [
            'fourgons' => $fourgonRepository->findAll(),
            'countFourgon' => $fourgonRepository->countAllFourgon(),

        ]);
    }

    /**
     * @Route("/new", name="app_fourgon_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FourgonRepository $fourgonRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $dailyResults =  $fourgonRepository->findAll();

        $labels = [];
        $data = [];
        foreach ($dailyResults as $dailyResult) {
            $labels[] = $dailyResult->getMarque();
            $data[] = $dailyResult->getDateMatriculation()->format('Y');
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Fourgon',
                    'backgroundColor' => 'rgb(120, 99, 255)',
                    'borderColor' => 'rgb(120, 99, 255)',
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([]);
        $fourgon = new Fourgon();
        $form = $this->createForm(FourgonType::class, $fourgon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fourgonRepository->add($fourgon, true);

            return $this->redirectToRoute('app_fourgon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fourgon/new.html.twig', [
            'fourgon' => $fourgon,
            'form' => $form,

        ]);
    }

    /**
     * @Route("/{id}", name="app_fourgon_show", methods={"GET"})
     */
    public function show(Fourgon $fourgon): Response
    {
        return $this->render('fourgon/show.html.twig', [
            'fourgon' => $fourgon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_fourgon_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Fourgon $fourgon, FourgonRepository $fourgonRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $dailyResults =  $fourgonRepository->findAll();

        $labels = [];
        $data = [];
        foreach ($dailyResults as $dailyResult) {
            $labels[] = $dailyResult->getMarque();
            $data[] = $dailyResult->getDateMatriculation()->format('Y');
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Fourgon',
                    'backgroundColor' => 'rgb(120, 99, 255)',
                    'borderColor' => 'rgb(120, 99, 255)',
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([]);
        $form = $this->createForm(FourgonType::class, $fourgon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fourgonRepository->add($fourgon, true);

            return $this->redirectToRoute('app_fourgon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fourgon/edit.html.twig', [
            'fourgon' => $fourgon,
            'form' => $form,
            'chart' => $chart,
        ]);
    }

    /**
     * @Route("/{id}", name="app_fourgon_delete", methods={"POST"})
     */
    public function delete(Request $request, Fourgon $fourgon, FourgonRepository $fourgonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $fourgon->getId(), $request->request->get('_token'))) {
            $fourgonRepository->remove($fourgon, true);
        }

        return $this->redirectToRoute('app_fourgon_index', [], Response::HTTP_SEE_OTHER);
    }
}

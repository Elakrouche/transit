<?php

namespace App\Controller;

use App\Entity\Remorque;
use App\Form\RemorqueType;
use App\Repository\RemorqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

/**
 * @Route("YMNA/remorque")
 */
class RemorqueController extends AbstractController
{
    /**
     * @Route("/", name="app_remorque_index", methods={"GET"})
     */
    public function index(RemorqueRepository $remorqueRepository): Response
    {
        return $this->render('remorque/index.html.twig', [
            'remorques' => $remorqueRepository->findAll(),
            'CountRemorque' => $remorqueRepository->countAllRemorque(),
        ]);
    }

    /**
     * @Route("/new", name="app_remorque_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RemorqueRepository $remorqueRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $dailyResults =  $remorqueRepository->findAll();

        $labels = [];
        $data = [];
        foreach ($dailyResults as $dailyResult) {
            $labels[] = $dailyResult->getMarque();
            $data[] = $dailyResult->getDateMservice()->format('Y');
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Remorque',
                    'backgroundColor' => 'rgb(120, 99, 255)',
                    'borderColor' => 'rgb(120, 99, 255)',
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([]);
        $remorque = new Remorque();
        $form = $this->createForm(RemorqueType::class, $remorque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $remorqueRepository->add($remorque, true);

            return $this->redirectToRoute('app_remorque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remorque/new.html.twig', [
            'remorque' => $remorque,
            'form' => $form,
            'chart' => $chart,
        ]);
    }

    /**
     * @Route("/{id}", name="app_remorque_show", methods={"GET"})
     */
    public function show(Remorque $remorque): Response
    {
        return $this->render('remorque/show.html.twig', [
            'remorque' => $remorque,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_remorque_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Remorque $remorque, RemorqueRepository $remorqueRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $dailyResults =  $remorqueRepository->findAll();

        $labels = [];
        $data = [];
        foreach ($dailyResults as $dailyResult) {
            $labels[] = $dailyResult->getMarque();
            $data[] = $dailyResult->getDateMservice()->format('Y');
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Remorque',
                    'backgroundColor' => 'rgb(120, 99, 255)',
                    'borderColor' => 'rgb(120, 99, 255)',
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([]);
        $form = $this->createForm(RemorqueType::class, $remorque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $remorqueRepository->add($remorque, true);

            return $this->redirectToRoute('app_remorque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remorque/edit.html.twig', [
            'remorque' => $remorque,
            'form' => $form,

        ]);
    }

    /**
     * @Route("/{id}", name="app_remorque_delete", methods={"POST"})
     */
    public function delete(Request $request, Remorque $remorque, RemorqueRepository $remorqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $remorque->getId(), $request->request->get('_token'))) {
            $remorqueRepository->remove($remorque, true);
        }

        return $this->redirectToRoute('app_remorque_index', [], Response::HTTP_SEE_OTHER);
    }
}

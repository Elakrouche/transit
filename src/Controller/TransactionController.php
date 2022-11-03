<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\service\PdfService;

/**
 * @Route("YMNA/transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("/", name="app_transaction_index", methods={"GET"})
     */
    public function index(TransactionRepository $transactionRepository, ChartBuilderInterface $chartBuilder): Response
    {
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
            'countTransit' => $transactionRepository->countAllTransit(),
            'MaxTransit' => $transactionRepository->MaxTransit(),
            'AVGTransit' => $transactionRepository->AVGTransit(),
        ]);
    }

    /**
     * @Route("/new", name="app_transaction_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TransactionRepository $transactionRepository, ChartBuilderInterface $chartBuilder): Response
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
                    'label' => 'Transit',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([]);
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->add($transaction, true);

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
            'chart' => $chart,
        ]);
    }

    /**
     * @Route("/{id}", name="app_transaction_show", methods={"GET"})
     */
    public function show(Transaction $transaction, PdfService $pdf)
    {

        $html = $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
        $pdf->showPdfFile($html);
    }

    /**
     * @Route("/{id}/edit", name="app_transaction_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Transaction $transaction, TransactionRepository $transactionRepository, ChartBuilderInterface $chartBuilder): Response
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
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->add($transaction, true);

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
            'chart' => $chart,
        ]);
    }

    /**
     * @Route("/{id}", name="app_transaction_delete", methods={"POST"})
     */
    public function delete(Request $request, Transaction $transaction, TransactionRepository $transactionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $transaction->getId(), $request->request->get('_token'))) {
            $transactionRepository->remove($transaction, true);
        }

        return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    }
}

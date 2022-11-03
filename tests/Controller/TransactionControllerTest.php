<?php

namespace App\Test\Controller;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TransactionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TransactionRepository $repository;
    private string $path = '/transaction/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Transaction::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Transaction index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'transaction[Date_transit]' => 'Testing',
            'transaction[Montant]' => 'Testing',
            'transaction[Num_dossier]' => 'Testing',
            'transaction[Num_facture]' => 'Testing',
            'transaction[Agent_matricule]' => 'Testing',
            'transaction[Fournisseur_matri]' => 'Testing',
            'transaction[Client]' => 'Testing',
            'transaction[fourgon]' => 'Testing',
            'transaction[Remorque]' => 'Testing',
            'transaction[Parking_matricule]' => 'Testing',
        ]);

        self::assertResponseRedirects('/transaction/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Transaction();
        $fixture->setDate_transit('My Title');
        $fixture->setMontant('My Title');
        $fixture->setNum_dossier('My Title');
        $fixture->setNum_facture('My Title');
        $fixture->setAgent_matricule('My Title');
        $fixture->setFournisseur_matri('My Title');
        $fixture->setClient('My Title');
        $fixture->setFourgon('My Title');
        $fixture->setRemorque('My Title');
        $fixture->setParking_matricule('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Transaction');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Transaction();
        $fixture->setDate_transit('My Title');
        $fixture->setMontant('My Title');
        $fixture->setNum_dossier('My Title');
        $fixture->setNum_facture('My Title');
        $fixture->setAgent_matricule('My Title');
        $fixture->setFournisseur_matri('My Title');
        $fixture->setClient('My Title');
        $fixture->setFourgon('My Title');
        $fixture->setRemorque('My Title');
        $fixture->setParking_matricule('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'transaction[Date_transit]' => 'Something New',
            'transaction[Montant]' => 'Something New',
            'transaction[Num_dossier]' => 'Something New',
            'transaction[Num_facture]' => 'Something New',
            'transaction[Agent_matricule]' => 'Something New',
            'transaction[Fournisseur_matri]' => 'Something New',
            'transaction[Client]' => 'Something New',
            'transaction[fourgon]' => 'Something New',
            'transaction[Remorque]' => 'Something New',
            'transaction[Parking_matricule]' => 'Something New',
        ]);

        self::assertResponseRedirects('/transaction/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate_transit());
        self::assertSame('Something New', $fixture[0]->getMontant());
        self::assertSame('Something New', $fixture[0]->getNum_dossier());
        self::assertSame('Something New', $fixture[0]->getNum_facture());
        self::assertSame('Something New', $fixture[0]->getAgent_matricule());
        self::assertSame('Something New', $fixture[0]->getFournisseur_matri());
        self::assertSame('Something New', $fixture[0]->getClient());
        self::assertSame('Something New', $fixture[0]->getFourgon());
        self::assertSame('Something New', $fixture[0]->getRemorque());
        self::assertSame('Something New', $fixture[0]->getParking_matricule());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Transaction();
        $fixture->setDate_transit('My Title');
        $fixture->setMontant('My Title');
        $fixture->setNum_dossier('My Title');
        $fixture->setNum_facture('My Title');
        $fixture->setAgent_matricule('My Title');
        $fixture->setFournisseur_matri('My Title');
        $fixture->setClient('My Title');
        $fixture->setFourgon('My Title');
        $fixture->setRemorque('My Title');
        $fixture->setParking_matricule('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/transaction/');
    }
}

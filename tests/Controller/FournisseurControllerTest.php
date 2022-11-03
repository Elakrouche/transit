<?php

namespace App\Test\Controller;

use App\Entity\Fournisseur;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FournisseurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FournisseurRepository $repository;
    private string $path = '/fournisseur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Fournisseur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Fournisseur index');

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
            'fournisseur[Adress]' => 'Testing',
            'fournisseur[mail]' => 'Testing',
            'fournisseur[nom]' => 'Testing',
            'fournisseur[Tel]' => 'Testing',
        ]);

        self::assertResponseRedirects('/fournisseur/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Fournisseur();
        $fixture->setAdress('My Title');
        $fixture->setMail('My Title');
        $fixture->setNom('My Title');
        $fixture->setTel('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Fournisseur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Fournisseur();
        $fixture->setAdress('My Title');
        $fixture->setMail('My Title');
        $fixture->setNom('My Title');
        $fixture->setTel('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'fournisseur[Adress]' => 'Something New',
            'fournisseur[mail]' => 'Something New',
            'fournisseur[nom]' => 'Something New',
            'fournisseur[Tel]' => 'Something New',
        ]);

        self::assertResponseRedirects('/fournisseur/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getAdress());
        self::assertSame('Something New', $fixture[0]->getMail());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getTel());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Fournisseur();
        $fixture->setAdress('My Title');
        $fixture->setMail('My Title');
        $fixture->setNom('My Title');
        $fixture->setTel('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/fournisseur/');
    }
}

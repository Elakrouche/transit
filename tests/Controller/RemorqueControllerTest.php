<?php

namespace App\Test\Controller;

use App\Entity\Remorque;
use App\Repository\RemorqueRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RemorqueControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RemorqueRepository $repository;
    private string $path = '/remorque/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Remorque::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Remorque index');

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
            'remorque[Date_mservice]' => 'Testing',
            'remorque[marque]' => 'Testing',
        ]);

        self::assertResponseRedirects('/remorque/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Remorque();
        $fixture->setDate_mservice('My Title');
        $fixture->setMarque('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Remorque');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Remorque();
        $fixture->setDate_mservice('My Title');
        $fixture->setMarque('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'remorque[Date_mservice]' => 'Something New',
            'remorque[marque]' => 'Something New',
        ]);

        self::assertResponseRedirects('/remorque/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate_mservice());
        self::assertSame('Something New', $fixture[0]->getMarque());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Remorque();
        $fixture->setDate_mservice('My Title');
        $fixture->setMarque('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/remorque/');
    }
}

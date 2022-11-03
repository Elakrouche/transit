<?php

namespace App\Test\Controller;

use App\Entity\Fourgon;
use App\Repository\FourgonRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FourgonControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FourgonRepository $repository;
    private string $path = '/fourgon/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Fourgon::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Fourgon index');

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
            'fourgon[date_matriculation]' => 'Testing',
            'fourgon[marque]' => 'Testing',
        ]);

        self::assertResponseRedirects('/fourgon/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Fourgon();
        $fixture->setDate_matriculation('My Title');
        $fixture->setMarque('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Fourgon');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Fourgon();
        $fixture->setDate_matriculation('My Title');
        $fixture->setMarque('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'fourgon[date_matriculation]' => 'Something New',
            'fourgon[marque]' => 'Something New',
        ]);

        self::assertResponseRedirects('/fourgon/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate_matriculation());
        self::assertSame('Something New', $fixture[0]->getMarque());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Fourgon();
        $fixture->setDate_matriculation('My Title');
        $fixture->setMarque('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/fourgon/');
    }
}

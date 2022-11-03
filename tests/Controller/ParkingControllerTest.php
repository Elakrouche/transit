<?php

namespace App\Test\Controller;

use App\Entity\Parking;
use App\Repository\ParkingRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ParkingControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ParkingRepository $repository;
    private string $path = '/parking/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Parking::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Parking index');

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
            'parking[AdressParking]' => 'Testing',
            'parking[Capacite]' => 'Testing',
            'parking[Couvre_Soleil]' => 'Testing',
            'parking[Mail]' => 'Testing',
            'parking[Tele]' => 'Testing',
        ]);

        self::assertResponseRedirects('/parking/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Parking();
        $fixture->setAdressParking('My Title');
        $fixture->setCapacite('My Title');
        $fixture->setCouvre_Soleil('My Title');
        $fixture->setMail('My Title');
        $fixture->setTele('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Parking');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Parking();
        $fixture->setAdressParking('My Title');
        $fixture->setCapacite('My Title');
        $fixture->setCouvre_Soleil('My Title');
        $fixture->setMail('My Title');
        $fixture->setTele('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'parking[AdressParking]' => 'Something New',
            'parking[Capacite]' => 'Something New',
            'parking[Couvre_Soleil]' => 'Something New',
            'parking[Mail]' => 'Something New',
            'parking[Tele]' => 'Something New',
        ]);

        self::assertResponseRedirects('/parking/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getAdressParking());
        self::assertSame('Something New', $fixture[0]->getCapacite());
        self::assertSame('Something New', $fixture[0]->getCouvre_Soleil());
        self::assertSame('Something New', $fixture[0]->getMail());
        self::assertSame('Something New', $fixture[0]->getTele());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Parking();
        $fixture->setAdressParking('My Title');
        $fixture->setCapacite('My Title');
        $fixture->setCouvre_Soleil('My Title');
        $fixture->setMail('My Title');
        $fixture->setTele('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/parking/');
    }
}

<?php
namespace App\Trait;
use App\Entity;
use Flight;

trait basicResource {

    //'index' => 'GET '
    public function index(): void
    {
        $this->results = $this->target->findAll();
        Flight::json($this->results);

    }

    //'show' => 'GET /@id'
    public function show(int $id): void
    {

        $this->target->find($id);
        Flight::json($this->target);
    }

    //'create' => 'GET /create' - probably won't use...
    public function create(): void
    {
        Flight::dump($this->request);

    }

    //'store' => 'POST '
    public function store(): void
    {
        Flight::dump($this->request);

    }

    //'edit' => 'GET /@id/edit' - probably won't use...
    public function edit(string $id): void
    {
        Flight::dump($this->request);
    }

    //'update' => 'PUT /@id'
    public function update(string $id): void
    {
        Flight::dump($this->request);
    }

    //'destroy' => 'DELETE /@id'
    public function destroy(string $id): void
    {
        Flight::dump($this->request);
    }
}
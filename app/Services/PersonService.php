<?php

namespace App\Services;

use App\Dto\PersonDTO;
use App\Models\Person;
use App\Notifications\PersonCreated;
use App\Repositories\PersonRepository;

class PersonService
{

    public function __construct(
        private PersonRepository $personRepository
    ) {

    }

    public function create(PersonDTO $personData): int
    {

        /**
         * @var Person $person
         */
        $person = $this->personRepository->create($personData->toArray());
        $person->notify(new PersonCreated($person));

        return $person->id;
    }

    public function update(PersonDTO $data, int $id)
    {
        return $this->personRepository->update($id, $data->toArray());
    }

    public function delete(int $id)
    {
        $res = $this->personRepository->delete($id);
        return $res;
    }

    public function find(int $id)
    {
        $person = $this->personRepository->find($id);
        return $person;
    }

    public function findAll()
    {
        $persons = $this->personRepository->all();
        return $persons;
    }

}

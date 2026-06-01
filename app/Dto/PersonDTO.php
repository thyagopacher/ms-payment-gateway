<?php

namespace App\Dto;

use App\ValueObject\Document;
use App\ValueObject\Email;
use App\ValueObject\State;

/**
 * PersonDTO class
 *
 * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
 */
class PersonDTO
{
    public function __construct(
        public string $person_name,
        public Email $person_mail,
        public string $person_phone,
        public Document $person_document,
        public string $person_city,
        public State $person_state
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            person_name: $data['person_name'] ?? '',
            person_mail: Email::from($data['person_mail']),
            person_phone: $data['person_phone'],
            person_document: Document::from($data['person_document']),
            person_city: $data['person_city'],
            person_state: State::from($data['person_state'])
        );
    }

    public function toArray(): array
    {
        return [
            'person_name' => $this->person_name,
            'person_mail' => $this->person_mail->getValue(),
            'person_phone' => $this->person_phone,
            'person_document' => $this->person_document->getValue(),
            'person_city' => $this->person_city,
            'person_state' => $this->person_state->getValue()
        ];
    }
}

<?php

namespace App\Dto;

class AttachmentDTO
{
    public function __construct(
        public string $filename,
        public string $path,
        public string $type
    ) {

    }

    public function toArray(): array
    {
        return [
            'file_name' => $this->filename,
            'file_path' => $this->path,
            'file_type' => $this->type
        ];
    }
}

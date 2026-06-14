<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    protected $table = 'email';

    protected $primaryKey = 'id';

    protected $fillable = [
        'to', 'subject', 'body', 'status', 'error_message', 'read_at'
    ];

    public function attachments()
    {
        return $this->hasMany(EmailAttachment::class, 'email_id');
    }
}

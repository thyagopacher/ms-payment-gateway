<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{

    protected $table = 'email_attachment';

    protected $primaryKey = 'id';

    protected $fillable = [
        'email_id', 'file_name', 'file_path', 'file_type', 'file_size'
    ];

    public function email()
    {
        return $this->belongsTo(Email::class, 'email_id');
    }
}

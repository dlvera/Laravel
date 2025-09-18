<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_id',
        'original_name',
        'storage_path',
        'mime_type',
        'size',
    ];

    /**
     * Relación: Un archivo adjunto pertenece a un email
     */
    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
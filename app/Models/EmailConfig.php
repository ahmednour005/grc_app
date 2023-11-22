<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfig extends Model
{
    use HasFactory;
    protected $table = 'email_config'; // Specify the table name

    protected $fillable = [
        'email_type',
        'smtp_server',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_from_username',
        'ssl_tls',
        'is_active'
    ];
}

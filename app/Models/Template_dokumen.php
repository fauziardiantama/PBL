<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template_dokumen extends Model
{
    use HasFactory;
    protected $table = 'template_dokumen';
    protected $primaryKey = 'id_template';

    protected $fillable = [
        'nama_template',
        'file_template'
    ];
}

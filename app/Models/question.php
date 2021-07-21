<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;
    protected $fillable=[
        'Question',
        'Option1',
        'Option2',
        'Option3',
        'Option4',
        'S1',
        'S2',
        'S3',
        'S4',
        'convertS1',
        'convertS2',
        'convertS3',
        'convertS4',
    ];
}

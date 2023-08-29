<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangMeeting extends Model
{
    use HasFactory;

    protected $table = 'ruang_meeting';
    protected $guarded = ['id'];
}

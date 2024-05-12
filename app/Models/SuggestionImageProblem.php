<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuggestionImageProblem extends Model
{
    protected $table = 'sugg_images_problem';
    protected $fillable = ['file_path', 'sugg_id'];
}

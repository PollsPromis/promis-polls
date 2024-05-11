<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class SuggestionImageSolution extends Model
    {
        protected $table = 'sugg_images_solution';
        protected $fillable = ['file_path', 'sugg_id'];
    }

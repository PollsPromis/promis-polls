<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class SuggestionImageBefore extends Model
    {
        protected $fillable = ['file_path', 'sugg_id'];

        public function suggestion()
        {
            return $this->belongsTo(Suggestion::class, 'sugg_id');
        }
    }

<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Suggestion extends Model
    {
        protected $fillable = [
            'author', 'collaborator', 'depart_id', 'type_id',
            'suggestion_content', 'economic_indic_id', 'sent_for_expertise',
            'manager_comment', 'does_solve_a_problem', 'realizer', 'status_id'
        ];

        // Здесь можно добавить связи с другими моделями, если это необходимо
    }


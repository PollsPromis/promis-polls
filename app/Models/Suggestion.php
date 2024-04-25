<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Suggestion extends Model
    {
        use HasFactory;

        protected $fillable = [
            'date', 'author', 'collaborator', 'email', 'depart_id', 'type_id',
            'phone_number', 'suggestion_content', 'economic_indic_id', 'sent_for_expertise',
            'manager_comment', 'does_solve_a_problem', 'realizer', 'status_id'
        ];

        public function department()
        {
            return $this->belongsTo('App\Models\Department', 'depart_id');
        }

        public function status()
        {
            return $this->belongsTo('App\Models\Status', 'status_id');
        }

        public function type()
        {
            return $this->belongsTo('App\Models\Type', 'type_id');
        }

        public function economicIndicator()
        {
            return $this->belongsTo('App\Models\EconomicIndicator', 'economic_indic_id');
        }
    }


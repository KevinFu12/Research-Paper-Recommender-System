<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\HasNeighbors; // <-- Corrected Trait
use Pgvector\Laravel\Vector;
use Pgvector\Laravel\Distance;     // <-- Added for cleaner distance math

class Paper extends Model
{
    use HasNeighbors; // <-- Corrected Trait

    public $timestamps = false; 
    
    protected $casts = [
        'embedding' => Vector::class,
    ];

    public function getRecommendations()
    {
        // This uses pgvector's native method to calculate Cosine Similarity
        return $this->nearestNeighbors('embedding', Distance::Cosine)
                    ->where('id', '!=', $this->id) // Exclude the clicked paper itself
                    ->take(5)
                    ->get();
    }
}
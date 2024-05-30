<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;

    protected $table = 'organisation';


    protected $fillable = [
        'nom',
        'adresse',
        'code_postal',
        'service',
        'ville',
        'statut',
    ]; 

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'organisation_id');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contact';

    protected $fillable = [
        'nom',
        'prenom',
        'e-mail',
        'telephone_fixe',
        'service',
        'fonction',
        'cle',
        'organisation_id',
    ]; 

    
    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }
    

}

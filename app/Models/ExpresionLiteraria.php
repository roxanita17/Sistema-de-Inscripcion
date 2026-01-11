<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpresionLiteraria extends Model
{
    use HasFactory;

    protected $table = 'expresion_literarias';

    protected $fillable = [
        'letra_expresion_literaria',
        'status',
    ];

    public function setLetraExpresionLiterariaAttribute($value)
    {
        $value = mb_strtoupper(trim($value), 'UTF-8');

        if (preg_match('/^[A-Z]$/u', $value)) {
            $this->attributes['letra_expresion_literaria'] = $value;
        } else {
            throw new \InvalidArgumentException("La expresión literaria debe ser una sola letra (A-Z).");
        }
    }
}

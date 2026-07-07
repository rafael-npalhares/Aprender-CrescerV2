<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aviso extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'conteudo',
        'visivel_para',
        'fixado',
        'ativo',
    ];


    protected function casts(): array
    {
        return [
            'fixado' => 'boolean',
            'ativo'  => 'boolean',
        ];
    }


    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderByDesc('fixado')->orderByDesc('created_at');
    }

    public function scopeVisivelPara($query, string $perfil)
    {
        return $query->whereIn('visivel_para', ['todos', $perfil . 's']);
    }
}
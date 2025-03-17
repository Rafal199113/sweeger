<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'name', 'status', 'category', 'photoUrls', 'tags',];

    public $statusList = [
        'available' => 'dostępne',
        'pending' => 'zarezerwowane',
        'sold' => 'sprzedane',
    ];

    public function getStatus()
    {
        if ($this->status) {
            return Arr::get($this->statusList, $this->status);
        }
        return '';
    }
}

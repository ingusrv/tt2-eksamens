<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedBoards extends Model
{
    use HasFactory;

    protected $fillable = ["permissions"];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function boards()
    {
        return $this->hasMany(Board::class);
    }
}

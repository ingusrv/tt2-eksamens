<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ["name", "privacy"];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function columns()
    {
        return $this->hasMany(Column::class);
    }

    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, "shared_boards")->withPivot("permissions")->withTimestamps();
    }
}

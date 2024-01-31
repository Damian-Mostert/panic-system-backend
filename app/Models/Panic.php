<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panic extends Model
{
    use HasFactory;

    protected $table = 'panics';

    protected $fillable = ['status', 'data'];

    // Add any additional configuration or relationships here
}

/*

CREATE TABLE panics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(255),
    data JSON,
    canceled BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

*/
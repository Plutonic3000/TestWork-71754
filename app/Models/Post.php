<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'descr',
    ];

    public $validate_rules = [
        'title' => 'required|max:255',
        'descr' => 'required|max:500',
    ];

    public $attributes_translation =[
        'title' => 'TITLE',
        'descr' => 'TEXT',
    ];

    public function validate($request) {
        $request->validate(
            $this->validate_rules,
            [],
            $this->attributes_translation
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'fileName',
        'fileType'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->validateFileType();
        });
    }

    public function validateFileType()
    {
        $this->validate([
            'fileType' => [
                'required',
                Rule::in(['image', 'text'])
            ]
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Blog extends Model
{
    public $timestamps = false;
    protected $appends = ['thumbs_url'];

    protected function casts(): array
    {
        return [
            'position' => 'array',
        ];
    }

    protected function position() : Attribute {
	return Attribute::set(fn ($pos) => is_null($pos) ? '[]' : json_encode($pos));
    }

    protected function thumbsUrl() : Attribute {
    	return Attribute::make(
		get: fn() => !is_null($this->thumbs) && Storage::disk('public')->exists($this->thumbs) ? asset('storage/' . $this->thumbs) : null,
	);
    }
}

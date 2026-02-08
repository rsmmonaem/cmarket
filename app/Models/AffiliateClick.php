<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id', 'ip_address', 'user_agent', 'referrer'
    ];

    public function link()
    {
        return $this->belongsTo(AffiliateLink::class);
    }
}

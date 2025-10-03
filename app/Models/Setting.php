<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // حدد اسم الجدول إذا ما كان Laravel عم يتعرف عليه تلقائياً
    protected $table = 'settings';

    // الحقول اللي مسموح تعمل لها Mass Assignment
    protected $fillable = [
        'logo',
        'menu_items',
        'name',
        'hero_background',
        'hero_title',
        'hero_sub_title',
        'hero_button_text',
        'sliders',
        'footer_logo',
        'contact_name',
        'contact_phone',
        'contact_email',
        'contact_address',
        'footer_copyright',
        'language',
        'currency',
        'payment_methods',
    ];

    // التحويل للـ JSON/Array
    protected $casts = [
        'menu_items' => 'array',
        'sliders' => 'array',
        'footer_links' => 'array',
        'footer_categories' => 'array',
        'footer_socials' => 'array',
        'payment_methods' => 'array',
    ];
}

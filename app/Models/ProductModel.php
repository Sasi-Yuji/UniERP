<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';

    protected $allowedFields = [
        'name',
        'category',
        'price',
        'stock',
        'description'
    ];

    // 🔥 Validation Rules
    protected $validationRules = [
        'name'     => 'required',
        'category' => 'required',
        'price'    => 'numeric',
        'stock'    => 'integer'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Product name is required'
        ],
        'category' => [
            'required' => 'Category is required'
        ]
    ];
}
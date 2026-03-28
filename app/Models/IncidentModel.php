<?php

namespace App\Models;
use CodeIgniter\Model;

class IncidentModel extends Model
{
    protected $table = 'incident_logs';

    protected $allowedFields = [
        'title',
        'description',
        'department',
        'priority',
        'date'
    ];
}
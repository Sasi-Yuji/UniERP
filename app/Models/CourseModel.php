<?php

namespace App\Models;
use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'course_registrations';

    protected $allowedFields = [
        'student_name',
        'course_name',
        'semester',
        'fees',
        'email'
    ];
}
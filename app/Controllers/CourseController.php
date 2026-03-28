<?php

namespace App\Controllers;
use App\Models\CourseModel;

class CourseController extends BaseController
{
    // Show form
    public function create()
    {
        return view('course_form'); // return view()
    }

    // Save data
    public function store()
    {
        $model = new CourseModel();

        $data = [
            'student_name' => $this->request->getPost('student_name'),
            'course_name'  => $this->request->getPost('course_name'),
            'semester'     => $this->request->getPost('semester'),
            'fees'         => $this->request->getPost('fees'),
            'email'        => $this->request->getPost('email')
        ];

        $model->insert($data);

        return redirect()->to('/courses');
    }

    // Show list
    public function index()
    {
        $model = new CourseModel();

        $data['courses'] = $model->findAll();

        return view('course_list', $data);
    }

    public function ajaxUpdate()
    {
        $id = $this->request->getPost('id');
        $data = [
            'student_name' => $this->request->getPost('student_name'),
            'course_name'  => $this->request->getPost('course_name'),
            'semester'     => $this->request->getPost('semester'),
            'fees'         => $this->request->getPost('fees'),
            'email'        => $this->request->getPost('email')
        ];
        (new CourseModel())->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function ajaxDelete()
    {
        $id = $this->request->getPost('id');
        (new CourseModel())->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
}
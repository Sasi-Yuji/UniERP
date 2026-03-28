<?php

namespace App\Controllers;
use App\Models\StudentModel;

class StudentController extends BaseController
{
    // Load form
    public function create()
    {
        return view('student_form');
    }

    // List records
    public function index()
    {
        $model = new StudentModel();

        $data['students'] = $model->findAll(); // get all data

        return view('student_list', $data);
    }

    // Save data
    public function save()
    {
        $model = new StudentModel();

        $data = [
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'phone'  => $this->request->getPost('phone'),
            'course' => $this->request->getPost('course'),
            'city'   => $this->request->getPost('city')
        ];

        $model->insert($data);

        return redirect()->to('/students'); // redirect to list page
    }

    public function ajaxSave()
    {
        $model = new StudentModel();
        
        $data = [
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'phone'  => $this->request->getPost('phone'),
            'course' => $this->request->getPost('course'),
            'city'   => $this->request->getPost('city')
        ];
        
        $insertID = $model->insert($data);
        $data['id'] = $insertID === false ? $model->getInsertID() : $insertID;

        return $this->response->setJSON(['status' => 'success', 'data' => $data]);
    }
    
    public function ajaxUpdate()
    {
        $model = new StudentModel();
        
        $id = $this->request->getPost('id');
        $data = [
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'phone'  => $this->request->getPost('phone'),
            'course' => $this->request->getPost('course'),
            'city'   => $this->request->getPost('city')
        ];
        
        $model->update($id, $data);
        
        return $this->response->setJSON(['status' => 'success']);
    }

    public function ajaxDelete()
    {
        $model = new StudentModel();
        $id = $this->request->getPost('id');
        $model->delete($id);
        
        return $this->response->setJSON(['status' => 'success']);
    }
}
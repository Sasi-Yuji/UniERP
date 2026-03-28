<?php

namespace App\Controllers;
use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    // Show form
    public function create()
    {
        return view('employee_form');
    }

    // Save employee
    public function store()
    {
        $model = new EmployeeModel();

        $data = [
            'name'         => $this->request->getPost('name'),
            'department'   => $this->request->getPost('department'),
            'salary'       => $this->request->getPost('salary'),
            'email'        => $this->request->getPost('email'),
            'joining_date' => $this->request->getPost('joining_date')
        ];

        $model->insert($data);

        return redirect()->to('/employees');
    }

    // View employees
    public function index()
    {
        $model = new EmployeeModel();

        $data['employees'] = $model->findAll();

        return view('employee_list', $data);
    }

    public function ajaxUpdate()
    {
        $id = $this->request->getPost('id');
        $data = [
            'name'         => $this->request->getPost('name'),
            'department'   => $this->request->getPost('department'),
            'salary'       => $this->request->getPost('salary'),
            'email'        => $this->request->getPost('email'),
            'joining_date' => $this->request->getPost('joining_date')
        ];
        (new EmployeeModel())->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function ajaxDelete()
    {
        $id = $this->request->getPost('id');
        (new EmployeeModel())->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
}
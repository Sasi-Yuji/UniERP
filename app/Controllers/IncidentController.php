<?php

namespace App\Controllers;
use App\Models\IncidentModel;

class IncidentController extends BaseController
{
    // Load form
    public function add()
    {
        return view('incident_form');
    }

    // Save incident
    public function saveIncident()
    {
        $model = new IncidentModel();

        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'department'  => $this->request->getPost('department'),
            'priority'    => $this->request->getPost('priority'),
            'date'        => $this->request->getPost('date')
        ];

        $model->insert($data);

        return redirect()->to('/incidents');
    }

    // Show incidents
    public function viewIncidents()
    {
        $model = new IncidentModel();

        $data['incidents'] = $model->findAll();

        return view('incident_list', $data);
    }

    public function ajaxUpdate()
    {
        $id = $this->request->getPost('id');
        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'department'  => $this->request->getPost('department'),
            'priority'    => $this->request->getPost('priority'),
            'date'        => $this->request->getPost('date')
        ];
        (new IncidentModel())->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function ajaxDelete()
    {
        $id = $this->request->getPost('id');
        (new IncidentModel())->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
}
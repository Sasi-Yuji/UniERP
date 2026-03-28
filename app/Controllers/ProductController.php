<?php

namespace App\Controllers;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    // Show form
    public function create()
    {
        return view('product_form');
    }

    // Save product
    public function store()
    {
        $model = new ProductModel();

        $data = [
            'name'        => $this->request->getPost('name'),
            'category'    => $this->request->getPost('category'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description')
        ];

        // 🔥 Validation check
        if (!$model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/products');
    }

    // Show list
    public function index()
    {
        $model = new ProductModel();

        $data['products'] = $model->findAll();

        return view('product_list', $data);
    }

    public function ajaxUpdate()
    {
        $id = $this->request->getPost('id');
        $data = [
            'name'        => $this->request->getPost('name'),
            'category'    => $this->request->getPost('category'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description')
        ];
        (new ProductModel())->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function ajaxDelete()
    {
        $id = $this->request->getPost('id');
        (new ProductModel())->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
}
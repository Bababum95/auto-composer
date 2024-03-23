<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Welcome to the API']);
    }
    
    public function getData()
    {
        $data = ['data' => 'Some data'];
        return response()->json(['data' => $data]);
    }
    
    public function createData(Request $request)
    {
        // Логика для создания новых данных на основе запроса
        return response()->json(['message' => 'Data created successfully'], 201);
    }
}

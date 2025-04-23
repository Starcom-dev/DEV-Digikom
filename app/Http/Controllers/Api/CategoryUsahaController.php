<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryUsahaResource;
use App\Models\CategoryUsaha;
use Illuminate\Http\Request;

class CategoryUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryUsaha = CategoryUsaha::orderBy('nama', 'ASC')->get();
        return new CategoryUsahaResource(true, 'List Data Category Usaha', $categoryUsaha);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required'
            ]);
            CategoryUsaha::create(['nama' => $request->nama]);
            return response()->json([
                'success' => true,
                'message' => 'Category Usaha berhasil di tambahkan'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalah create Category Usaha',
                'error' => $th
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

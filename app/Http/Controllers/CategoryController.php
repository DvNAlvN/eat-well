<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\PackageCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PackageCategory::all()->sortBy('categoryId');

        return view('view-all-packages-category', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $validated = $request->validated();

        PackageCategory::create([
            'categoryName' => $validated['categoryName'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', __('category.store_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = PackageCategory::findOrFail($id);

        if ($category->packages()->exists()) {
            return redirect()->back()->with('error',  __('category.delete_failed'));
        }

        $category->delete(); // Soft delete

        return redirect()->back()->with('success', __('category.delete_success'));
    }
}

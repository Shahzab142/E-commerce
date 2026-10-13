<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AdminCategory;

class AdminCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Add Category Form
    |--------------------------------------------------------------------------
    */

    public function add_category()
    {
        return view('admin.add-category');
    }


    /*
    |--------------------------------------------------------------------------
    | Store Category
    |--------------------------------------------------------------------------
    */

    public function create_category(Request $request)
    {
        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:categories,slug',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp,svg',
                'max:4096',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:160',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:published,draft,hidden',
            ],

            'show_on_homepage' => [
                'nullable',
                'boolean',
            ],
        ]);


        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status,
            'show_on_homepage' => $request->boolean('show_on_homepage'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        AdminCategory::create($data);


        return redirect()
            ->route('admin.categories.add')
            ->with('success', 'Category added and published successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | View Categories
    |--------------------------------------------------------------------------
    */

    public function view_category()
    {
        $categories = AdminCategory::query()->withCount('products')->get();

        return view(
            'admin.view-category',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Edit Category Form
    |--------------------------------------------------------------------------
    */

    public function edit_category($id)
    {
        $category = AdminCategory::findOrFail($id);

        return view(
            'admin.edit-category',
            compact('category')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Category
    |--------------------------------------------------------------------------
    */

    public function update_category(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Category
        |--------------------------------------------------------------------------
        */

        $category = AdminCategory::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',

                // Ignore the current category
                // when checking unique name
                Rule::unique('categories', 'name')
                    ->ignore($category->id),
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',

                // Ignore the current category
                // when checking unique slug
                Rule::unique('categories', 'slug')
                    ->ignore($category->id),
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp,svg',
                'max:4096',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:160',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:published,draft,hidden',
            ],

            'show_on_homepage' => [
                'nullable',
                'boolean',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update Category
        |--------------------------------------------------------------------------
        */

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status,
            'show_on_homepage' => $request->boolean('show_on_homepage'),
        ];

        if ($request->hasFile('image')) {
            if ($category->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);


        /*
        |--------------------------------------------------------------------------
        | Redirect After Update
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.categories.view')
            ->with(
                'success',
                'Category updated successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | View Category
    |--------------------------------------------------------------------------
    */
public function show_category($id)
{
    $category = AdminCategory::findOrFail($id);

    return view('admin.show-category', compact('category'));
}
    /*
    |--------------------------------------------------------------------------
    | Delete Category
    |--------------------------------------------------------------------------
    */

    public function delete_category($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Category
        |--------------------------------------------------------------------------
        */

        $category = AdminCategory::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Delete Category
        |--------------------------------------------------------------------------
        */

        $category->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect After Delete
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.categories.view')
            ->with(
                'success',
                'Category deleted successfully.'
            );
    }
}

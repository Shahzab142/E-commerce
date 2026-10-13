<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\AdminProductImage;
use App\Models\Coupon;

class AdminProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Add Category Form
    |--------------------------------------------------------------------------
    */

    public function add_prodcut()
    {
        $categories = AdminCategory::all();
         return view('admin.add-product', compact('categories'));    }


    /*
    |--------------------------------------------------------------------------
    | Store Category
    |--------------------------------------------------------------------------
    */


    public function create_product(Request $request)
    {
        $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Product Information
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'sku' => [
                'required',
                'string',
                'max:255',
                'unique:products,sku',
            ],

            'barcode' => [
                'nullable',
                'string',
                'max:255',
                'unique:products,barcode',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            'regular_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:regular_price',
            ],


            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'stock_status' => [
                'required',
                'in:in_stock,out_of_stock',
            ],


            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            'category_id' => [
                'required',
                'exists:categories,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | Product Status
            |--------------------------------------------------------------------------
            */

                'status' => [
                'required',
                'in:published,draft,pending',
            ],


            /*
            |--------------------------------------------------------------------------
            | Product Images
            |--------------------------------------------------------------------------
            */

            'image' => [
                'nullable',
                'array',
            ],

            'image.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | Coupon
            |--------------------------------------------------------------------------
            */

            'coupon_code' => ['nullable', 'string', 'max:255', 'unique:coupons,code'],
            'coupon_type' => ['nullable', 'in:fixed,percent'],
            'coupon_value' => ['nullable', 'numeric', 'min:0'],
            'coupon_min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'coupon_max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'coupon_usage_limit' => ['nullable', 'integer', 'min:1'],
            'coupon_expires_at' => ['nullable', 'date'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */

        $product = AdminProduct::create([

            'name' => $request->name,

            'sku' => $request->sku,

            'barcode' => $request->barcode,

            'short_description' => $request->short_description,

            'description' => $request->description,

            'regular_price' => $request->regular_price,

            'sale_price' => $request->sale_price,

            'quantity' => $request->quantity,

            'stock_status' => $request->stock_status,

            'category_id' => $request->category_id,

            'status' => $request->status,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Product Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            foreach ($request->file('image') as $index => $image) {

                $path = $image->store('products', 'public');

                AdminProductImage::create([

                    'product_id' => $product->id,

                    'image' => $path,

                    'sort_order' => $index,

                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Create Product Coupon
        |--------------------------------------------------------------------------
        */

        if ($request->filled('has_coupon')) {
            Coupon::create([
                'code' => strtoupper($request->coupon_code),
                'type' => $request->coupon_type ?? 'fixed',
                'value' => $request->coupon_value ?? 0,
                'min_order_amount' => $request->coupon_min_order_amount ?? 0,
                'max_discount_amount' => $request->coupon_max_discount_amount,
                'usage_limit' => $request->coupon_usage_limit,
                'expires_at' => $request->coupon_expires_at,
                'is_active' => true,
                'product_id' => $product->id,
                'scope' => 'product',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.products.add')
            ->with('success', 'Product added successfully.');
    }

    public function import_view()
    {
        return view('admin.import-products');
    }

    public function import_excel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), "r");
        
        $header = true;
        while ($row = fgetcsv($handle)) {
            if ($header) {
                $header = false;
                continue;
            }
            
            // Expected CSV structure: Name, SKU, Regular Price, Quantity, Category ID
            if(count($row) >= 5) {
                \App\Models\AdminProduct::create([
                    'name' => $row[0],
                    'sku' => $row[1],
                    'regular_price' => (float) $row[2],
                    'quantity' => (int) $row[3],
                    'category_id' => (int) $row[4],
                    'stock_status' => 'in_stock',
                    'status' => 'published',
                ]);
            }
        }
        
        fclose($handle);

        return redirect()->route('admin.products.view')->with('success', 'Products imported successfully from Excel/CSV!');
    }

    public function view_product()
    {
        $products = AdminProduct::with(['category', 'images'])->get();

        return view(
            'admin.view-product',
            compact('products')
        );
    }

   public function show_product($id)
{
    $prod = AdminProduct::with([
        'category',
        'images'
    ])->findOrFail($id);

    return view(
        'admin.show-product',
        compact('prod')
    );
}

public function edit_product($id)
{
    $product = AdminProduct::with(['category', 'images', 'coupon'])->findOrFail($id);

    $categories = AdminCategory::all();

    return view('admin.edit-product', compact('product', 'categories'));
}


//     /*
//     |--------------------------------------------------------------------------
//     | Update Category
//     |--------------------------------------------------------------------------
//     */

    public function update_product(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Category
        |--------------------------------------------------------------------------
        */

        $product = AdminProduct::findOrFail($id);


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

             'sku' => [
            'required',
            'string',
            'max:255',
            Rule::unique('products', 'sku')->ignore($product->id),
        ],

        'barcode' => [
            'nullable',
            'string',
            'max:255',
            Rule::unique('products', 'barcode')->ignore($product->id),
        ],


             'regular_price' => [
            'required',
            'numeric',
            'min:0',
        ],

        'sale_price' => [
            'nullable',
            'numeric',
            'min:0',
            'lte:regular_price',
        ],

        'quantity' => [
            'required',
            'integer',
            'min:0',
        ],

        'stock_status' => [
            'required',
            'in:in_stock,out_of_stock',
        ],

        'category_id' => [
            'required',
            'exists:categories,id',
        ],

        'status' => [
            'required',
            'in:published,draft,pending',
        ],

        'image' => [
            'nullable',
            'array',
        ],

        'image.*' => [
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update([
 'name' => $request->name,

        'sku' => $request->sku,

        'barcode' => $request->barcode,

        'short_description' => $request->short_description,

        'description' => $request->description,

        'regular_price' => $request->regular_price,

        'sale_price' => $request->sale_price,

        'quantity' => $request->quantity,

        'stock_status' => $request->stock_status,

        'category_id' => $request->category_id,

        'status' => $request->status,

        ]);

        //Update Image 

        if($request->hasFile('image')) {

            // Delete existing images
            $this->deleteImages($product);

            foreach ($request->file('image') as $index => $image) {
                $path = $image->store('products', 'public');

                AdminProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update Product Coupon
        |--------------------------------------------------------------------------
        */

        if ($request->filled('has_coupon')) {
            $couponData = [
                'code' => strtoupper($request->coupon_code),
                'type' => $request->coupon_type ?? 'fixed',
                'value' => $request->coupon_value ?? 0,
                'min_order_amount' => $request->coupon_min_order_amount ?? 0,
                'max_discount_amount' => $request->coupon_max_discount_amount,
                'usage_limit' => $request->coupon_usage_limit,
                'expires_at' => $request->coupon_expires_at,
                'is_active' => true,
                'product_id' => $product->id,
                'scope' => 'product',
            ];

            if ($product->coupon) {
                $product->coupon->update($couponData);
            } else {
                Coupon::create($couponData);
            }
        } else {
            if ($product->coupon) {
                $product->coupon->update(['is_active' => false]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect After Update
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.products.view')
            ->with(
                'success',
                'Product updated successfully.'
            );
    }

//   
//     /*
//     |--------------------------------------------------------------------------
//     | Delete Product
//     |--------------------------------------------------------------------------
//     */

    public function delete_product($id)
    {
        DB::transaction(function () use ($id): void {
            $product = AdminProduct::findOrFail($id);
            $this->deleteImages($product);
            $product->delete();
        });

        return redirect()
            ->route('admin.products.view')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Approve or reject a vendor-submitted product.
     */
    public function updateProductStatus(Request $request, AdminProduct $product): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:published,draft'],
        ]);

        $product->update(['status' => $validated['status']]);

        $message = $validated['status'] === 'published'
            ? 'Product approved and published successfully.'
            : 'Product rejected and moved back to draft.';

        return back()->with('success', $message);
    }

    private function deleteImages(AdminProduct $product): void
    {
        $images = $product->images()->get();
        Storage::disk('public')->delete($images->pluck('image')->all());
        $product->images()->delete();
    }
}
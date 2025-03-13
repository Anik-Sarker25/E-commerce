<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductFeaturedImage;
use App\Models\ProductVariants;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "all products";
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'products'],
            ['url' => route('admin.products.index'), 'title' => 'all products'],
        ];
        if (request()->ajax()) {
            $data = Product::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('thumbnail', function ($row) {
                    if ($row->thumbnail) {
                        $thumbnail = '<img src="'.asset($row->thumbnail). '" alt="Product-image" class="rounded" style="max-width: 48px;">';
                    } else {
                        $thumbnail = '---';
                    }
                    return $thumbnail;
                })
                ->addColumn('item_code', function ($row) {
                    if ($row->item_code) {
                        return '#'.$row->item_code;
                    } else {
                        return '---';
                    }
                })
                ->addColumn('stock_quantity', function ($row) {
                    if ($row->stock_quantity) {
                        return $row->stock_quantity;
                    } else {
                        return '0';
                    }
                })
                ->addColumn('status', function ($row) {
                    if($row->status ==  Constant::STATUS['active']) {
                        $status = '<button type="button" class="btn btn-sm btn-outline-success">Active</button>';
                    }else {
                        $status = '<button type="button" class="btn btn-sm btn-outline-warning">Deactive</button>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<a href="'.route('admin.products.edit', $row->id).'" type="button" class="btn btn-sm btn-outline-success mb-2 me-2"><i class="fas fa-edit"></i></a>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2 me-2"><i class="fas fa-trash-alt"></i></button>';
                    $btn3 = '<button onclick="view(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success mb-2 me-2"><i class="fas fa-eye"></i></button>';
                    return $btn3.$btn1.$btn2;
                })
                ->rawColumns(['sl', 'thumbnail', 'code_item', 'stock_quantity', 'status', 'action'])
                ->make(true);
        }

        return view('admin.products.products', compact('pageTitle', 'breadcrumbs'));
    }

    public function create()  {
        $data = "";
        $pageTitle = "add new product";
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'products'],
            ['url' => route('admin.products.create'), 'title' => 'add new product'],
        ];
        return view('admin.products.create', compact('data', 'pageTitle', 'breadcrumbs'));
    }

    public function store(ProductStoreRequest $request)
    {
        try {
            if ($request->hasFile('thumbnail')) {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('thumbnail'));
                $assign_name = "thumbnail-".date('his').".".$request->file('thumbnail')->getClientOriginalExtension();
                // $image->resize(420, 510);
                $image->save(base_path('public/uploads/products/'.$assign_name, 80, 'png'));
                $imagePath = '/uploads/products/'.$assign_name;
            }else {
                $imagePath = null;

            }

            $subcategory = ($request->has('subcategory_id') && $request->subcategory_id !== "null") ? $request->subcategory_id : null;
            $childcategory = ($request->has('childcategory_id') && $request->childcategory_id !== "null") ? $request->childcategory_id : null;

            $data = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'buy_price' => $request->buy_price,
                'mrp_price' => $request->mrp_price,
                'discount_price' => $request->discount_price,
                'sell_price' => $request->sell_price,
                'category_id' => $request->category_id,
                'subcategory_id' => $subcategory,
                'childcategory_id' => $childcategory,
                'brand_id' => $request->brand_id,
                'keywords' => $request->keywords,
                'thumbnail' => $imagePath,
                'description' => $request->description,
                'product_type' => $request->product_type,
                'deals_time' => strtotime($request->deals_time),
                'stock_quantity' => $request->stock ?? 0,
                'unit' => $request->unit,
                'return' => $request->product_return,
                'warranty' => $request->warranty,
                'delivery_type' => $request->delivery_type,
                'status' => $request->status,
            ]);

            $itemCode = str_pad($data->id, 4, "0", STR_PAD_LEFT) . rand(1000, 9999);

            $data->update(['item_code' => $itemCode]);

            // Handle Featured Images Upload
            if ($request->hasFile('featured_images')) {
                $manager = new ImageManager(new Driver());

                foreach ($request->file('featured_images') as $file) {
                    $image = $manager->read($file);
                    $assign_name = "featured-" . date('his') . "-" . uniqid() . "." . $file->getClientOriginalExtension();
                    // $image->resize(850, 1036);
                    $image->save(public_path('uploads/products/featured/' . $assign_name), 80, 'png');

                    // Create a new FeaturedImage instance
                    $featuredImage = new ProductFeaturedImage();
                    $featuredImage->product_id = $data->id;
                    $featuredImage->image = '/uploads/products/featured/'. $assign_name;
                    $featuredImage->save();
                }

            }

            // Handle Variants Upload
            if ($request->has('variants')) {
                $data->update(['has_variants' => true]);
                foreach ($request->variants as $variant) {
                    $variantData = [
                        'product_id' => $data->id,
                        'color_name' => $variant['color_name'],
                        'color_code' => $variant['color'],
                        'size' => $variant['size'],
                        'storage_capacity' => $variant['storage_capacity'],
                        'buy_price' => $variant['buy_price'],
                        'mrp_price' => $variant['mrp_price'],
                        'discount_price' => $variant['discount_price'],
                        'sell_price' => $variant['sell_price'],
                        'stock_quantity' => $variant['stock_quantity'],
                    ];

                    // Handle image for variant
                    if (isset($variant['image'])) {
                        $image = $variant['image'];

                        $manager = new ImageManager(new Driver());
                        $imageObj = $manager->read($image);
                        $assign_name = "variant-" . uniqid() . '.' . $image->getClientOriginalExtension();

                        // Save the image (you can resize it if needed)
                        $imageObj->save(public_path('uploads/products/variants') . '/' . $assign_name, 80, 'png');

                        // Store the image path in the variant data array
                        $variantData['color_image'] = '/uploads/products/variants/' . $assign_name;
                    }
                    // Create a new ProductVariant instance
                    ProductVariants::create($variantData);
                }
            } else {
                $data->update(['has_variants' => false]);
            }

            return response()->json();
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function edit($id)  {
        $data = Product::with(['featuredImages', 'category', 'subcategory', 'variants'])->find($id);
        $pageTitle = "Edit product";
        $breadcrumbs = [
            ['url' => route('admin.products.index'), 'title' => 'products'],
            ['url' => route('admin.products.edit', $id), 'title' => 'edit product'],
        ];
        return view('admin.products.create', compact('data', 'pageTitle', 'breadcrumbs'));
    }

    public function singleView($id) {
        $modalTitle = "Product Details";
        $data = Product::with(['featuredImages', 'category', 'subcategory'])->find($id);
        return response()->json([
            'view' => view('admin.products.models.model_body', compact('data'))->render(),
            'modalTitle' => $modalTitle
        ]);
    }

    public function update(ProductUpdateRequest $request, $id) {
        try {
            $data = Product::find($id);
            if ($request->hasFile('thumbnail')) {
                if ($data->thumbnail != null) {
                    $old_img = public_path($data->thumbnail);
                    if (file_exists($old_img)) {
                        unlink($old_img);
                    }
                }
                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('thumbnail'));
                $assign_name = "thumbnail-".date('his').".".$request->file('thumbnail')->getClientOriginalExtension();
                // $image->resize(420, 510);
                $image->save(base_path('public/uploads/products/'.$assign_name, 80, 'png'));
                $imagePath = '/uploads/products/'.$assign_name;
            } else {
                $imagePath = $data->thumbnail;
            }

            $subcategory = ($request->has('subcategory_id') && $request->subcategory_id !== "null") ? $request->subcategory_id : null;
            $childcategory = ($request->has('childcategory_id') && $request->childcategory_id !== "null") ? $request->childcategory_id : null;

            $data->name = $request->name;
            $data->slug = Str::slug($request->name);
            $data->buy_price = $request->buy_price;
            $data->mrp_price = $request->mrp_price;
            $data->discount_price = $request->discount_price;
            $data->sell_price = $request->sell_price;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $subcategory;
            $data->childcategory_id = $childcategory;
            $data->brand_id = $request->brand_id;
            $data->keywords = $request->keywords;
            $data->thumbnail = $imagePath;
            $data->description = $request->description;
            $data->product_type = $request->product_type;
            $data->deals_time = strtotime($request->deals_time);
            $data->stock_quantity = $request->stock ?? 0;
            $data->unit = $request->unit;
            $data->return = $request->product_return;
            $data->warranty = $request->warranty;
            $data->delivery_type = $request->delivery_type;
            $data->status = $request->status;
            $data->save();

            // Handle Featured Images Upload
            if ($request->hasFile('featured_images')) {
                $manager = new ImageManager(new Driver());

                foreach ($request->file('featured_images') as $file) {
                    $image = $manager->read($file);
                    $assign_name = "featured-" . date('his') . "-" . uniqid() . "." . $file->getClientOriginalExtension();
                    // $image->resize(850, 1036);
                    $image->save(public_path('uploads/products/featured/' . $assign_name), 80, 'png');

                    // Create a new FeaturedImage instance
                    $featuredImage = new ProductFeaturedImage();
                    $featuredImage->product_id = $data->id;
                    $featuredImage->image = '/uploads/products/featured/'. $assign_name;
                    $featuredImage->save();
                }

            }

            // Handle Variants Update
            if ($request->has('variants_delete')) {
                // If no variants were sent in the request, remove all existing ones
                $removeVariants = ProductVariants::where('product_id', $data->id)->get();

                foreach ($removeVariants as $variant) {
                    if (!empty($variant->color_image)) {
                        $imagePath = public_path($variant->color_image);

                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }

                ProductVariants::where('product_id', $data->id)->delete();
                $data->has_variants = false;
                $data->save();
            }else if ($request->has('variants') && !empty($request->variants)) {
                $data->has_variants = true;
                $data->save();

                $existingVariantIds = ProductVariants::where('product_id', $data->id)->pluck('id')->toArray(); // for removing old variants
                $updatedVariantIds = [];

                foreach ($request->variants as $variant) {
                    // Find existing variant
                    $productVariant = ProductVariants::where('product_id', $data->id)
                        ->where('id', $variant['variant_id'])
                        ->first();

                    $variantData = [
                        'product_id' => $data->id,
                        'color_name' => $variant['color_name'],
                        'color_code' => $variant['color'],
                        'size' => $variant['size'],
                        'storage_capacity' => $variant['storage_capacity'],
                        'buy_price' => $variant['buy_price'],
                        'mrp_price' => $variant['mrp_price'],
                        'discount_price' => $variant['discount_price'],
                        'sell_price' => $variant['sell_price'],
                        'stock_quantity' => $variant['stock_quantity'],
                    ];

                    // Handle image for variant
                    if (isset($variant['image'])) {
                        if ($productVariant && $productVariant->color_image) {
                            $oldImagePath = public_path($productVariant->color_image);
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath); // Delete old image
                            }
                        }

                        $image = $variant['image'];
                        $manager = new ImageManager(new Driver());
                        $imageObj = $manager->read($image);
                        $assign_name = "variant-" . uniqid() . '.' . $image->getClientOriginalExtension();
                        $imageObj->save(public_path('uploads/products/variants/' . $assign_name), 80, 'png');
                        $variantData['color_image'] = '/uploads/products/variants/' . $assign_name;
                    }

                    if ($productVariant) {
                        $productVariant->update($variantData);
                        $updatedVariantIds[] = $productVariant->id;
                    } else {
                        $newVariant = ProductVariants::create($variantData);
                        $updatedVariantIds[] = $newVariant->id;
                    }
                }
                // Get all variants that will be deleted
                $variantsToDelete = ProductVariants::where('product_id', $data->id)
                    ->whereNotIn('id', $updatedVariantIds)
                    ->get();

                foreach ($variantsToDelete as $variant) {
                    if (!empty($variant->color_image)) {
                        $imagePath = public_path($variant->color_image);

                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }

                // Now delete variants that are not in the updated list
                ProductVariants::where('product_id', $data->id)
                    ->whereNotIn('id', $updatedVariantIds)
                    ->delete();

            }


            return response()->json();

        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function destroy($id) {
        try {
            $data = Product::find($id);
            if($data) {
                $data->featuredImages()->delete();
                $data->delete();
            }
            return response()->json(['success' => true,'message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function removeImage($id) {
        try {
            $data = Product::findOrFail($id);
            if($data->thumbnail != null){
                $old_img = public_path($data->thumbnail);
                if (file_exists($old_img)) {
                    unlink($old_img);
                }
            }
            $data->thumbnail = null;
            $data->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }


    public function removeFeaturedImage($id) {
        try {
            $data = ProductFeaturedImage::findOrFail($id);
            if($data->image != null){
                $old_img = public_path($data->image);
                if (file_exists($old_img)) {
                    unlink($old_img);
                }
            }
            $data->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }


}

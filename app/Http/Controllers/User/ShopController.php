<?php

namespace App\Http\Controllers\User;

use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Partnership;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductVariants;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request) {

        // shop page filter contents start
        if (request()->has('filterBrand_id') && empty($request->category_id) && empty($request->max)) {
            $filterBrand_id = $request->filterBrand_id; // Define $brand_id
            $products = Product::where('brand_id', $filterBrand_id)->orderBy('id', 'DESC')->get();
            return response()->json($products);
        }
        if (request()->has('filterWarranty') && empty($request->category_id) && empty($request->max)) {
            $filterWarranty = $request->filterWarranty;
            $products = Product::whereIn('warranty', $filterWarranty)->orderBy('id', 'DESC')
              ->get();
            return response()->json($products);
        }
        if (request()->has('filterWarranty') && request()->has('category_id') && empty($request->max)) {
            $filterWarranty = $request->filterWarranty;
            $category_id = $request->category_id;
            $products = Product::whereIn('warranty', $filterWarranty)->where('category_id', $category_id)->orderBy('id', 'DESC')
              ->get();
            return response()->json($products);
        }
        if(request()->has('filterColor') && request()->has('category_id') && empty($request->max)) {
            $category_id = $request->category_id;
            $colors = $request->filterColor;

            if (!empty($colors) && is_array($colors)) {
                
                $productIds = ProductVariants::whereIn('color_name', $colors)
                ->pluck('product_id')->unique();
    
                // Get products with matching IDs and category
                $products = Product::whereIn('id', $productIds)
                            ->where('category_id', $category_id)
                            ->orderBy('id', 'DESC')
                            ->get();
                return response()->json($products);
            }
        }
        if(request()->has('filterColor') && request()->has('category_id') && request()->has('max')) {
            $category_id = $request->category_id;
            $colors = $request->filterColor;
            $max = $request->max;
            $min = $request->min;

            if (!empty($colors) && is_array($colors)) {
                $productIds = ProductVariants::whereIn('color_name', $colors)
                ->pluck('product_id')->unique();
    
                // Get products with matching IDs and category
                $products = Product::whereIn('id', $productIds)
                            ->where('category_id', $category_id)
                            ->where('sell_price', '<=', $max)
                            ->where('sell_price', '>=', $min)
                            ->orderBy('id', 'DESC')
                            ->get();
                return response()->json($products);
            }
        }
        if (request()->has('filterColor') && empty($request->category_id) && empty($request->max) && empty($request->filterBrand_id)) {
            $colors = $request->filterColor;
            
            $productIds = ProductVariants::whereIn('color_name', $colors)
            ->pluck('product_id')->unique();

            // Get products with matching IDs and category
            $products = Product::whereIn('id', $productIds)->get();
            return response()->json($products);
        }
        if (request()->has('filterBrand_id') && request()->has('category_id') && empty($request->max) && empty($request->min)) {
            $category_id = $request->category_id;
            $filterBrand_id = $request->filterBrand_id; // Define $brand_id
            $products = Product::where('category_id', $category_id)->where('brand_id', $filterBrand_id)->orderBy('id', 'DESC')->get();
            return response()->json($products);
        }
        if (request()->has('category_id')) {
            if(empty($request->max) && empty($request->min)) {
                $category_id = $request->category_id;
                $products = Product::where('category_id', $category_id)->orderBy('id', 'DESC')->get();
                return response()->json($products);
            }
            if (!empty($request->max) && empty($request->min)) {
                $category_id = $request->category_id;
                $max = $request->max;
                $products = Product::where('category_id', $category_id)->where('sell_price', '<=', $max)->orderBy('id', 'DESC')->get();
                return response()->json($products);
            }
            if (!empty($request->min) && empty($request->max)) {
                $category_id = $request->category_id;
                $min = $request->min;
                $products = Product::where('category_id', $category_id)->where('sell_price', '>=', $min)->orderBy('id', 'DESC')->get();
                return response()->json($products);
            }
        }
        if (request()->has('category_id') && request()->has('min') && request()->has('max')) {
            $category_id = $request->category_id;
            $min = $request->min;
            $max = $request->max;
            // Ensure min and max are numeric before filtering
            if (is_numeric($min) && is_numeric($max)) {
                $products = Product::where('category_id', $category_id)
                    ->whereBetween('sell_price', [$min, $max])
                    ->orderBy('id', 'DESC')
                    ->get();

                return response()->json($products);
            }elseif (is_numeric($min) && is_numeric($max) && request()->has('filterBrand_id')) {
                $filterBrand_id = $request->filterBrand_id;
                $products = Product::where('category_id', $category_id)->where('brand_id', $filterBrand_id)
                    ->whereBetween('sell_price', [$min, $max])
                    ->orderBy('id', 'DESC')
                    ->get();
                return response()->json($products);
            }
        }
        if (request()->has('min') && request()->has('max')) {
            $min = $request->min; // Define $min
            $max = $request->max; // Define $max
            if (request()->has('filterBrand_id') && is_numeric($min) && is_numeric($max) && empty($request->category_id)) {
                $filterBrand_id = $request->filterBrand_id;
                $products = Product::where('brand_id', $filterBrand_id)->whereBetween('sell_price', [$min, $max])->orderBy('id', 'DESC')->get();
            }
            elseif (is_numeric($min) && is_numeric($max)) {
                $products = Product::whereBetween('sell_price', [$min, $max])->orderBy('id', 'DESC')->get();
            } elseif (is_numeric($min)) {
                $products = Product::where('sell_price', '>=', $min)->orderBy('id', 'DESC')->get();
            } elseif (is_numeric($max)) {
                $products = Product::where('sell_price', '<=', $max)->orderBy('id', 'DESC')->get();
            }
            return response()->json($products);
        }
        // shop page filter contents end

        // shop page contents
        $big_sale = $request->get('big_sale');
        $brand_id = $request->query('brand');
        $brand_name = $request->query('brand_name');
        if (request()->has('big_sale')) {
            $big_sale = $request->big_sale; // Define $big_sale
            $products = Product::where('product_type', $big_sale)->orderBy('id', 'DESC')->get();
        } elseif (request()->has('brand')) {
            $brand_id = $request->brand; // Define $brand_id
            $products = Product::where('brand_id', $brand_id)->orderBy('id', 'DESC')->get();
        } else {
            $products = Product::orderBy('id', 'DESC')->get();
        }

        $allProducts = Product::all();
        $colors = collect();
        
        foreach ($allProducts as $product) {
            foreach ($product->variants as $variant) {
                if ($variant->color_name) { // make sure color_name exists
                    $colors->push($variant->color_name);
                }
            }
        }
        
        $colors = $colors->unique()->values();

        $categories           = Category::with('subcategories.products')->get();
        $paymentMethods       = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands               = Brand::orderBy('id', 'ASC')->get();
        $partnerships         = Partnership::orderBy('id', 'ASC')->get();
        $pageTitle            = siteInfo()->site_title . ' | shop' ;

        if(request()->has('big_sale')) {
            $breadcrumbs = [
                ['url' => route('home'), 'title' => 'home'],
                ['url' => route('shop') . '?big_sale=' . Constant::PRODUCT_TYPE['big_sale'], 'title' => 'big sale'],
            ];
        }elseif(request()->has('brand')) {
            $breadcrumbs = [
                ['url' => route('home'), 'title' => 'home'],
                ['url' => url(route('shop') . '?brand=' . $brand_id . '&brand_name=' . urlencode($brand_name)), 'title' => $brand_name],
            ];
        }else {
            $breadcrumbs = [
                ['url' => route('home'), 'title' => 'home'],
                ['url' => route('shop'), 'title' => 'shop'],
            ];
        }

        return view('customer.shop.shop', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'products'             => $products,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'breadcrumbs'          => $breadcrumbs,
            'colors'               => $colors,
        ]);
    }

    public function categoryShow(Request $request, $slug) {
        $catId = $request->query('cat_id');
        if ($catId) {
            $products         = Product::where('category_id', $catId)->orderBy('id', 'DESC')->get();
        } else {
            $products         = collect();
        }
        
        $allProducts = Product::all();
        $colors = collect();
        
        foreach ($allProducts as $product) {
            foreach ($product->variants as $variant) {
                if ($variant->color_name) { // make sure color_name exists
                    $colors->push($variant->color_name);
                }
            }
        }
        $colors = $colors->unique()->values();

        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $category         = Category::where('slug', $slug)->first();
        $pageTitle        = $category->name ?? null;

        $breadcrumbs = array_filter([
            ['url' => route('home'), 'title' => 'home'],
            $category ? ['url' => route('category.show', $category->slug) . '?cat_id=' . $catId, 'title' => $category->name] : null,
        ]);

        return view('customer.shop.shop', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'products'             => $products,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'breadcrumbs'          => $breadcrumbs,
            'colors'               => $colors,
        ]);
    }

    public function subcategoryShow(Request $request, $slug) {
        $subcatId = $request->query('subcat_id');
        if ($subcatId) {
            $products = Product::where('subcategory_id', $subcatId)->with('variants')->orderBy('id', 'DESC')->get();
        } else {
            $products = collect(); // make it an empty collection instead of ''
        }
        
        $allProducts = Product::all();
        $colors = collect();
        
        foreach ($allProducts as $product) {
            foreach ($product->variants as $variant) {
                if ($variant->color_name) { // make sure color_name exists
                    $colors->push($variant->color_name);
                }
            }
        }
        
        $colors = $colors->unique()->values();
        


        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $subcategory      = SubCategory::where('slug', $slug)->first();
        $category         = $subcategory->category ?? null;
        $pageTitle        = $subcategory->name ?? null;

        $breadcrumbs = array_filter([
            ['url' => route('home'), 'title' => 'home'],
            $category ? ['url' => route('category.show', $category->slug) . '?cat_id=' . $category->id, 'title' => $category->name] : null,
            $subcategory ? ['url' => route('subcategory.show', $subcategory->slug) . '?subcat_id=' . $subcatId, 'title' => $subcategory->name] : null,
        ]);
        return view('customer.shop.shop', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'products'             => $products,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'breadcrumbs'          => $breadcrumbs,
            'colors'               => $colors,
        ]);
    }

    public function childcategoryShow(Request $request, $slug) {
        $childcatId = $request->query('childcat_id');
        if ($childcatId) {
            $products         = Product::where('childcategory_id', $childcatId)->orderBy('id', 'DESC')->get();
        }else {
            $products         = collect();
        }
        
        $allProducts = Product::all();
        $colors = collect();
        
        foreach ($allProducts as $product) {
            foreach ($product->variants as $variant) {
                if ($variant->color_name) { // make sure color_name exists
                    $colors->push($variant->color_name);
                }
            }
        }
        
        $colors = $colors->unique()->values();

        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $childcategory    = ChildCategory::where('slug', $slug)->first();
        $subcategory      = $childcategory->subcategory ?? null;
        $category         = $subcategory->category ?? null;
        $pageTitle        = $childcategory->name ?? null;

        $breadcrumbs = array_filter([
            ['url' => route('home'), 'title' => 'home'],
            $category ? ['url' => route('category.show', $category->slug) . '?cat_id=' . $category->id, 'title' => $category->name] : null,
            $subcategory ? ['url' => route('subcategory.show', $subcategory->slug) . '?subcat_id=' . $subcategory->id, 'title' => $subcategory->name] : null,
            $childcategory ? ['url' => route('childcategory.show', $childcategory->slug) . '?childcat_id=' . $childcatId, 'title' => $childcategory->name] : null,
        ]);
        return view('customer.shop.shop', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'products'             => $products,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'breadcrumbs'          => $breadcrumbs,
            'colors'               => $colors,
        ]);
    }

    public function productShow(Request $request, $slug)  {
        $product_id = $request->query('pro');

        if ($product_id) {
            $product          = Product::with('featuredImages')->where('id', $product_id)->first();
        } else {
            $product          = collect();
        }


        $address = null;

        if (auth()->check()) {
            $address = Address::where('user_id', auth()->user()->id)
                ->where('status', Constant::STATUS['active'])
                ->first();
        }
        $pageTitle        = $product->name;
        $categories       = Category::with('subcategories.products')->get();
        $paymentMethods   = PaymentMethod::orderBy('id', 'DESC')->get();
        $brands           = Brand::orderBy('id', 'ASC')->get();
        $partnerships     = Partnership::orderBy('id', 'ASC')->get();
        $category         = $product->category ?? null;
        $subcategory      = $product->subcategory ?? null;
        $childcategory    = $product->childcategory ?? null;
        $category_id      = $product->category_id ?? null;
        $subcategory_id   = $product->subcategory_id ?? null;
        $childcategory_id = $product->childcategory_id ?? null;
        $productReviews   = ProductReview::where('product_id', $product->id)
                            ->where('status', Constant::REVIEW_STATUS['approved'])->get();

        $relatedProducts = Product::where('category_id', $category_id)->where('id', '!=', $product->id)->get();
        // random product
        $randomProducts = Product::inRandomOrder()->limit(7)->get();


        $breadcrumbs = array_filter([
            ['url' => route('home'), 'title' => 'home'],
            $category ? ['url' => route('category.show', $category->slug) . '?cat_id=' . $category_id, 'title' => $category->name] : null,
            $subcategory ? ['url' => route('subcategory.show', $subcategory->slug) . '?subcat_id=' . $subcategory_id, 'title' => $subcategory->name] : null,
            $childcategory ? ['url' => route('childcategory.show', $childcategory->slug) . '?childcat_id=' . $childcategory_id, 'title' => $childcategory->name] : null,
            $product ? ['url' => route('product.show', $product->slug) . '?pro=' . $product_id, 'title' => $product->name] : null,
        ]);


    $total_reviews = ProductReview::where('product_id', $product->id)->count();

    // Get count per rating (1–5)
    $star_counts = ProductReview::where('product_id', $product->id)
        ->selectRaw('rating, COUNT(*) as total')
        ->groupBy('rating')
        ->pluck('total', 'rating')
        ->toArray();

    // Make sure all 1–5 ratings exist
    $ratings = [];
    for ($i = 1; $i <= 5; $i++) {
        $ratings[$i] = $star_counts[$i] ?? 0;
    }

    $average_rating = ProductReview::where('product_id', $product->id)->avg('rating');

        return view('customer.product.single_product', [
            'address'              => $address,
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'product'              => $product,
            'products'             => $product,
            'paymentMethods'       => $paymentMethods,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
            'breadcrumbs'          => $breadcrumbs,
            'relatedProducts'      => $relatedProducts,
            'randomProducts'       => $randomProducts,
            'productReviews'       => $productReviews,
            'ratings'              => $ratings,
            'total_reviews'        => $total_reviews,
            'average_rating'       => $average_rating,
        ]);
    }

}

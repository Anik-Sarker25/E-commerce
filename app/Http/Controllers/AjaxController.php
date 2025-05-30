<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Models\AdvertiseBanner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Country;
use App\Models\DeliveryOption;
use App\Models\Product;
use App\Models\ProductVariants;
use App\Models\SubCategory;
use App\Models\VariantOption;
use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Division;
use Devfaysal\BangladeshGeocode\Models\Union;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    public function getCountry(){
        $data = Country::all();
        return response()->json($data);
    }
    public function getDivisions(){
        $data = Division::all();
        return response()->json($data);
    }
    public function getDistricts($division){
        $data = District::where('division_id', $division)->get();
        return response()->json($data);
    }
    public function getUpazilas($district){
        $data = Upazila::where('district_id', $district)->get();
        return response()->json($data);
    }

    public function getUnions($upazila){
        $data = Union::where('upazila_id', $upazila)->get();
        return response()->json($data);
    }

    public function getBanners($id) {
        $data = AdvertiseBanner::where('id', $id)->first();
        return response()->json($data);
    }

    public function getCategory() {
        $data = Category::all();
        return response()->json($data);
    }
    public function getProducts() {
        $data = Product::all();
        return response()->json($data);
    }
    public function getColorFamily($id) {
        $data = ProductVariants::where('product_id', $id)->get();
        return response()->json($data);
    }
    public function getProductsPrice($id) {
        $data = Product::where('id', $id)->first();
        return response()->json($data);
    }
    
    public function getProductsvariantOptions(Request $request)
    {
        $product_id = $request->product_id;
        $color = $request->color;
    
        $variantOptions = VariantOption::where('product_id', $product_id)
            ->where('color_family', $color)
            ->get()
            ->groupBy('variant_type');
    
        $flippedTypes = array_flip(Constant::VARIANT_TYPES);

        $variantLabels = [];
        foreach ($flippedTypes as $id => $key) {
            $variantLabels[$id] = Str::title(str_replace('_', ' ', $key));
        }
        return response()->json([
            'options' => $variantOptions,
            'labels' => $variantLabels
        ]);
    }

    public function getProductsvariantOptionsData($id) {
        $data = VariantOption::where('id', $id)->first();
        return response()->json($data);
    }
    

    public function getAllSubCategory() {
        $data = SubCategory::all();
        return response()->json($data);
    }

    public function getSubCategory($id) {
        $data = SubCategory::where('category_id', $id)->get();
        return response()->json($data);
    }

    public function getchildCategory($id) {
        $data = ChildCategory::where('subcategory_id', $id)->get();
        return response()->json($data);
    }

    public function getBrand() {
        $data = Brand::all();
        return response()->json($data);
    }
    public function deliveryType() {
        $data = DeliveryOption::all();
        return response()->json($data);
    }

}

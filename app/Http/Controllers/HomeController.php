<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Models\AdvertiseBanner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Partnership;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Services;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pageTitle            = siteInfo()->site_title;
        $categories           = Category::with('subcategories.products')->get();
        $products             = Product::orderBy('id', 'DESC')->take(12)->get();
        $rendomproducts       = Product::inRandomOrder()->take(12)->get();
        $featuredProducts     = Product::where('product_type', Constant::PRODUCT_TYPE['featured'])->orderBy('id', 'DESC')->take(12)->get();
        $big_saleProducts     = Product::where('product_type', Constant::PRODUCT_TYPE['big_sale'])->orderBy('id', 'DESC')->take(12)->get();
        $Latest_dealsProducts = Product::where('product_type', Constant::PRODUCT_TYPE['Latest_deals'])->orderBy('id', 'DESC')->take(12)->get();
        $banners              = AdvertiseBanner::orderBy('id', 'DESC')->get();
        $homePagebanners      = AdvertiseBanner::where('banner_type', Constant::BANNER_TYPE['home_banner'])->orderBy('id', 'DESC')->get();
        $paymentMethods       = PaymentMethod::orderBy('id', 'DESC')->get();
        $services             = Services::orderBy('id', 'ASC')->get();
        $brands               = Brand::orderBy('id', 'ASC')->get();
        $partnerships         = Partnership::orderBy('id', 'ASC')->get();

        return view('index', [
            'pageTitle'            => $pageTitle,
            'categories'           => $categories,
            'products'             => $products,
            'rendomproducts'       => $rendomproducts,
            'featuredProducts'     => $featuredProducts,
            'big_saleProducts'     => $big_saleProducts,
            'Latest_dealsProducts' => $Latest_dealsProducts,
            'banners'              => $banners,
            'homePagebanners'      => $homePagebanners,
            'paymentMethods'       => $paymentMethods,
            'services'             => $services,
            'brands'               => $brands,
            'partnerships'         => $partnerships,
        ]);
    }
}

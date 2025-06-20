<?php

use App\Helpers\Constant;
use App\Models\Address;
use App\Models\Admin;
use App\Models\AdvertiseBanner;
use App\Models\Category;
use App\Models\Company_info;
use App\Models\CompanyInfo;
use App\Models\Country;
use App\Models\GeneralSettings;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ShipmentTracking;
use App\Models\SocialMedia;
use App\Models\VariantOption;
use Illuminate\Support\Facades\Request;

function admin() {
    return Admin::where('id', 1)->where('role', Constant::USER_TYPE['admin'])->first();
}
function country() {
    $data = Country::where('id', 1)->first();
    return $data;
}
function dateFormat($date) {
    return date('d M Y', $date);
}
function dateFormat2($timestamp) {
    if (empty($timestamp) || !is_numeric($timestamp)) {
        return "";
    }
    return date('d-m-Y', $timestamp);
}

 function formatDateTime($datetime) {
    if($datetime) {
        $data =  \Carbon\Carbon::parse($datetime)->format('d M Y - h:i A');
    }else {
        $data = '---';
    }
    return $data;
}


function number_format2($value) {
    $value = (float) $value; // Ensure it's treated as a float
    return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
}
function numberToWord($number) {
    $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
    return ucwords($f->format($number));
}

function adsBanner($type) {
    $ads = AdvertiseBanner::where('banner_type', $type)->get();
    return $ads;
}

function siteInfo() {
    $data = GeneralSettings:: find(1);
    return $data;
}

function socialMedia() {
    $data = SocialMedia::find(1);
    return $data;
}

function category() {
    $data = Category::with('subcategories.products')->take(3)->get();
    return $data;
}

function getBodyClass()
{
    if (Request::is('/')) {
        return 'cms-index-index';
    } elseif (Request::is('product/*')) {
        return 'catalog-product-view catalog-view_op1';
    } elseif (Request::is('login/')) {
        return 'catalog-product-view catalog-view_op1 page-login';
    } else {
        return 'catalog-category-view catalog-view_op1';
    }
}

function maskEmail($email) {
    $emailParts = explode('@', $email);
    $namePart = $emailParts[0];
    $domainPart = $emailParts[1];

    // Show first two characters of the name part and mask the rest
    $maskedName = substr($namePart, 0, 2) . str_repeat('*', max(strlen($namePart) - 2, 0));

    return $maskedName . '@' . $domainPart;
}

function userHasAddress($id) {
    $address = Address::where('user_id', $id)->first();
    return $address;
}


function adminFormatedInvoiceId($invoiceId) {
    $invoice = Invoice::where('id', $invoiceId)->first();
    $year = $invoice->created_at ? $invoice->created_at->format('Y') : date('Y');
    return "INV-" . $year . "-" . str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
}
function customerFormatedInvoiceId($invoiceId) {
    $invoice = Invoice::where('id', $invoiceId)->first();
    return "#" . str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
}

function availableStock($productId) {
    return VariantOption::where('product_id', $productId)->sum('stock');
}


//  this two sell_price are related if product has variant
//  then variant sell price else product sell price 
function productVariantSellPrice($variantId)
{
    return VariantOption::where('id', $variantId)
        ->value('sell_price');
}

function productSellPrice($productId)
{
    return Product::where('id', $productId)
        ->value('sell_price');
}

function updateShipmentTrackingStatus($order, $newStatus)
{
    $statusTimestamps = [
        Constant::ORDER_STATUS['confirmed'] => 'confirmed_at',
        Constant::ORDER_STATUS['processing'] => 'processed_at',
        Constant::ORDER_STATUS['shipped'] => 'shipped_at',
        Constant::ORDER_STATUS['delivered'] => 'delivered_at',
        Constant::ORDER_STATUS['cancelled'] => 'cancelled_at',
        Constant::ORDER_STATUS['refunded'] => 'refund_at',
        Constant::ORDER_STATUS['returned'] => 'returned_at',
    ];

    // Step 1: Update order
    $order->status = $newStatus;
    $order->save();

    // Step 2: Get existing tracking (if any)
    $tracking = ShipmentTracking::where('invoice_id', $order->id)->first();

    if ($tracking) {
        foreach ($statusTimestamps as $statusValue => $timestampField) {
            if ($statusValue <= $newStatus && is_null($tracking->$timestampField)) {
                $tracking->$timestampField = now();
            }
        }
        $tracking->status = $newStatus;
        $tracking->save();
    } else {
        // Create new tracking
        $createData = [
            'invoice_id' => $order->id,
            'tracking_number' => $order->tracking_code,
            'status' => $newStatus,
        ];

        foreach ($statusTimestamps as $statusValue => $timestampField) {
            if ($statusValue <= $newStatus) {
                $createData[$timestampField] = now();
            }
        }

        ShipmentTracking::create($createData);
    }
}

function getReviewByUser($userId, $productId, $invoiceId)
{
    return ProductReview::where('user_id', $userId)
        ->where('product_id', $productId)
        ->where('invoice_id', $invoiceId)
        ->first();
}

function limitText($text, $limit = 25)
    {
        if (!is_string($text) || trim($text) === '') {
            return '----';
        }

        $text = strip_tags($text);
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        if (count($words) > $limit) {
            $short = array_slice($words, 0, $limit);
            return implode(' ', $short) . '...';
        }

        return $text;
    }

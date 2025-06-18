<?php
namespace App\Helpers;

class Constant {

    const USER_STATUS = [
        'active' => 0,
        'deactive' => 1,
        'blocked' => 2,
    ];
    const STATUS = [
        'active' => 0,
        'deactive' => 1
    ];
    const AGENT_STATUS = [
        'free' => 1,
        'engaged' => 2
    ];

    const USER_TYPE = [
        'admin' => 0,
        'author' => 1,
        'customer' => 2,
    ];

    const BANNER_TYPE = [
        'home_banner' => 0,
        'ads_banner1' => 1,
        'ads_banner2' => 2,
        'ads_banner3' => 3,
        'ads_banner4' => 4,
        'ads_banner5' => 5,
    ];

    const PRODUCT_TYPE = [
        'featured' => 1,
        'big_sale' => 2,
        'Latest_deals' => 3,
    ];

    const TRANSACTION_TYPE = [
        'credit' => '1',
        'debit' => '2',
        'refund' => '3',
    ];

    const PRODUCT_RETURNS = [
        'This item is non-returnable' => '1',
        '3 days easy return' => '2',
        '7 days easy return' => '3',
        '14 days easy return' => '4',
        '30 days easy return' => '5',
    ];

    const PRODUCT_WARRANTY = [
        'No warranty available' => '1',
        '6 month brand warranty' => '2',
        '1 year brand warranty' => '3',
        '2 year brand warranty' => '4',
        '3 year brand warranty' => '5',
        '10 year brand warranty' => '6',
        'Extended warranty' => '7',
        'Lifetime warranty' => '8',
    ];

    const CURRENCY = [
        'name' => 'BDT',
        'symbol' => '৳',
    ];

    const ORDER_STATUS = [
        'pending' => 1,
        'confirmed' => 2,
        'processing' => 3,
        'shipped' => 4,
        'delivered' => 5,
        'cancelled' => 6,
        'refunded' => 7,
        'returned' => 8,
    ];

    const PAYMENT_STATUS = [
        'paid' => 1,
        'unpaid' => 2,
    ];
    const PAYMENT_METHOD = [
        'cod' => 1,
    ];

    const GENDER = [
        'male' => 0,
        'female' => 1,
        'others' => 2,
    ];
    const MIN_AGE = [
        'old' => 18,
    ];
    const UNIT = [
        'pcs' => 0,
        'gm' => 1,
        'kg' => 2,
        'liter' => 3,
        'pack' => 4,
        'box' => 5,
        'case' => 6,
        'bottle' => 7,
        'can' => 8,
        'gallon' => 9,
    ];
    const VARIANT_TYPES = [
        'size' => '1',
        'storage_capacity' => '2',
        'instalment' => '3',
        'case_size' => '4',
    ];
    const DELIVERY_PLACE = [
        'home' => 1,
        'office' => 2,
    ];
    const ADDRESS_TYPE = [
        'billing' => 1,
        'shipping' => 2,
        'both' => 3,
    ];
    const DEFAULT_ADDRESS = [
        'billing' => 1,
        'shipping' => 2,
        'both' => 3,
    ];
    const ESTIMATED_TIME = [
        'within 24 hours' => 1,
        '1 to 3 days' => 2,
        '3 to 7 days' => 3,
    ];
    const TRACKING_AVAILABLE = [
        'yes' => 1,
        'no' => 2,
    ];

}

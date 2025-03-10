<!-- Product Name and Code -->
<h5 class="mb-1">Product: <span class="fw-bold text-capitalize">{{ $data->name ?? '' }}</span></h5>
<p class="text-muted">Code: <span>{{ ($data->item_code) ? '#' . $data->item_code : '' }}</span></p>

<!-- Image Gallery Row -->
<div class="row mb-3">
    <!-- Thumbnail Image -->
    <div class="col-md-3">
        <img src="{{ asset($data->thumbnail ?? '') }}" class="img-fluid rounded" alt="Thumbnail" style="width: 100px;">
    </div>
    <!-- Featured Images -->
    <div class="col-md-9">
        <div class="d-flex flex-wrap gap-1">
            @foreach($data->featuredImages as $image)
                <img src="{{ asset($image->image ?? '') }}" class="img-fluid rounded" alt="Featured" style="width: 75px;">
            @endforeach
        </div>
    </div>
</div>

<!-- Pricing Details -->
<div class="row mb-2">
    <div class="col-3">
        <p class="text-muted small mb-0">Buy Price:</p>
        <p class="fw-bold small">{{ ($data->buy_price) ? country()->symbol . ' ' . $data->buy_price : '' }}</p>
    </div>
    <div class="col-3">
        <p class="text-muted small mb-0">MRP Price:</p>
        <p class="fw-bold small">{{ ($data->mrp_price) ? country()->symbol . ' ' . $data->mrp_price : '' }}</p>
    </div>
    <div class="col-3">
        <p class="text-muted small mb-0">Discount:</p>
        <p class="fw-bold small">{{ ($data->discount_price) ? country()->symbol . ' ' . $data->discount_price : '' }}</p>
    </div>
    <div class="col-3">
        <p class="text-muted small mb-0">Sell Price:</p>
        <p class="fw-bold small">{{ ($data->sell_price) ? country()->symbol . ' ' . $data->sell_price : '' }}</p>
    </div>
</div>

@php
    $units = App\Helpers\Constant::UNIT;
    $status = App\Helpers\Constant::STATUS;
    $dataUnit = $data->unit;
    $unit = array_search($dataUnit, $units) ? : 'unit';

    $colors = App\Helpers\Constant::COLORS;
    $sizes = App\Helpers\Constant::SIZES;
    $dataColor = json_decode($data->color ?? '[]');
    $dataSize = json_decode($data->size ?? '[]');

    $dataCondition = $data->condition ?? '';
    $conditions = App\Helpers\Constant::CONDITIONS;
    $conditionText = '';

    // Map condition value to its string representation
    switch ($dataCondition) {
        case $conditions['new']:
            $conditionText = 'New';
            break;
        case $conditions['used']:
            $conditionText = 'Used';
            break;
        case $conditions['refurbished']:
            $conditionText = 'Refurbished';
            break;
        default:
            $conditionText = 'N/A';
            break;
    }

@endphp

<!-- Stock, Status, Colors, Sizes -->
<div class="row mb-2">
    <div class="col-4">
        <p class="text-muted small mb-0">Stock Quantity:</p>
        <p class="fw-bold small {{ $data->stock_quantity ? '' : 'text-danger' }}">
            {{ $data->stock_quantity ? 'Available: ' . $data->stock_quantity . ' ' . $unit : 'Out of Stock' }}
        </p>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Keywords:</p>
        <p class="fw-bold small text-capitalize">
            {{ $data->keywords ?? '' }}
        </p>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Brand:</p>
        <p class="fw-bold small text-capitalize">
            {{ $data->brand->name ?? '' }}
        </p>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <p class="text-muted small mb-0">Sizes:</p>
        <div class="d-flex flex-wrap gap-1">
            @forelse($sizes as $key => $sizeName)
                @if(is_array($dataSize) && in_array($sizeName, $dataSize))
                    <span class="text-capitalize">{{ $key . ',' }}</span>
                @endif

            @empty
                <span>---</span>
            @endforelse

        </div>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Colors:</p>
        <div class="d-flex flex-wrap gap-1">
            @forelse($colors as $colorName)
                @if(is_array($colorName) && in_array($colorName, $dataColor))
                    <span style="background-color: {{ $colors[$colorName] ?? 'transparent' }}; color: #ffffff; padding: 0 5px; border-radius: 5px;">{{ $colorName }}</span>
                @endif

            @empty
                <span>---</span>
            @endforelse
        </div>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Model:</p>
        <p class="fw-bold small text-capitalize">
            {{ $data->model_no ?? '---' }}
        </p>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <p class="text-muted small mb-0">Product Type:</p>
        <p class="fw-bold small text-capitalize">
            @if ($data->product_type === App\Helpers\Constant::PRODUCT_TYPE['featured'])
                {{ 'Featured Product' }}
            @elseif ($data->product_type === App\Helpers\Constant::PRODUCT_TYPE['big_sale'])
                {{ 'Big Sale' }}
            @elseif ($data->product_type === App\Helpers\Constant::PRODUCT_TYPE['Latest_deals'])
                {{ 'Latest Deals' }}
            @endif
        </p>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Deals End In:</p>
        <p class="fw-bold small text-capitalize">
            {{ dateFormat($data->deals_time) ?? '---' }}
        </p>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Condition:</p>
        <p class="fw-bold small text-capitalize">
            {{ $conditionText ?? '---' }}
        </p>
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <p class="text-muted small mb-0">Category:</p>
        <p class="fw-bold small text-capitalize">{{ $data->category->name ?? '' }}</p>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Subcategory:</p>
        <p class="fw-bold small text-capitalize">{{ $data->subcategory->name ?? '' }}</p>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Childcategory:</p>
        <p class="fw-bold small text-capitalize">{{ $data->childcategory->name ?? '' }}</p>
    </div>
</div>

<!-- Descriptions -->
<div class="row mb-2">
    <div class="col-8">
        <p class="text-muted small mb-0">Short Description:</p>
        <p class="small">{{ $data->short_description ?? 'No short description available.' }}</p>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Status:</p>
        <p class="fw-bold small text-capitalize {{ ($data->status === $status['active']) ? 'text-success' : 'text-danger' }}">
            {{ ($data->status === $status['active']) ? 'active' : 'deactive' }}
        </p>
    </div>
    <div class="col-12">
        <p class="text-muted small mb-0">Product Details:</p>
        <p class="small">
            @php
                if($data['description']) {
                    echo $data['description'];
                }else {
                    echo 'No description available.';
                }
            @endphp
        </p>
    </div>
</div>

<!-- Buy Now Button -->
<div class="d-grid">
    <button type="button" class="btn btn-primary btn-sm">Buy Now</button>
</div>

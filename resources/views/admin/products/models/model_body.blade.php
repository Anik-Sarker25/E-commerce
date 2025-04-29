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

@php
    $totalStock = 0;
    $subTotalStock = 0;
@endphp

<div class="row mb-2">
    <div class="col-12">
        <p class="text-muted small mb-2">Available Variant Options</p>

        @foreach ($data->variants as $variant)
            @php
                $rowCount = $variant->options->count() ?: 1;
                $variantStock = 0;
            @endphp

            <table class="table table-sm table-bordered align-middle mb-4">
                <thead>
                    <tr>
                        <th class="text-center">Color</th>
                        <th class="text-center">Variant Type</th>
                        <th class="text-center">Value</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Buy Price</th>
                        <th class="text-center">MRP</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Sell Price</th>
                    </tr>
                </thead>
                @php
                    $variant_type = array_flip(App\Helpers\Constant::VARIANT_TYPES);
                @endphp
                <tbody>
                    @forelse ($variant->options as $index => $option)
                        @php
                            $subTotalStock += (int)($option->stock ?? 0);
                            $variantStock = ($variantStock ?? 0) + (int) ($option->stock ?? 0);
                        @endphp
                        <tr>
                            @if ($index === 0)
                                <td rowspan="{{ $rowCount }}" class="text-center">
                                    @if ($variant->color_image)
                                        <img src="{{ asset($variant->color_image) }}" width="20" height="20" class="rounded mb-1">
                                    @else
                                        <span style="display:inline-block; width: 20px; height: 20px; background-color: {{ $variant->color_code }};" class="rounded-circle mb-1"></span>
                                    @endif
                                    <div><strong class="text-capitalize">{{ $variant->color_name ?? 'No Color Name' }}</strong></div>
                                </td>
                            @endif

                            
                            <td class="text-center">
                                {{ ucwords(str_replace('_', ' ', $variant_type[$option->variant_type] ?? '-')) }}
                            </td>
                            <td class="text-center">{{ $option->variant_value ?? '-' }}</td>
                            <td class="text-center">{{ $option->stock ?? 0 }}</td>
                            <td class="text-center">{{ number_format($option->buy_price, 0) }}</td>
                            <td class="text-center">{{ number_format($option->mrp_price, 0) }}</td>
                            <td class="text-center">{{ number_format($option->discount_price, 0) }}%</td>
                            <td class="text-center">{{ number_format($option->sell_price, 0) . country()->symbol }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No options available for this variant.</td>
                        </tr>
                    @endforelse

                    @if ($variant->options->count() > 0)
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Stock:</td>
                            <td class="text-center">{{ $variantStock }}</td>
                            <td colspan="4"></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endforeach

    </div>
</div>

@if ($stocksWithoutVariant)
    @php
        $subTotalStock += (int)($stocksWithoutVariant->stock ?? 0);
    @endphp
    <div class="row mb-2">
        <div class="col-12">
            
            <table class="table table-sm table-bordered align-middle mb-4">
                <thead>
                    <tr>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Variant Type</th>
                        <th class="text-center">Value</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Buy Price</th>
                        <th class="text-center">MRP</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Sell Price</th>
                    </tr>
                </thead>
                @php
                    $variant_type = array_flip(App\Helpers\Constant::VARIANT_TYPES);
                @endphp
                <tbody>
                    <tr>
                        <td rowspan="{{ $rowCount }}" class="text-center">
                            product stock
                        </td>
                        
                        <td class="text-center">
                            {{ ucwords(str_replace('_', ' ', $variant_type[$stocksWithoutVariant->variant_type] ?? '-')) }}
                        </td>
                        <td class="text-center">{{ $stocksWithoutVariant->variant_value ?? '-' }}</td>
                        <td class="text-center">{{ $stocksWithoutVariant->stock ?? 0 }}</td>
                        <td class="text-center">{{ number_format($stocksWithoutVariant->buy_price, 0) }}</td>
                        <td class="text-center">{{ number_format($stocksWithoutVariant->mrp_price, 0) }}</td>
                        <td class="text-center">{{ number_format($stocksWithoutVariant->discount_price, 0) }}%</td>
                        <td class="text-center">{{ number_format($stocksWithoutVariant->sell_price, 0) . country()->symbol }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif

@php
    $units = App\Helpers\Constant::UNIT;
    $status = App\Helpers\Constant::STATUS;
    $dataUnit = $data->unit;
    $unit = array_search($dataUnit, $units) ? : 'unit';
@endphp

<!-- Stock, Status, Colors, Sizes -->
<div class="row mb-2">
    <div class="col-4">
        <p class="text-muted small mb-0">Stock Quantity:</p>
        <p class="fw-bold small {{ $stocksWithoutVariant->stock ? '' : 'text-danger' }}">
            {{ $subTotalStock ? 'Total Stock: ' . $subTotalStock . ' ' . $unit : 'Out of Stock' }}
        </p>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Brand:</p>
        <p class="fw-bold small text-capitalize">
            {{ $data->brand->name ?? 'N/A' }}
        </p>
    </div>
    <div class="col-4">
        <p class="text-muted small mb-0">Keywords:</p>
        <p class="fw-bold small text-capitalize">
            {{ $data->keywords ?? 'N/A' }}
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
            @else
                N/A
            @endif
        </p>
    </div>
    @if ($data->deals_time)
        <div class="col-4">
            <p class="text-muted small mb-0">Deals End In:</p>
            <p class="fw-bold small text-capitalize">
                {{ dateFormat($data->deals_time) ?? '---' }}
            </p>
        </div>
    @endif
    <div class="col-4">
        <p class="text-muted small mb-0">Status:</p>
        <p class="fw-bold small text-capitalize {{ ($data->status === $status['active']) ? 'text-success' : 'text-danger' }}">
            {{ ($data->status === $status['active']) ? 'active' : 'deactive' }}
        </p>
    </div>
</div>

<!-- Descriptions -->
<div class="row mb-2">
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

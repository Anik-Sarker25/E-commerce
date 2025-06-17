@php
    use App\Helpers\Constant;
@endphp
<h5>Agent Name: {{ $data->name }}</h5>



@php
    $statusCounts = $data->shipmentTrackings->groupBy('status')->map->count();
    $statusLabels = array_flip(Constant::ORDER_STATUS);

    $statusIcons = [
        'pending' => '🕓',
        'confirmed' => '✅',
        'processing' => '🔄',
        'shipped' => '🚚',
        'delivered' => '📦',
        'cancelled' => '❌',
        'refunded' => '💵',
        'returned' => '↩️',
    ];

    $statusSummary = collect($statusCounts)->map(function ($count, $statusCode) use ($statusLabels, $statusIcons) {
        $label = $statusLabels[$statusCode] ?? 'unknown';
        $icon = $statusIcons[$label] ?? '';
        return "$icon $count " . ucfirst($label);
    })->implode(' | ');
@endphp
<br>
<h6>Assigned Shipments: {!! $statusSummary !!}</h6>


<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice ID</th>
            <th>Status</th>
            <th>Assigned At</th>
            <th>Will Expaired</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data->shipmentTrackings as $index => $shipment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $shipment->invoice_id }}</td>
                <td>{{ array_flip(Constant::ORDER_STATUS)[$shipment->status] }}</td>
                <td>{{ $shipment->updated_at->format('d M Y h:i A') }}</td>
                <td>{{ $shipment->final_delivery_date ?? '---' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No shipments assigned yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

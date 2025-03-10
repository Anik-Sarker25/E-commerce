<p class="delivery-text address">
    @if ($address)
        @if ($address->delivery_place == App\Helpers\Constant::DELIVERY_PLACE['home'])
            <span class="label label-success">Home</span>
        @elseif ($address->delivery_place == App\Helpers\Constant::DELIVERY_PLACE['office'])
            <span class="label label-primary">Office</span>
        @endif

        {{ $address->address ? $address->address . ', ' : '' }}
        {{ optional($address->upazilas)->name ? optional($address->upazilas)->name . ', ' : '' }}
        {{ optional($address->district)->name ? optional($address->district)->name . ', ' : '' }}
        {{ optional($address->division)->name ?? 'Set Your Address' }}
    @else
        <div class="text-center">Set Your Address</div>
    @endif
</p>

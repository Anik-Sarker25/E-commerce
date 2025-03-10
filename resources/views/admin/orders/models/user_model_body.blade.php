
<table class="table table-borderless">
    <tbody>
        <tr>
            <td style="width: 25%;"><strong>Name:</strong></td>
            <td>{{ $user->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td>{{ $user->email ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Phone:</strong></td>
            <td>{{ $address->phone ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Address:</strong></td>
            <td>{{ $address->address ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Birthday:</strong></td>
            <td>{{ dateFormat($user->birthday) ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Gender:</strong></td>
            <td>
                @if($user->gender == App\Helpers\Constant::GENDER['male'])
                    Male
                @elseif($user->gender == App\Helpers\Constant::GENDER['female'])
                    Female
                @else
                    Other
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Country:</strong></td>
            <td>{{ optional($user->country)->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Division:</strong></td>
            <td>{{ optional($user->division)->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>District:</strong></td>
            <td>{{ optional($user->district)->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Upazila:</strong></td>
            <td>{{ optional($user->upazilas)->name ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td><strong>Status:</strong></td>
            <td>
                @php
                    $status = App\Helpers\Constant::USER_STATUS;
                    $role = App\Helpers\Constant::USER_TYPE;
                @endphp
                <span class="badge {{ $user->status == $status['active'] ? 'bg-success' : ($user->status == $status['deactive'] ? 'bg-warning' : 'bg-danger') }}">
                    @if($user->status == $status['active'])
                        Active
                    @elseif($user->status == $status['deactive'])
                        Inactive
                    @elseif($user->status == $status['blocked'])
                        Blocked
                    @else
                        Other
                    @endif
                </span>

            </td>
        </tr>
        <tr>
            <td><strong>Role:</strong></td>
            <td>

                <span class="badge bg-secondary">
                    @if($user->role == $role['admin'])
                        Admin
                    @elseif($user->role == $role['author'])
                        Author
                    @elseif($user->role == $role['customer'])
                        Customer
                    @else
                        Other
                    @endif
                </span>
            </td>
        </tr>
        <tr>
            @php
                use Carbon\Carbon;
            @endphp

            <td><strong>Email Verified At:</strong></td>
            <td>{{ $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->format('d M Y') . ' - (' . \Carbon\Carbon::parse($user->email_verified_at)->diffForHumans(). ')' : 'Not Verified' }}</td>
        </tr>
        <tr>
            <td><strong>User Created At:</strong></td>
            <td>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y') . ' - (' . \Carbon\Carbon::parse($user->created_at)->diffForHumans(). ')' : 'N/A' }}</td>
        </tr>
    </tbody>
</table>

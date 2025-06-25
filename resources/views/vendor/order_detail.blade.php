@extends('layouts.app')

@section('content')
    @include('components.navvendor')

    <div class="flex min-h-screen bg-gray-100">
        @include('components.sidevendor')

        <main class="flex-1 p-6">
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-2xl font-semibold text-red-600 mb-6">Order Detail</h2>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Order Information</h3>
                    <p><strong>Order ID:</strong> {{ $orderDetails['id'] }}</p>
                    <p><strong>Customer:</strong> {{ $orderDetails['user_name'] }} ({{ $orderDetails['user_email'] }})</p>
                    <p><strong>Order Date:</strong> {{ $orderDetails['order_date'] }}</p>
                    <p><strong>Shipping Address:</strong> {{ $orderDetails['shipping_address'] }}</p>
                    <p><strong>Phone:</strong> {{ $orderDetails['phone'] }}</p>
                    <p><strong>Status:</strong> {{ $orderDetails['status'] }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Order Items</h3>
                    <table class="w-full text-sm table-auto">
                        <thead>
                            <tr class="bg-gray-50 text-left text-gray-700">
                                <th class="p-3 font-medium">Product</th>
                                <th class="p-3 font-medium">Variant</th>
                                <th class="p-3 font-medium">Quantity</th>
                                <th class="p-3 font-medium">Price</th>
                                <th class="p-3 font-medium">Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($orderDetails['items'] as $item)
                                <tr class="border-t border-gray-200">
                                    <td class="p-3">{{ $item['name'] }}</td>
                                    <td class="p-3">{{ $item['variant'] }}</td>
                                    <td class="p-3">{{ $item['quantity'] }}</td>
                                    <td class="p-3">Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td class="p-3">Rp. {{ number_format($item['total'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-right mt-4">
                        <p class="text-lg font-bold">Total: Rp.
                            {{ number_format($orderDetails['total_price'], 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Update Status</h3>
                    <form id="update-status-form" action="{{ route('vendor.order_update_status', $orderDetails['id']) }}"
                        method="POST">
                        @csrf
                        <select name="status" class="border border-gray-300 rounded px-4 py-2">
                            <option value="Awaiting Shipment"
                                {{ $orderDetails['status'] === 'Awaiting Shipment' ? 'selected' : '' }}>Awaiting Shipment
                            </option>
                            <option value="Shipped" {{ $orderDetails['status'] === 'Shipped' ? 'selected' : '' }}>Shipped
                            </option>
                            <option value="Completed" {{ $orderDetails['status'] === 'Completed' ? 'selected' : '' }}>
                                Completed</option>
                            <option value="Cancelled" {{ $orderDetails['status'] === 'Cancelled' ? 'selected' : '' }}>
                                Cancelled</option>
                        </select>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-2">Update Status</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('update-status-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const submitButton = form.querySelector('button[type="submit"]');
        
        // Disable button during request
        submitButton.disabled = true;
        submitButton.textContent = 'Updating...';
        
        fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('#update-status-form input[name="_token"]').value
                },
                body: JSON.stringify({
                    status: form.querySelector('select[name="status"]').value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Redirect to orders page
                        window.location.href = "{{ route('vendor.orders') }}";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                    // Re-enable button on error
                    submitButton.disabled = false;
                    submitButton.textContent = 'Update Status';
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update status: ' + error.message
                });
                // Re-enable button on error
                submitButton.disabled = false;
                submitButton.textContent = 'Update Status';
            });
    });
</script>
@endsection

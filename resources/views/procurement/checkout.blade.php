@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('components.procnav')

    <div class="min-h-screen bg-[#F6F3F2] py-10">
        <div class="w-full max-w-[1000px] mx-auto px-4">
            <h5 class="text-lg font-bold mb-6">
                <a href="{{ route('procurement.dashboardproc') }}" class="text-black hover:underline">Dashboard</a>
                <span class="text-gray-500"> > </span>
                <a href="{{ route('procurement.cart') }}" class="text-black hover:underline">Cart</a>
                <span class="text-red-500 font-bold"> > Check Out</span>
            </h5>

            <!-- Error Message -->
            <div id="checkout-error" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                <p class="font-bold">Error</p>
                <p id="checkout-error-message">An error occurred. Please try again or log in.</p>
            </div>

            <!-- Loading Spinner -->
            <div id="checkout-loading" class="hidden flex justify-center items-center py-10">
                <svg class="animate-spin h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/2 bg-white p-6 rounded-xl shadow text-sm">
                    <h2 class="text-lg font-bold mb-4">CONTACT INFORMATION <span
                            class="text-xs font-normal float-right">*Required</span></h2>
                    <form id="checkout-form" action="{{ route('procurement.checkout.submit') }}" method="POST">
                        @csrf
                        @foreach ($cartItems as $item)
                            <input type="hidden" name="selected_ids[]" value="{{ $item['id'] }}">
                        @endforeach
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Email *</label>
                            <input type="email" value="{{ auth()->user()->email ?? '' }}" disabled
                                class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2" />
                        </div>

                        <h2 class="text-lg font-bold mb-4 mt-6">SHIPPING ADDRESS</h2>

                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Full Name *</label>
                            <input type="text" name="full_name" class="w-full border border-gray-300 rounded px-3 py-2"
                                required />
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Phone Number *</label>
                            <input type="text" name="phone_number"
                                class="w-full border border-gray-300 rounded px-3 py-2" required />
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Country *</label>
                            <input type="text" name="country" class="w-full border border-gray-300 rounded px-3 py-2"
                                required />
                        </div>

                        <div class="mb-4 grid grid-cols-3 gap-3">
                            <div>
                                <label class="block mb-1 font-semibold">City *</label>
                                <input type="text" name="city" class="w-full border border-gray-300 rounded px-3 py-2"
                                    required />
                            </div>
                            <div>
                                <label class="block mb-1 font-semibold">State/Province</label>
                                <input type="text" name="state"
                                    class="w-full border border-gray-300 rounded px-3 py-2" />
                            </div>
                            <div>
                                <label class="block mb-1 font-semibold">Postal code *</label>
                                <input type="text" name="postal_code"
                                    class="w-full border border-gray-300 rounded px-3 py-2" required />
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Street Address *</label>
                            <textarea rows="2" name="street_address" class="w-full border border-gray-300 rounded px-3 py-2" required></textarea>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold">Save &
                                Proceed</button>
                            <button type="reset"
                                class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded font-semibold">Reset</button>
                        </div>
                    </form>
                </div>

                <div class="w-full md:w-1/2 bg-white p-6 rounded-xl shadow border border-red-400 text-sm">
                    <h2 class="text-lg font-bold mb-4 text-center">CHECK OUT</h2>

                    <div class="space-y-3 mb-4">
                        @if (empty($cartItems))
                            <p class="text-red-500">No items selected for checkout.</p>
                        @else
                            @foreach ($cartItems as $item)
                                <div class="flex items-center justify-between border-b pb-2">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/50' }}"
                                            class="w-12 h-12 object-cover rounded border border-red-400">
                                        <div>
                                            <div class="font-semibold text-sm">{{ $item['name'] }}</div>
                                            <div class="text-gray-500 text-xs">Variasi: {{ $item['variant'] }}</div>
                                        </div>
                                    </div>
                                    <div class="font-semibold text-right text-sm">
                                        Rp. {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="text-sm text-gray-600 mb-1 flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp. {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-base font-bold text-black flex justify-between border-t pt-2 mb-4">
                        <span>Total</span>
                        <span>Rp. {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <button type="button" id="print-ebilling-btn" onclick="printEBilling()"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 rounded text-sm hidden"
                            disabled>
                            Print E-Billing
                        </button>
                        <button type="button" onclick="cancelCheckout()"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-1.5 rounded text-sm">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let checkoutCompleted = false;
        let lastOrderId = null;

        function printEBilling() {
            if (!checkoutCompleted || !lastOrderId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Checkout Required',
                    text: 'Please complete the checkout process before generating e-billing.',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            document.getElementById('checkout-loading').classList.remove('hidden');
            fetch('/checkout/e-billing', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: lastOrderId
                    })
                })
                .then(response => {
                    document.getElementById('checkout-loading').classList.add('hidden');
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Print E-Billing Response:', text);
                            throw new Error(`Server returned status ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.open(data.pdf_path, '_blank');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message || 'E-Billing generated successfully!',
                            timer: 1500,
                            confirmButtonColor: '#dc2626'
                        });
                        updateNotificationBadge();
                        loadNotifications();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to generate E-Billing',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    document.getElementById('checkout-loading').classList.add('hidden');
                    console.error('Print E-Billing Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message.includes('Unauthenticated') ?
                            'Your session has expired. Please log in again.' : error.message.includes('500') ?
                            'Server error occurred. Please try again later or contact support.' :
                            `Failed to generate E-Billing: ${error.message}`,
                        confirmButtonColor: '#dc2626'
                    });
                    if (error.message.includes('Unauthenticated')) {
                        setTimeout(() => {
                            window.location.href = '{{ route('login.form') }}';
                        }, 2000);
                    }
                });
        }

        function cancelCheckout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to cancel the checkout process?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('procurement.cart') }}';
                }
            });
        }

        function updateNotificationBadge() {
            fetch('/notifications/count', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    if (badge) {
                        badge.textContent = data.count;
                        badge.style.display = data.count > 0 ? 'inline-block' : 'none';
                    }
                })
                .catch(error => {
                    console.error('Update Notification Badge Error:', error);
                });
        }

        function loadNotifications() {
            fetch('/notifications', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const notificationList = document.getElementById('notificationList');
                    if (!notificationList) return;
                    notificationList.innerHTML = '';
                    if (data.notifications.length === 0) {
                        notificationList.innerHTML =
                            '<div style="padding: 10px; text-align: center;">No notifications</div>';
                    } else {
                        data.notifications.forEach(notification => {
                            const div = document.createElement('div');
                            div.style.padding = '10px 15px';
                            div.style.borderBottom = '1px solid #ddd';
                            div.style.backgroundColor = notification.read ? '#fff' : '#f9f9f9';
                            div.innerHTML = `
                                <div style="font-weight: ${notification.read ? 'normal' : 'bold'}">${notification.message}</div>
                                <div style="font-size: 12px; color: #666;">${notification.created_at}</div>
                                ${notification.type === 'e-billing' ? `<a href="/storage/${notification.data.pdf_path}" target="_blank" style="color: #3085d6; text-decoration: none;">View E-Billing</a>` : ''}
                            `;
                            div.addEventListener('click', () => markAsRead(notification.id));
                            notificationList.appendChild(div);
                        });
                    }
                    const badge = document.getElementById('notificationBadge');
                    if (badge) {
                        badge.textContent = data.unread_count;
                        badge.style.display = data.unread_count > 0 ? 'inline-block' : 'none';
                    }
                })
                .catch(error => {
                    console.error('Load Notifications Error:', error);
                });
        }

        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateNotificationBadge();
                        loadNotifications();
                    }
                })
                .catch(error => {
                    console.error('Mark As Read Error:', error);
                });
        }

        function updateCartBadge() {
            fetch('/cart/count', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('cartBadge');
                    if (badge) {
                        badge.textContent = data.count;
                        badge.style.display = data.count > 0 ? 'inline-block' : 'none';
                    }
                })
                .catch(error => {
                    console.error('Update Cart Badge Error:', error);
                });
        }

        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const errorDiv = document.getElementById('checkout-error');
            const errorMessage = document.getElementById('checkout-error-message');
            const loadingDiv = document.getElementById('checkout-loading');
            const submitButton = this.querySelector('button[type="submit"]');
            const selectedIds = @json(array_column($cartItems, 'id'));

            if (selectedIds.length === 0) {
                errorDiv.classList.remove('hidden');
                errorMessage.textContent = 'No items selected for checkout.';
                Swal.fire({
                    icon: 'error',
                    title: 'No Items',
                    text: 'No items selected for checkout.',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            errorDiv.classList.add('hidden');
            loadingDiv.classList.remove('hidden');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('#checkout-form input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        full_name: this.querySelector('input[name="full_name"]').value,
                        phone_number: this.querySelector('input[name="phone_number"]').value,
                        country: this.querySelector('input[name="country"]').value,
                        city: this.querySelector('input[name="city"]').value,
                        state: this.querySelector('input[name="state"]').value,
                        postal_code: this.querySelector('input[name="postal_code"]').value,
                        street_address: this.querySelector('textarea[name="street_address"]').value,
                        selected_ids: selectedIds
                    })
                })
                .then(response => {
                    loadingDiv.classList.add('hidden');
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Checkout Response:', text);
                            throw new Error(`Server returned status ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        checkoutCompleted = true;
                        lastOrderId = data.order_id;
                        document.getElementById('print-ebilling-btn').disabled = false;
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message || 'Checkout completed successfully!',
                            timer: 1500,
                            showConfirmButton: false,
                            confirmButtonColor: '#dc2626'
                        }).then(() => {
                            updateNotificationBadge();
                            loadNotifications();
                            updateCartBadge();
                            window.location.href = data.redirect ||
                                '{{ route('procurement.dashboardproc') }}';
                        });
                    } else {
                        errorDiv.classList.remove('hidden');
                        errorMessage.textContent = data.message || 'Failed to complete checkout';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to complete checkout',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    loadingDiv.classList.add('hidden');
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    errorDiv.classList.remove('hidden');
                    errorMessage.textContent = error.message.includes('Unauthenticated') ?
                        'Your session has expired. Please log in again.' :
                        error.message.includes('500') ?
                        'Server error occurred. Please try again later or contact support.' :
                        `Failed to complete checkout: ${error.message}`;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message.includes('Unauthenticated') ?
                            'Your session has expired. Please log in again.' : error.message.includes(
                                '500') ?
                            'Server error occurred. Please try again later or contact support.' :
                            `Failed to complete checkout: ${error.message}`,
                        confirmButtonColor: '#dc2626'
                    });
                    if (error.message.includes('Unauthenticated')) {
                        setTimeout(() => {
                            window.location.href = '{{ route('login.form') }}';
                        }, 2000);
                    }
                    console.error('Checkout Form Error:', error);
                });
        });

        // Initialize UI state
        document.addEventListener('DOMContentLoaded', function() {
            updateNotificationBadge();
            updateCartBadge();
            loadNotifications();
        });
    </script>
@endsection

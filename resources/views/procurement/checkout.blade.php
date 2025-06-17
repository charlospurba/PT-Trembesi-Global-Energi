@extends('layouts.app')

@section('content')
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('components.navbar')

    <div class="min-h-screen bg-[#F6F3F2] py-10">
        <div class="w-full max-w-[1000px] mx-auto px-4">
            {{-- Breadcrumb --}}
            <h5 class="text-lg font-bold mb-6">
                <a href="{{ route('procurement.dashboardproc') }}" class="text-black hover:underline">Dashboard</a>
                <span class="text-gray-500"> > </span>
                <a href="{{ route('procurement.cart') }}" class="text-black hover:underline">Cart</a>
                <span class="text-red-500 font-bold"> > Check Out</span>
            </h5>

            <div class="flex flex-col md:flex-row gap-6">
                {{-- LEFT: Form --}}
                <div class="w-full md:w-1/2 bg-white p-6 rounded-xl shadow text-sm">
                    <h2 class="text-lg font-bold mb-4">CONTACT INFORMATION <span
                            class="text-xs font-normal float-right">*Required</span></h2>
                    <form id="checkout-form" action="{{ route('procurement.checkout.submit') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Email *</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled
                                class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2" />
                        </div>

                        <h2 class="text-lg font-bold mb-4 mt-6">SHIPPING ADDRESS</h2>

                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Full Name *</label>
                            <input type="text" name="full_name" class="w-full border border-gray-300 rounded px-3 py-2"
                                required />
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Country *</label>
                            <input type="text" name="country" class="w-full border border-gray-300 rounded px-3 py-2"
                                required />
                        </div>

                        <div class="mb-4 grid grid-cols-3 gap-3">
                            <div>
                                <label class="block mb-1 font-semibold">State/Province</label>
                                <input type="text" name="state"
                                    class="w-full border border-gray-300 rounded px-3 py-2" />
                            </div>
                            <div class="col-span-2">
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

                {{-- RIGHT: Ringkasan Produk --}}
                <div class="w-full md:w-1/2 bg-white p-6 rounded-xl shadow border border-red-400 text-sm">
                    <h2 class="text-lg font-bold mb-4 text-center">CHECK OUT</h2>

                    <div class="space-y-3 mb-4">
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
                        <button type="button" onclick="printEBilling()"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 rounded text-sm">Print
                            E-Billing</button>
                        <button type="button" onclick="cancelCheckout()"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-1.5 rounded text-sm">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printEBilling() {
            Swal.fire({
                icon: 'info',
                title: 'Print E-Billing',
                text: 'This feature is under development.'
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

        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('#checkout-form input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        full_name: this.querySelector('input[name="full_name"]').value,
                        country: this.querySelector('input[name="country"]').value,
                        state: this.querySelector('input[name="state"]').value,
                        postal_code: this.querySelector('input[name="postal_code"]').value,
                        street_address: this.querySelector('textarea[name="street_address"]').value
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message || 'Checkout completed successfully!',
                            timer: 1500
                        }).then(() => {
                            window.location.href = '{{ route('procurement.dashboardproc') }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to complete checkout'
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to complete checkout: ' + error.message
                    });
                });
        });
    </script>
@endsection

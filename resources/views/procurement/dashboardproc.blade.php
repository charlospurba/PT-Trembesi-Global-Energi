@extends('layouts.app')

@section('content')
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Categories Section -->
        <div class="section-title text-2xl font-bold text-gray-800 mb-6">Category</div>
        <div class="categories-grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach([
                ['href' => '/material', 'icon' => 'fas fa-cube', 'label' => 'Material'],
                ['href' => '/equipment', 'icon' => 'fas fa-tools', 'label' => 'Equipment'],
                ['href' => '/electrical', 'icon' => 'fas fa-bolt', 'label' => 'Electrical Tools'],
                ['href' => '/consumables', 'icon' => 'fas fa-shopping-bag', 'label' => 'Consumables'],
                ['href' => '/personal', 'icon' => 'fas fa-hard-hat', 'label' => 'Personal Protective Equipment']
            ] as $category)
                <a href="{{ $category['href'] }}" class="category-card bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center hover:shadow-lg">
                    <i class="{{ $category['icon'] }} text-3xl text-red-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 text-center">{{ $category['label'] }}</span>
                </a>
            @endforeach
        </div>

        <!-- Recommendations Section -->
        <div class="recommendations-section mt-12">
            <div class="recommendations-title text-2xl font-bold text-gray-800 mb-6">Recommendations</div>

            @foreach([
                ['title' => 'Material Collection', 'route' => 'procurement.material', 'products' => $randomMaterials],
                ['title' => 'Equipment Collection', 'route' => 'procurement.equipment', 'products' => $randomEquipments],
                ['title' => 'Electrical Collection', 'route' => 'procurement.electrical', 'products' => $randomElectricals],
                ['title' => 'Consumables Collection', 'route' => 'procurement.consumables', 'products' => $randomConsumables],
                ['title' => 'Personal Protective Equipment Collection', 'route' => 'procurement.personal', 'products' => $randomPPEs]
            ] as $collection)
                <div class="collection mb-12">
                    <div class="collection-header flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $collection['title'] }}</h3>
                        <a href="{{ route($collection['route']) }}" class="text-sm text-red-600 hover:underline">See all ></a>
                    </div>
                    <div class="products-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse($collection['products'] as $product)
                            <a href="{{ route('product.detail', $product->id) }}" class="block">
                                <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-[280px] w-full hover:shadow-xl">
                                    <!-- Image -->
                                    <div class="bg-red-600 p-3 flex justify-center items-center h-32">
                                        <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0
                                            ? asset('storage/' . $product->image_paths[0] . '?' . time())
                                            : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-contain rounded-md" />
                                    </div>
                                    <!-- Content -->
                                    <div class="px-4 py-3 space-y-1.5 text-xs">
                                        <!-- Supplier -->
                                        <span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-800 text-[11px] rounded-full">
                                            {{ $product->supplier }}
                                        </span>
                                        <!-- Product Name -->
                                        <h3 class="text-sm font-semibold text-gray-800">{{ $product->name }}</h3>
                                        <!-- Price -->
                                        <p class="text-black font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                        <!-- Address -->
                                        <div class="flex items-start text-[11px] text-gray-600">
                                            <svg class="w-4 h-4 text-red-500 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                            </svg>
                                            {{ $product->address ?? '-' }}
                                        </div>
                                        <!-- Stock -->
                                        <div class="text-[11px] text-red-600 font-medium">
                                            Stock: {{ $product->quantity }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-center text-gray-500 text-sm col-span-full">There are no {{ $collection['title'] }} products available.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Simple Footer -->
<footer class="bg-red-600 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            
            <!-- Company Info -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <i class="fas fa-tools text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white">ProcurePro</h3>
                </div>
                <p class="text-red-100 text-sm leading-relaxed">
                    Your trusted partner for industrial procurement solutions, delivering high-quality materials, equipment, and supplies for construction and industrial needs.
                </p>
                
                <!-- Social Media Links -->
                <div class="flex space-x-4">
                    <a href="#" class="p-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors duration-200">
                        <i class="fab fa-facebook-f text-red-200 hover:text-white"></i>
                    </a>
                    <a href="#" class="p-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors duration-200">
                        <i class="fab fa-twitter text-red-200 hover:text-white"></i>
                    </a>
                    <a href="#" class="p-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors duration-200">
                        <i class="fab fa-linkedin-in text-red-200 hover:text-white"></i>
                    </a>
                    <a href="#" class="p-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors duration-200">
                        <i class="fab fa-instagram text-red-200 hover:text-white"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white">Quick Links</h4>
                <div class="space-y-2">
                    <a href="/material" class="text-red-100 hover:text-white flex items-center space-x-2 transition-colors duration-200">
                        <i class="fas fa-cube text-xs"></i>
                        <span>Materials</span>
                    </a>
                    <a href="/equipment" class="text-red-100 hover:text-white flex items-center space-x-2 transition-colors duration-200">
                        <i class="fas fa-tools text-xs"></i>
                        <span>Equipment</span>
                    </a>
                    <a href="/electrical" class="text-red-100 hover:text-white flex items-center space-x-2 transition-colors duration-200">
                        <i class="fas fa-bolt text-xs"></i>
                        <span>Electrical Tools</span>
                    </a>
                    <a href="/consumables" class="text-red-100 hover:text-white flex items-center space-x-2 transition-colors duration-200">
                        <i class="fas fa-shopping-bag text-xs"></i>
                        <span>Consumables</span>
                    </a>
                    <a href="/personal" class="text-red-100 hover:text-white flex items-center space-x-2 transition-colors duration-200">
                        <i class="fas fa-hard-hat text-xs"></i>
                        <span>PPE</span>
                    </a>
                </div>
            </div>

            <!-- Services -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white">Services</h4>
                <div class="space-y-2 text-sm">
                    <a href="#" class="text-red-100 hover:text-white block transition-colors duration-200">Bulk Orders</a>
                    <a href="#" class="text-red-100 hover:text-white block transition-colors duration-200">Custom Quotes</a>
                    <a href="#" class="text-red-100 hover:text-white block transition-colors duration-200">Delivery Service</a>
                    <a href="#" class="text-red-100 hover:text-white block transition-colors duration-200">Technical Support</a>
                    <a href="#" class="text-red-100 hover:text-white block transition-colors duration-200">Warranty Service</a>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white">Contact Us</h4>
                <div class="space-y-3 text-sm">
                    
                    <!-- Address -->
                    <div class="flex items-start space-x-3">
                        <div class="p-1 bg-white/20 rounded flex-shrink-0 mt-0.5">
                            <i class="fas fa-map-marker-alt text-white text-xs"></i>
                        </div>
                        <div class="text-red-100">
                            <div>Jl. Industri Raya No. 123</div>
                            <div>Jakarta Selatan, DKI Jakarta</div>
                            <div>Indonesia 12345</div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-center space-x-3">
                        <div class="p-1 bg-white/20 rounded">
                            <i class="fas fa-phone text-white text-xs"></i>
                        </div>
                        <a href="tel:+622112345678" class="text-red-100 hover:text-white transition-colors duration-200">
                            +62 21 1234 5678
                        </a>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center space-x-3">
                        <div class="p-1 bg-white/20 rounded">
                            <i class="fas fa-envelope text-white text-xs"></i>
                        </div>
                        <a href="mailto:info@procurepro.com" class="text-red-100 hover:text-white transition-colors duration-200">
                            info@procurepro.com
                        </a>
                    </div>

                    <!-- Business Hours -->
                    <div class="flex items-center space-x-3">
                        <div class="p-1 bg-white/20 rounded">
                            <i class="fas fa-clock text-white text-xs"></i>
                        </div>
                        <span class="text-red-100">Mon - Fri: 8:00 AM - 6:00 PM</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-red-500 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-red-100 text-sm">
                    © {{ date('Y') }} ProcurePro. All rights reserved.
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-red-100 hover:text-white transition-colors duration-200">Privacy Policy</a>
                    <a href="#" class="text-red-100 hover:text-white transition-colors duration-200">Terms of Service</a>
                    <a href="#" class="text-red-100 hover:text-white transition-colors duration-200">Support</a>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection
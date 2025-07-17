
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
                <a href="{{ $category['href'] }}" class="category-card bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-lg hover:scale-105 hover:bg-red-50">
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
                        <a href="{{ route($collection['route']) }}" class="text-sm text-red-600 hover:underline transition-colors duration-300">See all ></a>
                    </div>
                    <div class="products-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse($collection['products'] as $product)
                            <a href="{{ route('product.detail', $product->id) }}" class="block">
                                <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-[280px] w-full transition-all duration-300 hover:shadow-xl hover:scale-105">
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

            <!-- Purchase Deadlines Chart -->
            <div class="mt-12">
                <div class="section-title text-2xl font-bold text-gray-800 mb-6">Purchase Deadlines</div>
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200/50 bg-gradient-to-br from-white to-red-50/50">
                    <canvas id="deadlineChart" class="max-w-full h-80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Animated Footer -->
    <footer class="relative bg-gradient-to-br from-red-600 via-red-700 to-red-800 text-white overflow-hidden mt-16">
        <!-- Animated Wave Background -->
        <div class="absolute inset-0 opacity-20">
            <svg class="absolute bottom-0 w-full h-32 animate-wave-smooth" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,60 C300,120 600,0 900,60 C1050,90 1150,30 1200,60 L1200,120 L0,120 Z" fill="currentColor"></path>
            </svg>
            <svg class="absolute bottom-0 w-full h-28 opacity-60 animate-wave-smooth" viewBox="0 0 1200 120" preserveAspectRatio="none" style="animation-delay: -2s;">
                <path d="M0,80 C400,20 800,100 1200,40 L1200,120 L0,120 Z" fill="currentColor"></path>
            </svg>
        </div>

        <!-- Floating Particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-2 h-2 bg-white rounded-full opacity-30 animate-float" style="top: 15%; left: 10%; animation-delay: 0s;"></div>
            <div class="absolute w-1.5 h-1.5 bg-white rounded-full opacity-40 animate-float" style="top: 35%; left: 25%; animation-delay: 1s;"></div>
            <div class="absolute w-2.5 h-2.5 bg-white rounded-full opacity-25 animate-float" style="top: 55%; left: 65%; animation-delay: 2s;"></div>
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-35 animate-float" style="top: 75%; left: 85%; animation-delay: 3s;"></div>
            <div class="absolute w-2 h-2 bg-white rounded-full opacity-30 animate-float" style="top: 25%; left: 75%; animation-delay: 4s;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Company Info -->
                <div class="space-y-4 transform transition-all duration-300 hover:scale-105">
                    <div class="flex items-center space-x-3 group">
                        <div class="p-2 bg-gradient-to-r from-white/20 to-white/10 rounded-lg group-hover:from-white/30 group-hover:to-white/20 transition-all duration-300 shadow-glow">
                            <i class="fas fa-tools text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-white to-red-100 bg-clip-text text-transparent gradient-text">
                            ProcurePro
                        </h3>
                    </div>
                    <p class="text-red-100 text-sm leading-relaxed font-light">
                        Your trusted partner for industrial procurement solutions, delivering high-quality materials, equipment, and supplies for construction and industrial needs.
                    </p>
                    <div class="flex space-x-4">
                        @foreach(['facebook-f', 'twitter', 'linkedin-in', 'instagram'] as $social)
                            <a href="#" class="group p-2 bg-gradient-to-r from-white/10 to-white/5 rounded-lg hover:from-white/20 hover:to-white/15 transition-all duration-300 shadow-glow">
                                <i class="fab fa-{{ $social }} text-red-200 group-hover:text-white transition-colors"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4 transform transition-all duration-300 hover:scale-105">
                    <h4 class="text-lg font-semibold text-white">Quick Links</h4>
                    <div class="grid grid-cols-1 gap-2 text-sm">
                        @foreach([
                            ['href' => '/material', 'icon' => 'fas fa-cube', 'label' => 'Materials'],
                            ['href' => '/equipment', 'icon' => 'fas fa-tools', 'label' => 'Equipment'],
                            ['href' => '/electrical', 'icon' => 'fas fa-bolt', 'label' => 'Electrical Tools'],
                            ['href' => '/consumables', 'icon' => 'fas fa-shopping-bag', 'label' => 'Consumables'],
                            ['href' => '/personal', 'icon' => 'fas fa-hard-hat', 'label' => 'PPE']
                        ] as $link)
                            <a href="{{ $link['href'] }}" class="text-red-100 hover:text-white hover:translate-x-2 transition-all duration-300 flex items-center space-x-2 group">
                                <i class="{{ $link['icon'] }} text-xs group-hover:text-white"></i>
                                <span>{{ $link['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Services -->
                <div class="space-y-4 transform transition-all duration-300 hover:scale-105">
                    <h4 class="text-lg font-semibold text-white">Services</h4>
                    <div class="grid grid-cols-1 gap-2 text-sm">
                        @foreach([
                            ['icon' => 'fas fa-boxes', 'label' => 'Bulk Orders'],
                            ['icon' => 'fas fa-cog', 'label' => 'Custom Solutions'],
                            ['icon' => 'fas fa-headset', 'label' => 'Technical Support'],
                            ['icon' => 'fas fa-truck', 'label' => 'Delivery Services'],
                            ['icon' => 'fas fa-shield-alt', 'label' => 'Warranty']
                        ] as $service)
                            <a href="#" class="text-red-100 hover:text-white hover:translate-x-2 transition-all duration-300 flex items-center space-x-2 group">
                                <i class="{{ $service['icon'] }} text-xs group-hover:text-white"></i>
                                <span>{{ $service['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="space-y-4 transform transition-all duration-300 hover:scale-105">
                    <h4 class="text-lg font-semibold text-white">Contact Us</h4>
                    <div class="space-y-3 text-sm">
                        @foreach([
                            ['icon' => 'fas fa-map-marker-alt', 'text' => "Jl. Industri Raya No. 123<br>Jakarta Selatan, DKI Jakarta<br>Indonesia 12345"],
                            ['icon' => 'fas fa-phone', 'text' => '+62 21 1234 5678'],
                            ['icon' => 'fas fa-envelope', 'text' => 'info@procurepro.com'],
                            ['icon' => 'fas fa-clock', 'text' => 'Mon - Fri: 8:00 AM - 6:00 PM']
                        ] as $contact)
                            <div class="flex items-start space-x-3 group">
                                <div class="p-1 bg-gradient-to-r from-white/20 to-white/10 rounded group-hover:from-white/30 group-hover:to-white/20 transition-all duration-300 shadow-glow">
                                    <i class="{{ $contact['icon'] }} text-white text-xs"></i>
                                </div>
                                <span class="text-red-100 group-hover:text-white transition-colors">{!! $contact['text'] !!}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- JavaScript for Dynamic Styles, Year, and Chart -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Inject CSS for animations
            const styleElement = document.createElement('style');
            const cssStyles = `
                /* Smooth wave animation */
                @keyframes wave-smooth {
                    0%, 100% { transform: translateX(0); }
                    50% { transform: translateX(-20px); }
                }

                /* Float animation for particles */
                @keyframes float {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-15px); }
                }

                /* Subtle glow effect */
                .shadow-glow {
                    transition: box-shadow 0.3s ease;
                }
                .shadow-glow:hover {
                    box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
                }

                /* Gradient text animation */
                @keyframes gradient-shift {
                    0% { background-position: 0% 50%; }
                    50% { background-position: 100% 50%; }
                    100% { background-position: 0% 50%; }
                }

                .gradient-text {
                    background: linear-gradient(-45deg, #ffffff, #fecaca, #ffffff, #fca5a5);
                    background-size: 400% 400%;
                    animation: gradient-shift 4s ease infinite;
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }

                .animate-wave-smooth {
                    animation: wave-smooth 5s ease-in-out infinite;
                }

                .animate-float {
                    animation: float 4s ease-in-out infinite;
                }
            `;
            styleElement.textContent = cssStyles;
            document.head.appendChild(styleElement);

            // Set dynamic copyright year
            document.querySelector('.copyright-year').innerHTML = `© ${new Date().getFullYear()} ProcurePro. All rights reserved.`;

            // Initialize Chart.js with Stacked Bar Chart
            const ctx = document.getElementById('deadlineChart').getContext('2d');

            // Create gradients for each category
            const gradients = {
                urgent: [
                    ctx.createLinearGradient(0, 0, 0, 400),
                    ctx.createLinearGradient(0, 0, 0, 400),
                    ctx.createLinearGradient(0, 0, 0, 400),
                    ctx.createLinearGradient(0, 0, 0, 400),
                    ctx.createLinearGradient(0, 0, 0, 400)
                ],
                upcoming: [
                    ctx.createLinearGradient(0, 0, 0, 400),
                    ctx.createLinearGradient(0, 0, 0, 400),
                    ctx.createLinearGradient(0, 0, 0, 400),
                    ctx.createLinearGradient(0, 0, 0, 400),
                    ctx.createLinearGradient(0, 0, 0, 400)
                ]
            };

            // Define gradient colors
            gradients.urgent[0].addColorStop(0, '#dc2626'); // red-600
            gradients.urgent[0].addColorStop(1, '#b91c1c'); // red-700
            gradients.urgent[1].addColorStop(0, '#f87171'); // red-400
            gradients.urgent[1].addColorStop(1, '#dc2626'); // red-600
            gradients.urgent[2].addColorStop(0, '#ef4444'); // red-500
            gradients.urgent[2].addColorStop(1, '#b91c1c'); // red-700
            gradients.urgent[3].addColorStop(0, '#f87171'); // red-400
            gradients.urgent[3].addColorStop(1, '#dc2626'); // red-600
            gradients.urgent[4].addColorStop(0, '#ef4444'); // red-500
            gradients.urgent[4].addColorStop(1, '#b91c1c'); // red-700

            gradients.upcoming[0].addColorStop(0, '#991b1b'); // red-800
            gradients.upcoming[0].addColorStop(1, '#7f1d1d'); // red-900
            gradients.upcoming[1].addColorStop(0, '#b91c1c'); // red-700
            gradients.upcoming[1].addColorStop(1, '#991b1b'); // red-800
            gradients.upcoming[2].addColorStop(0, '#991b1b'); // red-800
            gradients.upcoming[2].addColorStop(1, '#7f1d1d'); // red-900
            gradients.upcoming[3].addColorStop(0, '#b91c1c'); // red-700
            gradients.upcoming[3].addColorStop(1, '#991b1b'); // red-800
            gradients.upcoming[4].addColorStop(0, '#991b1b'); // red-800
            gradients.upcoming[4].addColorStop(1, '#7f1d1d'); // red-900

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Material', 'Equipment', 'Electrical', 'Consumables', 'PPE'],
                    datasets: [
                        {
                            label: 'Urgent (Within 1 Week)',
                            data: [
                                {{ $deadlines['urgent']['material'] ?? 0 }},
                                {{ $deadlines['urgent']['equipment'] ?? 0 }},
                                {{ $deadlines['urgent']['electrical'] ?? 0 }},
                                {{ $deadlines['urgent']['consumables'] ?? 0 }},
                                {{ $deadlines['urgent']['ppe'] ?? 0 }}
                            ],
                            backgroundColor: gradients.urgent,
                            borderColor: '#ffffff',
                            borderWidth: 1,
                            borderRadius: 8,
                            barThickness: 20
                        },
                        {
                            label: 'Upcoming (2–4 Weeks)',
                            data: [
                                {{ $deadlines['upcoming']['material'] ?? 0 }},
                                {{ $deadlines['upcoming']['equipment'] ?? 0 }},
                                {{ $deadlines['upcoming']['electrical'] ?? 0 }},
                                {{ $deadlines['upcoming']['consumables'] ?? 0 }},
                                {{ $deadlines['upcoming']['ppe'] ?? 0 }}
                            ],
                            backgroundColor: gradients.upcoming,
                            borderColor: '#ffffff',
                            borderWidth: 1,
                            borderRadius: 8,
                            barThickness: 20
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart'
                    },
                    scales: {
                        x: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'Product Categories',
                                font: { size: 14, weight: 'bold' },
                                color: '#1f2937' // gray-800
                            },
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#1f2937', // gray-800
                                font: { size: 12 }
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Items',
                                font: { size: 14, weight: 'bold' },
                                color: '#1f2937' // gray-800
                            },
                            grid: {
                                color: '#e5e7eb' // gray-200
                            },
                            ticks: {
                                color: '#1f2937', // gray-800
                                font: { size: 12 }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#1f2937', // gray-800
                                font: { size: 14, weight: 'bold' },
                                padding: 20
                            }
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: '#1f2937', // gray-800
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#dc2626', // red-600
                            borderWidth: 1,
                            callbacks: {
                                label: (context) => {
                                    const label = context.dataset.label || '';
                                    const value = context.raw;
                                    const category = context.label;
                                    return `${label}: ${value} items in ${category}`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection

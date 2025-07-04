@extends('layouts.app')

@section('content')
    @include('components.navvendor')

    <div style="padding: 20px;">
        <div style="font-size: 14px; color: #6B7280; margin-bottom: 10px;">
            Dashboard &gt; <span style="color: red;">Profile</span>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div style="background: #10B981; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- General Information --}}
            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">General Information</h2>

                {{-- Profile Picture --}}
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 120px; height: 120px; border-radius: 50%; background: #f3f4f6; margin: 0 auto; overflow: hidden;">
                        @if ($user && $user->profile_picture)
                            <img id="profilePreview"
                                src="{{ asset('storage/profile_picture/' . $user->profile_picture) . '?t=' . time() }}"
                                alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img id="profilePreview" src="https://via.placeholder.com/120?text=No+Image"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>

                    <input id="profilePictureInput" type="file" name="profile_picture" accept="image/*"
                        style="margin-top: 15px; background-color: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer;">
                    <div style="font-size: 12px; color: gray; margin-top: 5px;">Image formats .jpg .jpeg .png and max size 300KB</div>
                </div>

                {{-- Basic Information --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label for="name" style="display: block; font-weight: bold; margin-bottom: 6px;">Nama</label>
                        <input id="name" name="name" type="text" value="{{ $user->name }}"
                            style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                        @error('name')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="store_name" style="display: block; font-weight: bold; margin-bottom: 6px;">Store Name</label>
                        <input id="store_name" name="store_name" type="text" value="{{ $user->store_name }}"
                            style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                        @error('store_name')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="phone_number" style="display: block; font-weight: bold; margin-bottom: 6px;">Phone Number</label>
                    <input id="phone_number" name="phone_number" type="text" value="{{ $user->phone_number }}"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                    @error('phone_number')
                        <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Account Information (Read Only) --}}
            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Account Information</h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label for="email" style="display: block; font-weight: bold; margin-bottom: 6px;">Email</label>
                        <input id="email" type="email" value="{{ $user->email }}" readonly
                            style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; background-color: #f9fafb;">
                        <div style="font-size: 12px; color: gray; margin-top: 5px;">Email tidak dapat diubah</div>
                    </div>

                    <div>
                        <label for="username" style="display: block; font-weight: bold; margin-bottom: 6px;">Username</label>
                        <input id="username" type="text" value="{{ $user->username }}" readonly
                            style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; background-color: #f9fafb;">
                        <div style="font-size: 12px; color: gray; margin-top: 5px;">Username tidak dapat diubah</div>
                    </div>
                </div>
            </div>

            {{-- Business Information (Read Only) --}}
            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Business Information</h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label for="npwp_readonly" style="display: block; font-weight: bold; margin-bottom: 6px;">NPWP</label>
                        <input id="npwp_readonly" type="text" value="{{ $user->npwp }}" readonly
                            style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; background-color: #f9fafb;">
                        <div style="font-size: 12px; color: gray; margin-top: 5px;">NPWP tidak dapat diubah</div>
                    </div>

                    <div>
                        <label for="nib_readonly" style="display: block; font-weight: bold; margin-bottom: 6px;">NIB</label>
                        <input id="nib_readonly" type="text" value="{{ $user->nib }}" readonly
                            style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; background-color: #f9fafb;">
                        <div style="font-size: 12px; color: gray; margin-top: 5px;">NIB tidak dapat diubah</div>
                    </div>
                </div>
            </div>

            {{-- Business Documents (View Only) --}}
            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Business Documents</h2>
                <div style="background: #fef3c7; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; color: #92400e;">
                    <strong>Note:</strong> Dokumen bisnis tidak dapat diubah setelah registrasi. Jika perlu perubahan, silakan hubungi administrator.
                </div>

                @php
                    $documents = [
                        'comp_profile' => 'Company Profile',
                        'izin_perusahaan' => 'Izin Perusahaan',
                        'sppkp' => 'Surat Pengukuhan PKP',
                        'struktur_organisasi' => 'Struktur Organisasi',
                        'daftar_pengalaman' => 'Daftar Pengalaman Perusahaan'
                    ];
                @endphp

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    @foreach($documents as $field => $label)
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: bold; margin-bottom: 6px;">{{ $label }}</label>
                            
                            @if($user->$field)
                                <div style="display: flex; align-items: center; background: #f3f4f6; padding: 10px; border-radius: 6px; font-size: 14px;">
                                    <span style="color: #10B981; margin-right: 8px;">📄</span>
                                    <span style="flex: 1;">{{ basename($user->$field) }}</span>
                                    <a href="{{ asset('storage/' . $user->$field) }}" target="_blank" 
                                       style="color: #ef4444; text-decoration: none; font-weight: bold; margin-left: 10px;">
                                        View
                                    </a>
                                </div>
                            @else
                                <div style="background: #f9fafb; padding: 10px; border-radius: 6px; color: #6B7280; font-size: 14px;">
                                    Belum ada dokumen
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Save Button --}}
            <div style="text-align: right; margin-bottom: 30px;">
                <button type="submit"
                    style="padding: 12px 24px; background-color: #ef4444; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('profilePictureInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('profilePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
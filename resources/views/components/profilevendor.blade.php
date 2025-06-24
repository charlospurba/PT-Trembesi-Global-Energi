@extends('layouts.app')

@section('content')
    @include('components.navvendor')

    <div style="padding: 20px;">
        <div style="font-size: 14px; color: #6B7280; margin-bottom: 10px;">
            Dashboard &gt; <span style="color: red;">Profile</span>
        </div>

        <div
            style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">General Information</h2>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Gambar Profil --}}
                <div style="text-align: center; margin-bottom: 20px;">
                    <div
                        style="width: 120px; height: 120px; border-radius: 50%; background: #f3f4f6; margin: 0 auto; overflow: hidden;">
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
                    <div style="font-size: 12px; color: gray; margin-top: 5px;">Image formats .jpg .jpeg .png and max size
                        300KB</div>
                </div>

                {{-- Nama --}}
                <div style="margin-top: 30px;">
                    <label for="name">Nama</label>
                    <input id="name" name="name" type="text" value="{{ $user->name }}"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>

                {{-- Tombol --}}
                <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="submit"
                        style="padding: 10px 20px; background-color: #ef4444; color: white; border: none; border-radius: 8px; font-weight: bold;">Save</button>
                </div>
            </form>
        </div>

        <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
            <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Email and Phone Number</h2>

            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-weight: bold; margin-bottom: 6px;">Email</label>
                <input id="email" type="email" value="{{ $user->email }}" readonly
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; background-color: #f9fafb;">
            </div>

            <div>
                <label for="phone" style="display: block; font-weight: bold; margin-bottom: 6px;">Phone</label>
                <input id="phone" type="text" value="{{ $user->phone_number }}" readonly
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; background-color: #f9fafb;">
            </div>
        </div>
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
@extends('layouts.app')

@section('content')
    @include('components.navbar')

    <div style="padding: 20px;">
        <div style="font-size: 14px; color: #6B7280; margin-bottom: 10px;">
            Dashboard &gt; <span style="color: red;">Profile</span>
        </div>

        <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">General Information</h2>

            <div style="text-align: center; margin-bottom: 20px;">
                <div style="width: 120px; height: 120px; border-radius: 50%; background: #f3f4f6; margin: 0 auto;">
                    <i class="fas fa-user" style="font-size: 60px; color: #ef4444; line-height: 120px;"></i>
                </div>
                <button style="margin-top: 15px; background-color: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer;">
                    Choose Photo
                </button>
                <div style="font-size: 12px; color: gray; margin-top: 5px;">Image formats .jpg .jpeg .png and maximum file size 300KB</div>
            </div>

            <div style="margin-top: 30px;">
                <label for="name" style="display: block; font-weight: bold; margin-bottom: 6px;">Nama</label>
                <input id="name" type="text" value="Gracesia Romauli"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                <button style="padding: 10px 20px; background-color: #e5e7eb; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Cancel</button>
                <button style="padding: 10px 20px; background-color: #ef4444; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Save</button>
            </div>
        </div>

        <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
            <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Email and Phone Number</h2>

            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-weight: bold; margin-bottom: 6px;">Email</label>
                <input id="email" type="email" value="gracesiaromauli10@gmail.com"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
            </div>

            <div>
                <label for="phone" style="display: block; font-weight: bold; margin-bottom: 6px;">Phone</label>
                <input id="phone" type="text" value="+6283157905262"
                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
            </div>
        </div>
    </div>
@endsection

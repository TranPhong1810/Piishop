@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center p-5">
                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="mb-3">Xác minh email của bạn</h3>
                    <p class="text-muted mb-4">
                        Vui lòng kiểm tra hộp thư đến của bạn để xác minh email.  
                        Nếu bạn chưa nhận được email xác minh, hãy bấm vào nút bên dưới để gửi lại.
                    </p>

                    <form method="POST" action="{{ route('auth.resend-verification') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary px-4">
                            Gửi lại email xác minh
                        </button>
                    </form>

                    <div class="mt-4">
                        <a href="{{ route('auth.login') }}" class="text-decoration-none">
                            ← Quay lại trang đăng nhập
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

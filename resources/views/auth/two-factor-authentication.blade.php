@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('二要素認証') }}</div>

                <div class="card-body">
                    @if (session('status') === "two-factor-authentication-disabled")
                        <div class="alert alert-success" role="alert">
                            二要素認証が無効になりました。
                        </div>
                    @endif

                    @if (session('status') === "two-factor-authentication-enabled")
                        <div class="alert alert-success" role="alert">
                            二要素認証が有効になりました。
                        </div>
                    @endif

                    <form method="POST" action="/user/two-factor-authentication">
                        @csrf

                        @if (auth()->user()->two_factor_secret)
                            @method('DELETE')

                            <div class="pb-5">
                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            </div>

                            <div>
                                <h3>リカバリーコード:</h3>
                                <ul>
                                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                                        <li>{{ $code }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <button class="btn btn-danger">無効にする</button>
                        @else
                            <button class="btn btn-primary">有効にする</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

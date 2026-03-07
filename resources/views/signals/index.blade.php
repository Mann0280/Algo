@extends('layouts.app')

@section('title', 'AI Trading Signals | AlgoTrade')

@push('styles')
<link href="https://unpkg.com/tabulator-tables@6.3.1/dist/css/tabulator_simple.min.css" rel="stylesheet">
<link href="{{ asset('css/tabulator-dark.css') }}" rel="stylesheet">
<style>
    .signals-hero {
        text-align: center;
        padding: 48px 0 24px;
    }
    .signals-hero h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(18px, 4vw, 28px);
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -0.02em;
        color: #fff;
    }
    .signals-hero h1 span { color: #a855f7; }
    .signals-hero p {
        color: #4b5563;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        margin-top: 8px;
    }
    .live-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 12px rgba(16,185,129,0.6);
        animation: dotPulse 2s ease-in-out infinite;
        display: inline-block;
    }
    @keyframes dotPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.8); }
    }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 pb-20">

    {{-- Hero --}}
    <div class="signals-hero">
        <h1>See What Our AI Is <span>Detecting Right Now</span></h1>
        <p>Real-Time Neural Trading Intelligence</p>
    </div>

    {{-- Conditional Views --}}
    @if($userState === 'guest')
        @include('signals.locked-login')
    @elseif($userState === 'free')
        @include('signals.locked-upgrade')
    @else
        @include('signals.live-table')
        @include('signals.video-feed')
    @endif

</div>
@endsection

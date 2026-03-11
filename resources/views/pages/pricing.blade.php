@extends('layouts.app')

@section('title', 'Pricing Tiers | Emperor Stock Predictor')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center p-6 py-20 relative z-10 font-bold uppercase italic tracking-tighter">
    <div class="text-center mb-16">
        <h1 class="orbitron text-3xl sm:text-5xl font-black mb-4 tracking-tighter text-white">CHOOSE YOUR <span class="text-purple-500">LEVEL</span></h1>
        <p class="text-gray-400 max-w-lg mx-auto font-normal not-italic normal-case tracking-normal">Scale your trading with AI-powered insights and professional grade toolsets.</p>
    </div>

    <!-- Premium Plans Section -->
    @include('components.premium-plans', ['mode' => 'dynamic', 'hideDetailsLink' => true])

</main>

@endsection

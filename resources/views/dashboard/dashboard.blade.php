@extends('dashboard.base')

@section('content')
    <div class="container">
        <h1>Dashboard 2</h1>
        <p>Welcome to your dashboard!</p>
        <p>Your email: {{ auth()->user()->email }}</p>
    </div>
{{-- 
    <div class="masonry" id="masonry">
    <!-- Repeat this block -->
    <div class="card"><img src="https://picsum.photos/500/700?random=1" alt=""></div>
    <div class="card"><img src="https://picsum.photos/600/400?random=2" alt=""></div>
    <div class="card"><img src="https://picsum.photos/400/600?random=3" alt=""></div>
    <div class="card"><img src="https://picsum.photos/700/500?random=4" alt=""></div>
    <div class="card"><img src="https://picsum.photos/450/650?random=5" alt=""></div>
    <div class="card"><img src="https://picsum.photos/650/450?random=6" alt=""></div>
    <div class="card"><img src="https://picsum.photos/500/500?random=7" alt=""></div>
    <div class="card"><img src="https://picsum.photos/550/750?random=8" alt=""></div>
    <div class="card"><img src="https://picsum.photos/750/550?random=9" alt=""></div>
    <div class="card"><img src="https://picsum.photos/480/720?random=10" alt=""></div>
    <div class="card"><img src="https://picsum.photos/720/480?random=11" alt=""></div>
    <div class="card"><img src="https://picsum.photos/530/630?random=12" alt=""></div>
    <div class="card"><img src="https://picsum.photos/630/530?random=13" alt=""></div>
    <div class="card"><img src="https://picsum.photos/460/690?random=14" alt=""></div>
    <div class="card"><img src="https://picsum.photos/690/460?random=15" alt=""></div>
    <div class="card"><img src="https://picsum.photos/520/780?random=16" alt=""></div>
    <div class="card"><img src="https://picsum.photos/780/520?random=17" alt=""></div>
    <div class="card"><img src="https://picsum.photos/560/640?random=18" alt=""></div>
    <div class="card"><img src="https://picsum.photos/640/560?random=19" alt=""></div>
    <div class="card"><img src="https://picsum.photos/600/800?random=20" alt=""></div>
</div>
    <style>
* {
  box-sizing: border-box;
}

.masonry {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
}

.card {
  flex: 0 0 auto;      /* natural width, no shrinking */
  overflow: hidden;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  transition: transform 0.2s ease;
  height: 220px;       /* fixed row height */
  display: flex;
  align-items: center;
  justify-content: center;
}

.card:hover {
  transform: translateY(-4px);
}

.card img {
  height: 100%;
  width: auto;
  object-fit: cover;
}

        </style> --}}

@endsection
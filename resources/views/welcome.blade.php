@extends('layouts.app')

@section('content')

<style>
main { margin-top: 0; }
.container-fluid { padding-left: 0; padding-right: 0; }
.carousel { box-shadow: 0 4px 8px -2px gray; }
.carousel-control { background-color: black; padding: 20px; border-radius: 50%; }
.carousel-control .carousel-control-prev-icon,
.carousel-control .carousel-control-next-icon { position: relative; top: 2px; }
#carouselHomePage img { width: 100% !important; }
</style>

<div class="container">

    <div class="row mb-5">
        <h2 class="mb-2 mt-2">Νέα Προϊόντα</h2>

        <div class="row">
            @foreach ($mostRecent as $product)
                @include('templates.product-card', [
                                'product'  => $product, 
                                'colClass' => 'col-sm-12 col-md-6 col-lg-3 mb-4'
                            ])
            @endforeach
        </div>
    </div>

    <div class="row">
        <h2 class="mb-2 mt-2">Τα πιο δημοφιλή προϊόντα</h2>
        <!-- Swiper -->
        <div class="row">
            @foreach ($mostViewed as $line)
            <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                <div class="card product-card h-100">
                    <div class="card-image">
                        <a href="{{url('product/'.$line->product->slug)}}">
                            <img 
                            class="card-img-top" 
                            src="{{asset('thumbnail/'.$line->product->image)}}" 
                            alt="{{$line->product->name}}">
                        </a>
                    </div>
                    <div class="card-body">
                        <a href="{{url('product/'.$line->product->slug)}}">
                            <h5 class="card-title text-center">{{$line->product->name}}</h5>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
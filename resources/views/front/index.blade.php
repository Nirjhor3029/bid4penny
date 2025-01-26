@extends('layouts.front')
@section('content')
    <!-- Steps Section -->
    <div class="steps-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="step-number bg-warning">01</div>
                        <div>
                            <h5 class="mb-0">Join Now</h5>
                            <small>Join now and get 5 free bids</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="step-number bg-success">02</div>
                        <div>
                            <h5 class="mb-0">Purchase Bids</h5>
                            <small>Purchase the bids package that suits you most</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="step-number bg-info">03</div>
                        <div>
                            <h5 class="mb-0">Start Bidding</h5>
                            <small>Choose the item you would like to bid on</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="step-number bg-danger">04</div>
                        <div>
                            <h5 class="mb-0">Check Out</h5>
                            <small>Choose the item you would like to bid on</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="container py-3">
        <div class="categories-scroll position-relative">
            <button class="btn btn-light scroll-btn scroll-left"><i class="bi bi-chevron-left"></i></button>
            <div class="categories d-flex gap-3">
                <a href="#" class="category-link">Apple</a>
                <a href="#" class="category-link">Bid Packs</a>
                <a href="#" class="category-link">Console & Videogame</a>
                <a href="#" class="category-link">Crypto & Bitcoin</a>
                <a href="#" class="category-link">Electronics & Computers</a>
                <a href="#" class="category-link">Fitness</a>
                <a href="#" class="category-link">Gadgets</a>
                <a href="#" class="category-link">Garden & Tools</a>
                <a href="#" class="category-link">Gift Card</a>
                <a href="#" class="category-link">Health & Beauty</a>
            </div>
            <button class="btn btn-light scroll-btn scroll-right"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>

    <!-- Auction Items -->
    @include('front.auction_items')
@endsection

@section('scripts')
    @parent
    <!-- Include Pusher and Laravel Echo from CDNs in your Blade file -->
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7.0.3/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

    <script>
        $(document).ready(function() {
            console.log('index page Ready');




            $(".bid_now_btn").click(function(e) {
                e.preventDefault();
                let that = $(this);
                let item_id = that.data('id');
                console.log(item_id);

                $.ajax({
                    type: "POST",
                    url: "/product/bidding",
                    data: {
                        item_id: item_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log("Success:", response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            });





        });
    </script>

    <script>
        // Initialize Laravel Echo with Pusher
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'b412aa57552f69c0170e',
            // cluster: 'mt1',
            cluster: 'ap2',
            forceTLS: true
        });

        // Listen to the channel and event
        window.Echo.channel('bids')
            .listen('PriceUpdated', (event) => {
                console.log(event);

                const itemElement = document.querySelector(`#item-${event.itemId}`);
                if (itemElement) {
                    itemElement.querySelector('.price').innerText = event.newPrice.toFixed(2);
                }
            });
    </script>
@endsection

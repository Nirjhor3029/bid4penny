@extends('layouts.front')

@section('styles')
    <style>
        .highlight-text {
            background-color: #80d780;
        }

        .timer {
            font-size: 18px;
            color: red;
            font-weight: bold;
        }
    </style>
@endsection

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

            // Check if user is logged in (Example logic, adjust according to your backend)
            const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }}; // Replace with your backend logic


            $(".bid_now_btn").click(function(e) {
                e.preventDefault();

                if (!isLoggedIn) {
                    window.location.href = "{{ route('login') }}"; // Redirect to login page
                }

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



            $(".timer").each(function() {
                const timer = $(this);
                let totalSeconds = parseInt(timer.data("time"), 10);

                // Find the associated button for this timer
                const bidButton = timer.closest(".product-card").find(".bid_now_btn");

                const interval = setInterval(function() {
                    const minutes = Math.floor(totalSeconds / 60);
                    const seconds = totalSeconds % 60;

                    // Format as MM:SS
                    timer.text(
                        `00:${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`
                    );

                    totalSeconds--;

                    if (totalSeconds < 0) {
                        clearInterval(interval);
                        timer.text("00:00:00"); // Time is up!

                        console.log('Time is up! disabled');

                        // Disable the associated button
                        bidButton.prop("disabled", true).addClass("disabled");
                    }
                }, 1000);

                // Attach interval to the timer element for easy access later
                timer.data("interval", interval);
            });



        });
    </script>

    <script>
        $(document).ready(function() {


            // Initialize Laravel Echo with Pusher
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: 'b412aa57552f69c0170e',
                // cluster: 'mt1',
                cluster: 'ap2',
                forceTLS: true
            });

            // Listen to the channel and event
            // window.Echo.channel('bids')
            //     .listen('PriceUpdated', (event) => {
            //         console.log(event);

            //         const itemElement = document.querySelector(`#item-${event.itemId}`);
            //         if (itemElement) {
            //             itemElement.querySelector('.price').innerText = event.newPrice.toFixed(2);
            //         }
            //     });

            window.Echo.channel('bids')
                .listen('.price.updated', (event) => { // Note the leading dot
                    console.log(event);


                    const itemElement = $(`#item-${event.itemId}`);
                    if (itemElement) {
                        itemElement.find('.price_amount').text(event.newPrice.toFixed(2));
                        itemElement.find('.bidding_count').text(event.totalBids);
                        itemElement.find('.last_bidder').text(event.lastBidder);



                        let dynamicText = itemElement.find(".dynamic-text");
                        dynamicText.addClass("highlight-text");
                        setTimeout(() => {
                            dynamicText.removeClass("highlight-text");
                        }, 1000);



                        // Reset the timer for this specific product/item
                        const timer = itemElement.find(".timer");
                        let interval = timer.data("interval");

                        // Clear the existing interval
                        clearInterval(interval);

                        // Restart the timer with 10 seconds
                        let totalSeconds = 10;
                        const newInterval = setInterval(() => {
                            const minutes = Math.floor(totalSeconds / 60);
                            const seconds = totalSeconds % 60;

                            // Format as MM:SS
                            timer.text(
                                `00:${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`
                            );

                            totalSeconds--;

                            if (totalSeconds < 0) {
                                clearInterval(newInterval);
                                timer.text("00:00:00"); // Time is up!

                                // Disable the associated button
                                itemElement.find(".bid_now_btn").prop("disabled", true).addClass(
                                    "disabled");
                            }
                        }, 1000);

                        // Save the new interval ID to the timer element
                        timer.data("interval", newInterval);






                    }
                });
        });
    </script>
@endsection

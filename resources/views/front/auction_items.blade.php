<div class="container py-4">
    <div class="row g-4">

        @foreach ($products as $item)
            <!-- Auction Item -->
            <div class="col-md-3">
                <div class="card product-card h-100" id="item-{{ $item->id }}">
                    <div class="position-relative">
                        <img src="{{ asset('/assets/front/images/placeholder.PNG') }}" class="card-img-top"
                            alt="MacBook Pro">
                        <button class="btn btn-sm btn-light position-absolute top-2 end-2" style="top: 10px;right: 10px">
                            <i class="bi bi-star"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">
                            {{ $item->name }}
                        </h6>
                        <div class="d-flex justify-content-between align-items-center dynamic-text">
                            <div class="price">
                                $<span class="price_amount">{{ $item->current_price ?? $item->auction_starting_price }}</span>
                                <br>
                            </div>
                            @php
                                $bidding_count = 0;
                                $last_bidder = '';
                                if (isset($item->biddings)) {
                                    $bidding_count = count($item->biddings);
                                    $last_bidder = $item->biddings->last()->user->name?? '';
                                }
                            @endphp
                            <small class="text-muted"><span class="bidding_count">{{ $bidding_count }}</span>
                                Bids</small>
                        </div>
                        <small class="text-muted">
                            Price increase ${{ $item->price_increase_by }}
                        </small>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: 45%"></div>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center mt-3">
                            <div>
                                <div class="last_bidder" style="color: green">{{$last_bidder}}</div>
                            </div>
                            <div>
                                <small class="text-muted">Time Left</small>
                                <div class="timer" data-time="10">
                                    {{-- 00:00:10 --}}
                                    Coming Soon 09:00 
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="retail_price">
                                <small class="text-muted">Retail Price</small>
                                <div>{{ $item->price }}</div>
                            </div>

                            <button class="btn btn-success btn-sm starting_soon_btn" disabled>
                                Starting soon
                            </button>
                            <button class="btn btn-success btn-sm bid_now_btn" style="display: none" data-id="{{ $item->id }}">
                                Bid Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

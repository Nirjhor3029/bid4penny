<div class="container py-4">
    <div class="row g-4">

        @foreach ($products as $item)
            <!-- Auction Item -->
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="position-relative">
                        <img src="{{ asset('/assets/front/images/placeholder.PNG') }}"
                            class="card-img-top" alt="MacBook Pro">
                        <button class="btn btn-sm btn-light position-absolute top-2 end-2">
                            <i class="bi bi-star"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">
                            {{$item->name}}
                        </h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="price">
                                ${{$item->current_price ?? $item->price}}
                                <br>
                                <small class="text-muted">
                                    Price increase ${{$item->price_increase_by}}
                                </small>
                            </div>
                            <small class="text-muted">15 Bids</small>
                        </div>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: 45%"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="timer">
                                <small class="text-muted">Time Left</small>
                                <div>09:00</div>
                            </div>
                            <button class="btn btn-success btn-sm bid_now_btn" data-id="{{$item->id}}">Bid Now</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

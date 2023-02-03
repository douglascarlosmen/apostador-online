<div class="ticket">
    <div class="ticket-header">

    </div>
    @foreach ($games as $game)
        {!!$game!!}
    @endforeach
    <div class="ticket-footer">
        <div class="footer-box" id="15">
            @if($quantity == 15) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="16">
            @if($quantity == 16) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="17">
            @if($quantity == 17) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="18">
            @if($quantity == 18) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="19">
            @if($quantity == 19) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="20">
            @if($quantity == 20) <div class="{{$type}}"></div> @endif
        </div>

    </div>
</div>
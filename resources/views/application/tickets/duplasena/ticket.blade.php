<div class="ticket">
    <div class="ticket-header">

    </div>
    @foreach ($games as $game)
        {!!$game!!}
    @endforeach
    <div class="ticket-footer">
        <div class="footer-box" id="6">
            @if($quantity == 6) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="7">
            @if($quantity == 7) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="8">
            @if($quantity == 8) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="9">
            @if($quantity == 9) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="10">
            @if($quantity == 10) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="11">
            @if($quantity == 11) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="12">
            @if($quantity == 12) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="13">
            @if($quantity == 13) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="14">
            @if($quantity == 14) <div class="{{$type}}"></div> @endif
        </div>
        <div class="footer-box" id="15">
            @if($quantity == 15) <div class="{{$type}}"></div> @endif
        </div>

    </div>
</div>
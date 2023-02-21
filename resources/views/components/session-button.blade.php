@isset($session)
  @if($session === true)
    <x-secondary-button class="togglesessionbutton flex justify-center items-center active:scale-95 cursor-pointer" style="min-height:calc(var(--vh) * 7.5);min-width:10%">
      <img src="{{ asset('storage/Assets/pauseLight.svg') }}">
    </x-secondary-button>
  @else
    <x-secondary-button class="togglesessionbutton flex justify-center items-center active:scale-95 cursor-pointer" style="min-height:calc(var(--vh) * 7.5);min-width:10%">
      <img src="{{ asset('storage/Assets/playLight.svg') }}">
    </x-secondary-button>
  @endif
@else
  <x-secondary-button class="togglesessionbutton flex justify-center items-center active:scale-95 cursor-pointer" style="min-height:calc(var(--vh) * 7.5);min-width:10%">
    <img src="{{ asset('storage/Assets/playLight.svg') }}">
  </x-secondary-button>
@endisset
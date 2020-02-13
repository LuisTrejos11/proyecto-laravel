@if( Auth::user()->image_path)

<div class = "container-avatar"> 
<img src="{{ route('user.avatar', ['filename'=> Auth::user()->image_path]) }}" class="avatar" />
</div>


   @endif
@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">  
    <div class='col'>  
    <div class="card">
                <div class="card-header text-white">{{ __('Profile Settings') }}</div>
  
                <div class="card-body">
                    <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                        @csrf
  
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class='row justify-content-md-center mb-3'>
                            <div class='col-md-auto'>
                        <img src="/avatars/{{ Auth::user()->avatar }}" style="width:200px;margin-top: 10px;">
</div>
</div>
                        <div class="row mb-3 justify-content-md-center">
  
                            <div class="col-md-auto">
                                <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" value="{{ old('avatar') }}" required autocomplete="avatar">
  
                                
  
                                @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
  
                        <div class="row justify-content-md-center">
                            <div class="col-md-auto">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Upload New Profile Avatar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr class='divider'>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @else
                @if (is_null(Auth::user()->steam_id))
                <div class="card">
                    <a type="button" onclick="event.preventDefault(); document.getElementById('steam-auth').submit();" href="{{ route('steam-auth') }}" class="btn btn-outline-light text-white hover:bg-gray-600">
                        Link Steam Account
                    </a> 
                    <form id="steam-auth" action="{{ route('steam-auth') }}" method="GET">
                                @csrf
                            </form>
                @else
                <div class="card">
                    <a type="button" class="btn btn-outline-light text-white hover:bg-gray-600" disabled>
                        Steam Account Linked!
                    </a> 
                    @endif
</div>     
@if (is_null(Auth::user()->discord_id))
                <div class="card">
                    <a type="button" onclick="event.preventDefault(); document.getElementById('discord-auth').submit();" href="{{ route('discord-auth') }}" class="btn btn-outline-light text-white hover:bg-gray-600">
                        Link Discord Account
                    </a> 
                    <form id="discord-auth" action="{{ route('discord-auth') }}" method="GET">
                                @csrf
                            </form>
                @else
                <div class="card">
                    <a type="button" class="btn btn-outline-light text-white hover:bg-gray-600" disabled>
                        Discord Account Linked!
                    </a> 
                    @endif
</div>   
                @endif                
            </div>
                </div>
                
            </div>
            
</div>
        </div>
    
@endsection
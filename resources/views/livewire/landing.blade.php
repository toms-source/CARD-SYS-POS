<!-- @extends('layouts.auth') -->

@section('content')
<div class="container">
    
    <form action="{{ route('client.register') }}">
        <button type="submit"> Get Started </button>
    </form>
    <a href="{{route('client.login')}}">Already have an account?</a>


    {{-- <nav class="navbar bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">
      <div>B&D Clinic</div>
    </a>
    <a class="navbar-brand" href="#">
      <Button type="button" class="btn btn-primary">Login</Button>
    </a>
  </div>
</nav> --}}
</div>
@endsection
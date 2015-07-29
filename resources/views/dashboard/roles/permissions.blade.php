@extends('dashboard.layout')

@section('content')

<div class = "card half">

@foreach($permissions_parents as $parent)

  <h3>{{$parent}}</h3>

  @foreach($models as $model)

    @foreach($model::getPermissions() as $permission)

      @if(array_search($parent,explode("_",$permission)))
        {{-- <div>{{ $permission }}</div> --}}
        <?php var_dump("ddd"); ?>
      @endif

    @endforeach

  @endforeach

@endforeach


</div>

@endsection

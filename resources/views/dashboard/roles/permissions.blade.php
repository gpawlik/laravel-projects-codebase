@extends('dashboard.layout')

@section('content')

<div class = "card half">

@foreach($permissions_parents as $parent)

  <div>
  <h3>{{$parent}}</h3>

  <table class = "details-table">

  @foreach($models as $model)

    @foreach($model::getPermissions() as $permission)

      @if($parent == explode("_",$permission)[0])

        <?php
          $checkValue = null;
          foreach($roles_permissions as $roles_permission)
          {
            if($roles_permission->permission_name == $permission)
            {
              $checkValue = "checked";
            }
          }
        ?>
          <tr><td> {{ $permission }} </td> <td><input type = "checkbox" name = "{{$permission."_check"}}" value = "{{$permission}}" @if(isset($checkValue)) checked @endif /></td></tr>

      @endif

    @endforeach

  @endforeach
  </table>
  </div>
@endforeach

</div>

@endsection

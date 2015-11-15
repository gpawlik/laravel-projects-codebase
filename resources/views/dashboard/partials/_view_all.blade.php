<table class = "view-table">
<?php
  $permissions = \DB::table("permissions")->where("role_id",Auth::user()->role_id)->get();
?>
  <tr>

    @foreach($cols as $col)
      <th>{{$col}}</th>
    @endforeach

    @if(isset($foreign))
      <?php

        foreach($foreign as $f) {

          echo "<th>".$f['name']."</th>";

        }

       ?>
    @endif

    @if(isset($actions))
      @foreach($actions as $action)
        <?php
          foreach($permissions as $permission)
          {
            if(isset($permission_prefix))
            {
              if($permission->permission_name == $permission_prefix."_can_".$action)
              {
                ${$action."Permission"} = 1;
                echo "<th></th>";
              }
            }

            if(isset($permission_name))
            {
              if($permission->permission_name == $permission_name)
              {
                ${$action."Permission"} = 1;
                echo "<th></th>";
              }
            }
          }
        ?>
      @endforeach
    @endif

    @if(isset($extraActions))
      @foreach($extraActions as $extraAction)
        <?php
          foreach($permissions as $permission)
          {
            if($permission->permission_name == $extraAction['permission'])
            {
              echo "<th></th>";
            }
          }
        ?>
      @endforeach
    @endif


  </tr>

    @foreach($data as $d)


    <tr>

      @foreach($cols as $col)
        <?php
          $val = str_replace(' ', '_', strtolower($col));
        ?>
        <td>{{ str_limit($d-> $val,55) }}</td>
      @endforeach

      @if(isset($foreign))
        <?php

          foreach($foreign as $f) {

            echo "<td>".$f['model']::find($d->$f['key'])->$f['property']."</td>";

          }

         ?>
      @endif

      @foreach($actions as $action)


                @if($action == 'delete')
                  @if(isset($deletePermission))
                    <td class = "table-actions">
                      <a href = '#' title = 'delete' ><i class='fa fa-trash delete_btn'></i></a>
                      <div class = 'hidden_question'> Are You sure you want to delete?
                        <a href = '/{{ strtolower($route) }}/{{ $action }}/{{ strtolower($d->id) }}'><button class = 'mini_btn confirm_delete'>yes</button></a>
                        <button class = 'mini_btn cancel_delete'>no</button>
                      </div>
                      </a>
                    </td>
                  @endif
                @endif

                @if($action == 'view')
                  @if(isset($viewPermission))
                  <td class = "table-actions">
                    <a href = '/{{ strtolower($route) }}/{{ strtolower($d->id) }}' title = {{$action}} ><i class='fa fa-eye'></i></a>
                  </td>
                  @endif
                @endif

                @if($action == 'edit')
                  @if(isset($editPermission))
                  <td class = "table-actions">
                    <a href = '/{{ strtolower($route) }}/{{ strtolower($d->id) }}/{{ $action }}' title = {{$action}} ><i class='fa fa-pencil'></i></a>
                  </td>
                  @endif
                @endif


                </a>

              </td>

      @endforeach

      @if(isset($extraActions))
        @foreach($extraActions as $extraAction)
          @foreach($permissions as $permission)
            @if($permission->permission_name == $extraAction['permission'])
              <td class = "table-actions">
                  <a href = '/{{ $extraAction['route'] }}/{{ strtolower($d->id) }}' title = {{ $extraAction['title'] }} > {!! $extraAction['icon'] !!} </a>
              </td>
            @endif
          @endforeach
        @endforeach
      @endif

    </tr>

    @endforeach


</table>

  @if(count($data) == 0)
    <div id = "no-data">No Data</div>
  @endif

<div class = "page_links">	{!! $data -> render() !!} </div>

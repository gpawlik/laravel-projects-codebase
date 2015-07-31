<div class = "card half">

  @if(isset($data->image_name))
    <div class = "details-image">
      <img src="/uploads/{{$data->image_name}}" />
    </div>
  @endif

    <table class = "details-table">

      @foreach($properties as $property)
        <tr>
          <th> {{ $property['name'] }} </th><td> {{ $data -> $property['property'] }} </td>
        </tr>
      @endforeach

      @if(isset($foreign))
        @foreach($foreign as $f)
          <tr>
            <th> {{ $f['name'] }} </th><td> {{ $f['model']::find($data->$f['key'])->$f['property'] }}</td>
          </tr>
        @endforeach
      @endif

    </table>
</div>

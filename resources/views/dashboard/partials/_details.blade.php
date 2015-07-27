<div class = "card half">

  <table class = "details-table">

    @foreach($properties as $property)
      <tr>
        <th> {{ $property['name'] }} </th><td> {{ $data -> $property['property'] }} </td>
      </tr>
    @endforeach

    @foreach($foreign as $f)
      <tr>
        <th> {{ $f['name'] }} </th><td> {{ $f['model']::find($data->$f['key'])->$f['property'] }}</td>
      </tr>
    @endforeach


  </table>
</div>

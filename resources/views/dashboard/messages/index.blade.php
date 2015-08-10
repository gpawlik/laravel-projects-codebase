@extends('dashboard.layout')

@section('content')

  <a href="/dashboard/messages/add" >
    <div class = "mini-link" title = "Send Message">
      <i class="fa fa-paper-plane"></i>
    </div>
  </a>

  <table class = "view-table">

    <tr>
      <th>Subject</th><th>From</th><th>To</th><th></th><th></th>
    </tr>

    @foreach($messages as $message)

      <tr>

        <td> {{ $message->subject }} </td>

        <td> @if($message->from_user_id == Auth::user()->id) You @else {{ App\User::find($message->from_user_id)->first_name }} {{ App\User::find($message->from_user_id)->last_name }} @endif </td>

        <td> @if($message->to_user_id == Auth::user()->id) You @else {{ App\User::find($message->to_user_id)->first_name }} {{ App\User::find($message->to_user_id)->last_name }} @endif</td>

        <td  class = "table-actions">
          <a href = '/dashboard/messages/view/{{$message->id}}' title = "View Message" ><i class='fa fa-eye'></i></a>
        </td>

        <td  class = "table-actions">
          <a href = '#' title = 'delete' ><i class='fa fa-trash delete_btn'></i></a>
          <div class = 'hidden_question'> Are You sure you want to delete?
            <a href = '/dashboard/messages/delete/{{ $message->id }}'><button class = 'mini_btn confirm_delete'>yes</button></a>
            <button class = 'mini_btn cancel_delete'>no</button>
          </div>
          </a>
        </td>

      </tr>

    @endforeach

  </table>

@endsection

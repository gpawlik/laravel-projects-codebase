@extends('dashboard.layout')

@section('content')

  <a href="/dashboard/reminders/add" >
    <div class = "mini-link" title = "Add Reminder">
      <i class="fa fa-plus"></i>
    </div>
  </a>

  <table class = "view-table">

    <tr>
      <th>Note</th><th>Due Date</th><th>Status</th><th></th><th></th><th></th><th></th><th></th>
    </tr>

    @foreach($reminders as $reminder)

      <tr>

        <td> {{ $reminder->note }} </td><td>@if(isset($reminder->due_date)) {{ $reminder->due_date }} @else NONE @endif</td><td> {{ $reminder -> status }}</td>

        <td  class = "table-actions">
          <a href = '/dashboard/reminders/view/{{$reminder->id}}' title = "View Reminder" ><i class='fa fa-eye'></i></a>
        </td>

        <td  class = "table-actions">
          <a href = '/dashboard/reminders/edit/{{$reminder->id}}' title = "Edit Reminder" ><i class='fa fa-pencil'></i></a>
        </td>

        <td  class = "table-actions">
          <a href = '#' title = 'delete' ><i class='fa fa-trash delete_btn'></i></a>
          <div class = 'hidden_question'> Are You sure you want to delete?
            <a href = '/dashboard/reminders/delete/{{ $reminder->id }}'><button class = 'mini_btn confirm_delete'>yes</button></a>
            <button class = 'mini_btn cancel_delete'>no</button>
          </div>
          </a>
        </td>

        <td  class = "table-actions">
          <a href = '/dashboard/reminders/complete/{{$reminder->id}}' title = "Mark as complete" ><i class='fa fa-check'></i></a>
        </td>

        <td  class = "table-actions">
          <a href = '/dashboard/reminders/undo/{{$reminder->id}}' title = "Mark as complete" ><i class='fa fa-undo'></i></a>
        </td>

      </tr>

    @endforeach

  </table>

@endsection

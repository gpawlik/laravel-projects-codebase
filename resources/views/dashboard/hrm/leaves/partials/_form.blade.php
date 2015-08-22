<table class = "form-element full">

  <tr>
    <td>{!! Form::label("employee","Employee*") !!}</td>
    <td>
      {!! Form::text('employee', $employee_name,

        ['class'=>'text-input','id'=>'employee-field','autocomplete'=>'off','placeholder'=>'Search Employee First / Last Name'])

      !!}
      <div id = "employee-list">

      </div>
    </td>
  </tr>

  <tr>
    <td>{!! Form::label("leave_start_date","Leave Start Date*") !!}</td>
    <td>{!! Form::input("date", 'leave_start_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("leave_end_date","Leave End Date*") !!}</td>
    <td>{!! Form::input("date", 'leave_end_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("reason_for_leave","Reason for Leave") !!}</td>
    <td>{!! Form::textarea("reason_for_leave", null , ['placeholder' => 'Reason for Leave','class'=>'text-input']) !!}</td>
  </tr>

    <tr>
      <td>Include Saturdays</td>
      <td><input type = "checkbox" name = "saturday_check" value = "YES" @if(isset($saturday_checked)) checked @endif/></td>
    </tr>

    <tr>
      <td>Include Sundays</td>
      <td><input type = "checkbox" name = "sunday_check" value = "YES" @if(isset($sunday_checked)) checked @endif/></td>
    </tr>

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>

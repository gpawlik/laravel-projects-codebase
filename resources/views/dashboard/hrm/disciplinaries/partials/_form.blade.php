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
    <td>{!! Form::label("type_of_warning","Type of Warning*") !!}</td>
    @if(isset($type_of_warning))
      <td>{!! Form::select("type_of_warning", ['VERBAL WARNING'=>'Verbal Warning','FIRST WARNING LETTER'=>'First Warning Letter','SECOND WARNING LETTER'=>'Second Warning Letter'],
          $type_of_warning, array('class' => 'select-input') ) !!}</td>
    @else
      <td>{!! Form::select("type_of_warning", ['VERBAL WARNING'=>'Verbal Warning','FIRST WARNING LETTER'=>'First Warning Letter','SECOND WARNING LETTER'=>'Second Warning Letter'],
          null, array('class' => 'select-input') ) !!}</td>
    @endif
  </tr>

  <tr>
    <td>{!! Form::label("action_taken","Disciplinary Action Taken*") !!}</td>
    @if(isset($action_taken))
      <td>{!! Form::select("action_taken", ['SUSPENSION'=>'Suspension','DISMISSAL'=>'Dismissal','SUMMARY DISMISSAL'=>'Summary Dismissal'], $action_taken,
        array('class' => 'select-input','id'=>'discipline-select')) !!}</td>
    @else
      <td>{!! Form::select("action_taken", ['SUSPENSION'=>'Suspension','DISMISSAL'=>'Dismissal','SUMMARY DISMISSAL'=>'Summary Dismissal'], null,
        array('class' => 'select-input','id'=>'discipline-select')) !!}</td>
    @endif
  </tr>

  <tr id = "suspension-row">
    <td>{!! Form::label("suspension_number_of_days","Number of Days on Suspension*") !!}</td>
    <td>{!! Form::text("suspension_number_of_days", null , ['placeholder' => 'Number of Days on Suspension','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("offense","Offense") !!}</td>
    <td>{!! Form::textarea("offense", null , ['placeholder' => 'Offense','class'=>'text-input']) !!}</td>
  </tr>

    <tr>
      <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
    </tr>



</table>

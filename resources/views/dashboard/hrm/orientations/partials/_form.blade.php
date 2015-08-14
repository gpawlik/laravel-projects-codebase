<table class = "form-element full">

  <tr>
    <td>{!! Form::label("orientation_start_date","Orientation Start Date") !!}</td>
    <td>{!! Form::input("date", 'orientation_start_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("orientation_end_date","Orientation End Date") !!}</td>
    <td>{!! Form::input("date", 'orientation_end_date', null , ['class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("orientation_outcome","Outcome of Orientation") !!}</td>
    @if(isset($orientation_outcome))
      <td>{!! Form::select("orientation_outcome", ['SUCCESSFUL'=>'Successful','UNSUCCESSFUL'=>'Unsuccessful'], $orientation_outcome, array('class' => 'select-input') ) !!}</td>
    @else
      <td>{!! Form::select("orientation_outcome", ['SUCCESSFUL'=>'Successful','UNSUCCESSFUL'=>'Unsuccessful'], null, array('class' => 'select-input') ) !!}</td>
    @endif
  </tr>

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
      <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
    </tr>



</table>

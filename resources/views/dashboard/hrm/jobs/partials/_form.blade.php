<table class = "form-element full">

  <tr>
    <td>{!! Form::label("job_title","Job Title") !!}</td>
    <td>{!! Form::text("job_title", null , ['placeholder' => 'Job Title','class'=>'text-input']) !!}</td>
  </tr>

  @if(isset($departments))
  <tr>
    <td>{!! Form::label("department_id","Department") !!}</td>

    @if(isset($jobs_department))
    <td>
      {!! Form::select("department_id", array( $jobs_department -> id => $jobs_department -> department_name ) +  $departments, $jobs_department, array('class' => 'select-input') ) !!}
    </td>
    @else
    <td>
      {!! Form::select("department_id", $departments,null,array('class' => 'select-input') ) !!}
    </td>
    @endif
  </tr>
  @endif

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>

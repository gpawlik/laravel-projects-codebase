<table class = "form-element full">

  <tr>
    <td>{!! Form::label("description","Description") !!}</td>
    <td>{!! Form::text("description", null , ['placeholder' => 'Description','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("minimum_salary","Minimum Salary") !!}</td>
    <td>{!! Form::text("minimum_salary", null , ['placeholder' => 'Minimum Salary','class'=>'text-input']) !!}</td>
  </tr>

  <tr>
    <td>{!! Form::label("maximum_salary","Maximum Salary") !!}</td>
    <td>{!! Form::text("maximum_salary", null , ['placeholder' => 'Maximum Salary','class'=>'text-input']) !!}</td>
  </tr>

  @if(isset($jobs))
  <tr>
    <td>{!! Form::label("job_id","Job") !!}</td>

    @if(isset($paygrades_job))
    <td>
      {!! Form::select("job_id", array( $paygrades_job -> id => $paygrades_job -> job_title ) +  $jobs, $paygrades_job, array('class' => 'select-input') ) !!}
    </td>
    @else
    <td>
      {!! Form::select("job_id", $jobs,null,array('class' => 'select-input') ) !!}
    </td>
    @endif
  </tr>
  @endif

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'submit-button')) !!}</td>
  </tr>

</table>

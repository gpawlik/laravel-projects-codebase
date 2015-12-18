<table class = "form-element full">

  <tr>
    <td>{!! Form::label("role_name","Role Name") !!}</td>
    <td>
    	<div class="form-group">
    		{!! Form::text("role_name", null , ['placeholder' => 'Role Name','class'=>'form-control']) !!}
    	</div>
    </td>
  </tr>

  <tr>
    <td colspan="2" align="right">{!! Form::submit($submitButtonText, array('class' => 'btn btn-primary')) !!}</td>
  </tr>

</table>

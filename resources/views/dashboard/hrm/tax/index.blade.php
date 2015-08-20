@extends('dashboard.layout')

@section('content')

{!! Form::open(['method' => 'POST','action' => ['TaxController@saveTaxModel'] ] ) !!}

<div class = "card half">

  <h4>Tax Model</h4>

  <hr/>

  @if(isset($taxModel))
    <div>
      <h4>Existing Tax Model</h4>

      <table id = "existing-tax-table" class = "form-element full align-left">
        <tr><th>Step Name</th><th>Amount Limit</th><th>Rate</th></tr>
        @foreach($taxModel as $modelData)
          <tr>
            <td>{{ $modelData -> step }}</td>
            <td>{{ $modelData -> amount_limit }}</td>
            <td>{{ $modelData -> rate }} %</td>
          </tr>
        @endforeach

      </table>

    </div>
  @endif

  <h4>Create New Tax Model</h4>

  @include('errors.error_list')

  <table id = "tax-model-table" class = "form-element full">

    <tr class = "tax-model-row">
      <td><input type = "text" placeholder="Step Name" class = "text-input" name = "step_1"></td>
      <td><input type = "text" placeholder="Amount Limit" class = "text-input" name = "limit_1"></td>
      <td><input type = "text" placeholder="Rate %" class = "text-input" name = "rate_1"></td>
      <td><div class = "remove-row"><i class = "fa fa-close" ></i></div></td>
    </tr>

  </table>

  <input type = "button" id = "add-new-row-btn" value = "Add new row"/>

</div>

{!! Form::submit("Save", array('class' => 'submit-button')) !!}

{!! Form::close() !!}

@endsection

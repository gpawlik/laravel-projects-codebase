@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "data" => $loan,

      "properties" => array
        (
          array(
            'name'=>'Loan Type',
            'property' => 'loan_type'
          ),
          array(
            'name'=>'Amount',
            'property' => 'amount'
          ),
          array(
            'name'=>'Payment Frequency',
            'property' => 'payment_frequency'
          ),
          array(
            'name'=>'Start Date',
            'property' => 'start_date'
          ),
          array(
            'name'=>'End Date',
            'property' => 'end_date'
          ),
          array(
            'name'=>'Payment Status',
            'property' => 'payment_status'
          )
        ),

        'foreign' => array
          (
            array(
            'name'=>'Employee First Name',
            'model'=> 'App\Employee',
            'key'=> 'employee_id',
            'property' => 'first_name'
            ),
            array(
            'name'=>'Employee Last Name',
            'model'=> 'App\Employee',
            'key'=> 'employee_id',
            'property' => 'last_name'
            ),
            array(
            'name'=>'Bank',
            'model'=> 'App\Bank',
            'key'=> 'bank_id',
            'property' => 'bank_name'
            )
          )
        )
    )

@endsection

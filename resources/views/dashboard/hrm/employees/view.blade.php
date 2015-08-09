@extends('dashboard.layout')

@section('content')


  @include('dashboard.partials._details', array
    (
      "size" => "full",

      "data" => $employee,

      "properties" => array
        (
          array(
            'name'=>'Staff Number',
            'property' => 'staff_number'
          ),
          array(
            'name'=>'First Name',
            'property' => 'first_name'
          ),
          array(
            'name'=>'Last Name',
            'property' => 'last_name'
          ),
          array(
            'name'=>'Other Names',
            'property' => 'other_names'
          ),
          array(
            'name'=>'Date of Birth',
            'property' => 'date_of_birth'
          ),
          array(
            'name'=>'Marital Status',
            'property' => 'marital_status'
          ),
          array(
            'name'=>'Spouse Name',
            'property' => 'spouse_name'
          ),
          array(
            'name'=>'Next of Kin',
            'property' => 'next_of_kin'
          ),
          array(
            'name'=>'Gender',
            'property' => 'gender'
          ),
          array(
            'name'=>'Social Security Number',
            'property' => 'social_security_number'
          ),
          array(
            'name'=>'Email',
            'property' => 'email'
          ),
          array(
            'name'=>'Telephone Number',
            'property' => 'telephone_number'
          ),
          array(
            'name'=>'Mailing Address',
            'property' => 'mailing_address'
          ),
          array(
            'name'=>'Residential Address',
            'property' => 'residential_address'
          ),
          array(
            'name'=>'Emergency Contact Name',
            'property' => 'emergency_contact_name'
          ),
          array(
            'name'=>'Emergency Contact Number',
            'property' => 'emergency_contact_number'
          ),
          array(
            'name'=>'Allergies',
            'property' => 'alergies'
          ),
          array(
            'name'=>'Father\'s Name',
            'property' => 'fathers_name'
          ),
          array(
            'name'=>'Mother\'s Name',
            'property' => 'mothers_name'
          ),
          array(
            'name'=>'Bank Account Number',
            'property' => 'bank_account_number'
          ),
          array(
            'name'=>'Qualifications',
            'property' => 'qualifications'
          ),
          array(
            'name'=>'Date of Hire',
            'property' => 'date_of_hire'
          ),
          array(
            'name'=>'Basic Salary',
            'property' => 'basic_salary'
          ),
          array(
            'name'=>'Identification Number',
            'property' => 'identification_number'
          ),
          array(
            'name'=>'Tax Identification Number',
            'property' => 'tax_identification_number'
          ),
          array(
            'name'=>'Number of Dependants',
            'property' => 'number_of_dependants'
          )
        ),

      'foreign' => array
        (
          array(
          'name'=>'Job',
          'model'=> 'App\Job',
          'key'=> 'job_id',
          'property' => 'job_title'
          ),
          array(
          'name'=>'Bank',
          'model'=> 'App\Bank',
          'key'=> 'bank_id',
          'property' => 'bank_name'
          ),
          array(
          'name'=>'Identification',
          'model'=> 'App\Identification',
          'key'=> 'identification_id',
          'property' => 'identification_name'
          )
        )
    )
  )

@endsection

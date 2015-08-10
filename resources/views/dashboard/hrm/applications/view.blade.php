@extends('dashboard.layout')

@section('content')


  <div class = "card half">

      <table class = "details-table">

            <tr>
              <th> Applicant First Name </th><td> {{ $application -> applicant_first_name }}</td>
            </tr>

            <tr>
              <th> Applicant Last Name </th><td> {{ $application -> applicant_last_name }}</td>
            </tr>

            <tr>
              <th> Applicant Email </th><td> {{ $application -> applicant_email }}</td>
            </tr>

            <tr>
              <th> Applicant Contact Number </th><td> {{ $application -> applicant_contact_number }}</td>
            </tr>

            <tr>
              <th> Application Status </th><td> {{ $application -> application_status }}</td>
            </tr>

            <tr>
              <th> Application Date </th><td> {{ $application -> application_date }}</td>
            </tr>

            @if(isset($application -> applicant_interview_date))
              <tr>
                <th> Applicant Interview Date </th><td> {{ $application -> applicant_interview_date }}</td>
              </tr>
            @endif

            @if(isset($application -> applicant_cv_file_name))
              <tr>
                <th> Applicant CV </th><td> <a class = "red-link" href = "/uploads/{{ $application -> applicant_cv_file_name }}" target="_blank">Click to view</td>
              </tr>
            @endif

            @if(isset($application -> applicant_letter_file_name))
              <tr>
                <th> Applicant Application Letter </th><td> <a class = "red-link" href = "/uploads/{{ $application -> applicant_letter_file_name}}" target="_blank">Click to view</td>
              </tr>
            @endif

      </table>
  </div>

@endsection

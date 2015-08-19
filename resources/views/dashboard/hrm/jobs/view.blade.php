@extends('dashboard.layout')

@section('content')


  <div class = "card half">

      <table class = "details-table">

            <tr>
              <th> Job Title </th><td> {{ $job -> job_title }}</td>
            </tr>

            <tr>
              <th> Job Capacity </th><td> {{ $job -> job_capacity }}</td>
            </tr>

            @if(isset($job -> job_description))
              <tr>
                <th> Job Description </th><td> {{ $job -> job_description }}</td>
              </tr>
            @endif

            @if(isset($job -> job_specifications_file_name))
              <tr>
                <th> Job Specifications </th><td> <a class = "red-link" href = "/uploads/{{ $job -> job_specifications_file_name }}" target="_blank">Click to view</td>
              </tr>
            @endif

            <tr>
              <th> Department </th><td> {{ \DB::table("departments")->where("id",$job -> department_id)->get()[0]->department_name  }}</td>
            </tr>

      </table>
  </div>

@endsection

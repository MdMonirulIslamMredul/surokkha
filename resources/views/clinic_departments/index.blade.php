@extends('layouts.app')
@section('title')
    Clinic Departments
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            {{ Form::hidden('clinicDepartmentUrl', url('clinic-departments'), ['id' => 'showClinicDepartmentUrl']) }}
            {{ Form::hidden('clinicDepartment', 'Clinic Department', ['id' => 'clinicDepartmentItem']) }}
            <livewire:clinic-department-table/>
            @include('partials.page.templates.templates')
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Status toggle
            $(document).on('change', '.clinicDepartmentStatus', function () {
                let deptId = $(this).attr('data-id');
                $.ajax({
                    url: $('#showClinicDepartmentUrl').val() + '/' + deptId + '/active-deactive',
                    method: 'post',
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (result) {
                        if (result.success) {
                            displaySuccessMessage(result.message);
                        }
                    },
                    error: function (result) {
                        displayErrorMessage(result.responseJSON.message);
                    }
                });
            });

            // Delete button
            $(document).on('click', '.delete-clinic-department-btn', function (event) {
                let deptId = $(this).attr('data-id');
                deleteItem(
                    $('#showClinicDepartmentUrl').val() + '/' + deptId,
                    '',
                    $('#clinicDepartmentItem').val()
                );
            });
        });
    </script>
@endsection

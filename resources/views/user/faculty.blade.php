@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">

        <div class="d-flex justify-content-between align-items-end">
            <div class="pagetitle animate__animated animate__fadeInDown animate__delay-1s mt-4">
                <h3>Coach List</h3>
                <p>| Manage coach records</p>
            </div>
            <div class="align-self-end">
                <button type="button" class="btn btn-primary w-auto mb-3" id="add-coach"><i class="fa fa-add me-1"></i> Add Coach</button>
                <button type="button" class="btn btn-primary w-auto mb-3" id="upload-excel"><i class="far fa-file-excel me-1"></i> Upload Excel</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card animate__animated animate__fadeIn animate__delay-1s border shadow-sm shadow">
                    <div class="card-header">
                        <div class="w-50">
                            <form method="GET" action="{{ route('faculty') }}" class="w-70">
                                <div class="row g-2">
                                    <div class="col-lg-5 col-md-12">
                                        <input name="search" type="text" class="form-control" placeholder="Search" value="{{ request('search') }}">
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <select name="division" class="form-select">
                                            <option value="">Select Division</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division }}" {{ request('division') == $division ? 'selected' : '' }}>
                                                    {{ $division }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <select name="event" class="form-select">
                                            <option value="">Select Event</option>
                                            @foreach ($events as $event)
                                                <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
                                                    {{ $event }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-1 col-md-12 d-flex align-items-center">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                    <div class="card-body">
                       
                        <table class="table">
                            <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">School</th>
                                    <th scope="col">Event</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($coaches->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">No data available</td>
                                    </tr>
                                @else
                                    @foreach ($coaches as $index => $coach)
                                        <tr>
                                            <td>{{ $coaches->firstItem() + $index }}</td>
                                            <td>{{ $coach->name }}</td>
                                            <td>{{ $coach->division }}</td>
                                            <td>{{ $coach->school }}</td>
                                            <td>{{ $coach->event }}</td>
                                            <td>{{ $coach->username }}</td>
                                            <td>
                                                <button class="button-clear edit-coach" data-id="{{ $coach->participant_id }}" data-name="{{ $coach->name }}" data-division="{{ $coach->division }}" data-school="{{ $coach->school }}" data-event="{{ $coach->event }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="mx-3">
                        {{ $coaches->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="CoachModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Coach</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCoachForm">
                        @csrf
                        <input type="hidden" id="participant_id" name="participant_id">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <span class="text-danger" id="nameError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="division" class="form-label">Division</label>
                                <select class="form-select form-control" id="division" name="division" required>
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division }}">{{ $division }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="divisionError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="event" class="form-label">Event</label>
                                <select class="form-select form-control" id="event" name="event" required>
                                    <option value="">Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event }}">{{ $event }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="eventError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="school" class="form-label">School</label>
                                <input type="text" class="form-control" id="school" name="school" required>
                                <span class="text-danger" id="schoolError"></span>
                            </div>
                           
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitCoachForm">Save Coach</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="UploadExcelModal" tabindex="-1" aria-labelledby="uploadExcelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="uploadExcelLabel">Upload Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadExcelForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="uploadDivision" class="form-label">Division</label>
                                <select class="form-select" id="uploadDivision" name="division" required>
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division }}">{{ $division }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="uploadDivisionError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="event" class="form-label">Event</label>
                                <select class="form-select form-control" id="uploadEvent" name="event" required>
                                    <option value="">Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event }}">{{ $event }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="uploadEventError"></span>
                            </div>
                            <div class="col-lg-12">
                                <label for="excelFile" class="form-label">Excel File</label>
                                <input type="file" class="form-control" id="excelFile" name="excel_file" accept=".xlsx, .xls" required>
                                <span class="text-danger" id="excelFileError"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitUploadExcelForm">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#add-coach').on('click', function() {
                $('#CoachModal').modal('show');
                $('#CoachModal .modal-title').text('Add Coach');
                $('#addCoachForm')[0].reset();
                $('#participant_id').val('');
            });

            $('#upload-excel').on('click', function() {
                $('#UploadExcelModal').modal('show');
                $('#uploadExcelForm')[0].reset();
            });

            $('.edit-coach').on('click', function() {
                var coachId = $(this).data('id');
                var coachName = $(this).data('name');
                var coachDivision = $(this).data('division');
                var coachSchool = $(this).data('school');
                var coachEvent = $(this).data('event');

                $('#CoachModal').modal('show');
                $('#CoachModal .modal-title').text('Edit Coach');
                $('#participant_id').val(coachId);
                $('#name').val(coachName);
                $('#division').val(coachDivision);
                $('#school').val(coachSchool);
                $('#event').val(coachEvent);
            });

            $('#submitCoachForm').on('click', function() {
                var form = $('#addCoachForm');
                var formData = form.serialize();
                var coachId = $('#participant_id').val();
                var url = coachId ? '{{ route('update_coach') }}' : '{{ route('save_coach') }}';

                // Clear previous errors
                $('.text-danger').text('');
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#CoachModal').modal('hide');
                            location.reload();
                        } else {
                            alert('Error saving coach');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        console.log(xhr);
                        if (errors.name) {
                            $('#name').addClass('is-invalid');
                            $('#nameError').text(errors.name[0]);
                        }
                        if (errors.division) {
                            $('#division').addClass('is-invalid');
                            $('#divisionError').text(errors.division[0]);
                        }
                        if (errors.school) {
                            $('#school').addClass('is-invalid');
                            $('#schoolError').text(errors.school[0]);
                        }
                        if (errors.event) {
                            $('#event').addClass('is-invalid');
                            $('#eventError').text(errors.event[0]);
                        }
                       
                    }
                });
            });

            $('#submitUploadExcelForm').on('click', function() {
                var form = $('#uploadExcelForm')[0];
                var formData = new FormData(form);
                var url = '{{ route('save-coach-excel') }}';

                // Clear previous errors
                $('.text-danger').text('');
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#UploadExcelModal').modal('hide');
                            location.reload();
                        } else {
                            console.log(response);
                            alert('Error uploading file');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        console.log(xhr);
                        if (errors.division) {
                            $('#uploadDivision').addClass('is-invalid');
                            $('#uploadDivisionError').text(errors.division[0]);
                        }
                        if (errors.excel_file) {
                            $('#excelFile').addClass('is-invalid');
                            $('#excelFileError').text(errors.excel_file[0]);
                        }
                        if (errors.event) {
                            $('#uploadEvent').addClass('is-invalid');
                            $('#uploadEventError').text(errors.event[0]);
                        }
                    }
                });
            });

            $('#addCoachForm input, #addCoachForm select, #uploadExcelForm input, #uploadExcelForm select').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.text-danger').text('');
            });
        });
    </script>
@endsection
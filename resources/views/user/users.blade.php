@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">
        <div class="  animate__animated  animate__fadeInDown  animate__delay-1s">
            <h3 class="text-start mt-5">User List</h3>
        </div>
        <div class="row p-2">

            <div class="col-12">
                <div class="card px-2 py-4   animate__animated  animate__fadeIn  animate__delay-1s">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center ">
                            <form method="GET" action="{{ route('users') }}" class="mb-3 w-70">
                                <div class="row g-2">
                                    <div class="col-lg-4 col-md-12">
                                        <input name="search" type="text" class="form-control" placeholder="Search"
                                            value="{{ request('search') }}">
                                    </div>
                                    <div class="col-lg-5 col-md-12">
                                        <select name="billeting_quarter" class="form-select">
                                            <option value="">Select Billeting Quarter</option>
                                            @foreach ($quarters as $quarter)
                                                <option value="{{ $quarter }}"
                                                    {{ request('billeting_quarter') == $quarter ? 'selected' : '' }}>
                                                    {{ $quarter }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-lg-1 col-md-12">
                                        <button class="btn btn-primary h-100" type="submit">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-primary w-auto" id="add-user">Add User</button>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Billeting Quarter</th>
                                    <th scope="col">Contact #</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No data available</td>
                                    </tr>
                                @else
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $index }}</td> <!-- Continuous numbering -->
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->billeting_quarter }}</td>
                                            <td>{{ $user->mobile_num }}</td>
                                            <td>
                                                <button class="btn btn-primary edit-user" data-id="{{ $user->user_id }}" data-name="{{ $user->name }}" data-quarter="{{ $user->billeting_quarter }}" data-mobile="{{ $user->mobile_num }}">
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
                        {{ $users->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>

    </section>
    <div class="modal fade" id="UserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <span class="text-danger" id="nameError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="billeting_quarter" class="form-label">Billeting Quarter</label>
                                <select name="billeting_quarter" class="form-select form-control" id="billeting_quarter" required>
                                    <option value="">Select Billeting Quarter</option>
                                    @foreach ($quarters as $quarter)
                                        <option value="{{ $quarter }}">{{ $quarter }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="billetingQuarterError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="mobile_num" class="form-label">Contact #</label>
                                <input type="text" class="form-control" id="mobile_num" name="mobile_num" required>
                                <span class="text-danger" id="mobileNumError"></span>
                            </div>
                            <div class="col-lg-12 password-fields mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <span class="text-danger" id="passwordError"></span>
                            </div>
                            <div class="col-lg-12 password-fields mb-2">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                <span class="text-danger" id="passwordConfirmationError"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitUserForm">Save User</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#add-user').on('click', function() {
                $('#UserModal').modal('show');
                $('#UserModal .modal-title').text('Add User');
                $('#addUserForm')[0].reset();
                $('#user_id').val('');
                $('.password-fields').show();
                $('#password').attr('required', true);
                $('#password_confirmation').attr('required', true);
            });

            $('.edit-user').on('click', function() {
                var userId = $(this).data('id');
                var userName = $(this).data('name');
                var userQuarter = $(this).data('quarter');
                var userMobile = $(this).data('mobile');

                $('#UserModal').modal('show');
                $('#UserModal .modal-title').text('Edit User');
                $('#user_id').val(userId);
                $('#name').val(userName);
                $('#billeting_quarter').val(userQuarter);
                $('#mobile_num').val(userMobile);
                $('#password').removeAttr('required');
                $('#password_confirmation').removeAttr('required');
            });

            $('#submitUserForm').on('click', function() {
                var form = $('#addUserForm');
                var formData = form.serialize();
                var userId = $('#user_id').val();
                var url = userId ? '{{ route('update_user') }}' : '{{ route('save_user') }}';

                // Clear previous errors
                $('.text-danger').text('');
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#UserModal').modal('hide');
                            location.reload();
                        } else {
                            alert('Error saving user');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        console.log(xhr);
                        if (errors.name) {
                            $('#name').addClass('is-invalid');
                            $('#nameError').text(errors.name[0]);
                        }
                        if (errors.billeting_quarter) {
                            $('#billeting_quarter').addClass('is-invalid');
                            $('#billetingQuarterError').text(errors.billeting_quarter[0]);
                        }
                        if (errors.mobile_num) {
                            $('#mobile_num').addClass('is-invalid');
                            $('#mobileNumError').text(errors.mobile_num[0]);
                        }
                        if (errors.password) {
                            $('#password').addClass('is-invalid');
                            $('#passwordError').text(errors.password[0]);
                        }
                        if (errors.password_confirmation) {
                            $('#password_confirmation').addClass('is-invalid');
                            $('#passwordConfirmationError').text(errors.password_confirmation[0]);
                        }
                    }
                });
            });
        });
    </script>
@endsection

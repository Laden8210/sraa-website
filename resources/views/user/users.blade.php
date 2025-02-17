@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">
        <div class="animate__animated animate__fadeInDown animate__delay-1s">
            <h3 class="text-start mt-5">User List</h3>
        </div>
        <div class="row p-2">

            <div class="col-12">
                <div class="card px-2 py-4 animate__animated animate__fadeIn animate__delay-1s">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">
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
                            <thead class="border-top pt-3">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">Billeting Quarter</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">No data available</td>
                                    </tr>
                                @else
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $index }}</td> <!-- Continuous numbering -->
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->division }}</td>
                                            <td>{{ $user->billeting_quarter }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <button class="btn btn-primary edit-user" data-id="{{ $user->user_id }}"
                                                    data-name="{{ $user->name }}" data-username="{{ $user->username }}"
                                                    data-division="{{ $user->division }}"
                                                    data-quarter="{{ $user->billeting_quarter }}"
                                                    data-role="{{ $user->role }}">
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
                                <label for="division" class="form-label">Division</label>
                                <select name="division" class="form-select form-control" id="division" required>
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division }}">{{ $division }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="divisionError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="billeting_quarter" class="form-label">Billeting Quarter</label>
                                <select name="billeting_quarter" class="form-select form-control" id="billeting_quarter"
                                    required>
                                    <option value="">Select Billeting Quarter</option>
                                    @foreach ($quarters as $quarter)
                                        <option value="{{ $quarter }}">{{ $quarter }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="billetingQuarterError"></span>
                            </div>
                            
                            <div class="col-lg-12 mb-2">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" class="form-select form-control" id="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="superintendent">Superintendent</option>
                                </select>
                                <span class="text-danger" id="roleError"></span>
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
            });

            $('.edit-user').on('click', function() {
                var userId = $(this).data('id');
                var userName = $(this).data('name');
                var userUsername = $(this).data('username');
                var userDivision = $(this).data('division');
                var userQuarter = $(this).data('quarter');
                var userRole = $(this).data('role');

                $('#UserModal').modal('show');
                $('#UserModal .modal-title').text('Edit User');
                $('#user_id').val(userId);
                $('#name').val(userName);
                $('#username').val(userUsername);
                $('#division').val(userDivision);
                $('#billeting_quarter').val(userQuarter);
                $('#role').val(userRole).change();
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
                        if (errors.username) {
                            $('#username').addClass('is-invalid');
                            $('#usernameError').text(errors.username[0]);
                        }
                        if (errors.division) {
                            $('#division').addClass('is-invalid');
                            $('#divisionError').text(errors.division[0]);
                        }
                        if (errors.billeting_quarter) {
                            $('#billeting_quarter').addClass('is-invalid');
                            $('#billetingQuarterError').text(errors.billeting_quarter[0]);
                        }
                        if (errors.role) {
                            $('#role').addClass('is-invalid');
                            $('#roleError').text(errors.role[0]);
                        }
                    }
                });
            });
        });
    </script>
@endsection

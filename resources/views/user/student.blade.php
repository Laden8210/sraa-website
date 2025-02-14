@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">
        <div class="  animate__animated  animate__fadeInDown  animate__delay-1s">
            <h3 class="text-start mt-5">Student List</h3>
        </div>
        <div class="row p-2">


            <div class="col-12">
                <div class="card px-2 py-4   animate__animated  animate__fadeIn  animate__delay-1s">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center ">
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" class="form-control" placeholder="Search">

                                <select name="" id="" class="form-select">
                                    <option value="">Select Division</option>
                                </select>
                                <select name="school" class="form-select" id="school">
                                    <option value="School 1">School 1</option>
                                    <option value="School 2">School 2</option>
                                    <option value="School 3">School 3</option>
                                    <option value="School 4">School 4</option>
                                    <option value="School 5">School 5</option>
                                </select>

                                <button class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>


                            <button class="btn btn-primary">Add Student</button>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">Contact #</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>Koronadal</td>
                                    <td>09123456789</td>
                                    <td class="d-flex gap-2 align-items-center">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </button>

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </section>



@endsection

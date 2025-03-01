@extends('layouts.user')

@section('title', 'Event Results')
@section('content')

    <section class="container">
        <div class="d-flex justify-content-between align-items-end">
            <div class="pagetitle animate__animated animate__fadeInDown animate__delay-1s mt-4">
                <h3>Event Results</h3>
                <p>| Manage event results records</p>
            </div>
           
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card animate__animated animate__fadeIn animate__delay-1s border shadow-sm shadow">
                    <div class="card-header">
                        <div class="w-50">
                            <form method="GET" action="{{ route('event-results') }}" class="w-70">
                                <div class="row g-2">
                                    <div class="col-lg-5 col-md-12">
                                        <input name="search" type="text" class="form-control" placeholder="Search"
                                            value="{{ request('search') }}">
                                    </div>
                                    {{-- <div class="col-lg-5 col-md-12">
                                    <select name="division" class="form-select">
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division }}"
                                                {{ request('division') == $division ? 'selected' : '' }}>
                                                {{ $division }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                    <div class="col-lg-1 col-md-12 d-flex align-items-center">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Event Name</th>
                                    <th scope="col">Gold Winner</th>
                                    <th scope="col">Silver Winner</th>
                                    <th scope="col">Bronze Winner</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($eventResults))
                                    <tr>
                                        <td colspan="9" class="text-center">No data available</td>
                                    </tr>
                                @else
                                    @foreach ($eventResults as $index => $eventResult)
                                        @php
                                            // Filter medal winners using array_filter (since it's an array, not a collection)
                                            $gold = collect($eventResult['results'])->firstWhere('medal_type', 'Gold');
                                            $silver = collect($eventResult['results'])->firstWhere('medal_type', 'Silver');
                                            $bronze = collect($eventResult['results'])->firstWhere('medal_type', 'Bronze');
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $eventResult['event_name'] }}</td>
                                            <td>
                                                <h6 class="mb-0">{{ $gold['winner_name'] ?? ' - ' }}</h6>
                                                <p class="mt-1 text-muted mb-0" style="font-size: 14px;">{{ $gold['division'] ?? '' }}</p>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">{{ $silver['winner_name'] ?? ' - ' }}</h6>
                                                <p class="mt-1 text-muted mb-0" style="font-size: 14px;">{{ $silver['division'] ?? '' }}</p>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">{{ $bronze['winner_name'] ?? ' - ' }}</h6>
                                                <p class="mt-1 text-muted mb-0" style="font-size: 14px;">{{ $bronze['division'] ?? '' }}</p>
                                            </td>
                                            <td>
                                                <button class="button-clear edit-event" 
                                                    data-id="{{ $eventResult['event_name'] }}"
                                                    data-event_name="{{ $eventResult['event_name'] }}"
                                                    data-gold_winner="{{ $gold['winner_name'] ?? '' }}"
                                                    data-gold_division="{{ $gold['division'] ?? '' }}"
                                                    data-silver_winner="{{ $silver['winner_name'] ?? '' }}"
                                                    data-silver_division="{{ $silver['division'] ?? '' }}"
                                                    data-bronze_winner="{{ $bronze['winner_name'] ?? '' }}"
                                                    data-bronze_division="{{ $bronze['division'] ?? '' }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            
                        </table>
                    </div>

                </div>
            </div>
    </section>

    <div class="modal fade" id="EventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEventForm">
                        @csrf
                        <input type="hidden" id="event_id" name="event_id">
                        <div class="row">
                            <div class="col-lg-12 mb-2" hidden>
                                <label for="event_name" class="form-label">Event Name</label>
                                <input type="text" class="form-control" id="event_name" name="event_name" required>
                                <span class="text-danger" id="eventNameError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="gold_winner" class="form-label">Gold Winner</label>
                                <input type="text" class="form-control" id="gold_winner" name="gold_winner">
                                <span class="text-danger" id="goldWinnerError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="gold_division" class="form-label">Gold Division</label>
                                <select name="gold_division" class="form-select form-control" id="gold_division">
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division }}">{{ $division }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="goldDivisionError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="silver_winner" class="form-label">Silver Winner</label>
                                <input type="text" class="form-control" id="silver_winner" name="silver_winner">
                                <span class="text-danger" id="silverWinnerError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="silver_division" class="form-label">Silver Division</label>
                                <select name="silver_division" class="form-select form-control" id="silver_division">
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division }}">{{ $division }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="silverDivisionError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="bronze_winner" class="form-label">Bronze Winner</label>
                                <input type="text" class="form-control" id="bronze_winner" name="bronze_winner">
                                <span class="text-danger" id="bronzeWinnerError"></span>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="bronze_division" class="form-label">Bronze Division</label>
                                <select name="bronze_division" class="form-select form-control" id="bronze_division">
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division }}">{{ $division }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="bronzeDivisionError"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitEventForm">Save Event</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('.edit-event').on('click', function() {
                var eventId = $(this).data('id');
                var eventName = $(this).data('event_name');
                var goldWinner = $(this).data('gold_winner');
                var goldDivision = $(this).data('gold_division');
                var silverWinner = $(this).data('silver_winner');
                var silverDivision = $(this).data('silver_division');
                var bronzeWinner = $(this).data('bronze_winner');
                var bronzeDivision = $(this).data('bronze_division');

                $('#EventModal').modal('show');
                $('#EventModal .modal-title').text('Edit Event');
                $('#event_id').val(eventId);
                $('#event_name').val(eventName);
                $('#gold_winner').val(goldWinner);
                $('#gold_division').val(goldDivision);
                $('#silver_winner').val(silverWinner);
                $('#silver_division').val(silverDivision);
                $('#bronze_winner').val(bronzeWinner);
                $('#bronze_division').val(bronzeDivision);
            });

            $('#submitEventForm').on('click', function() {
                showLoader();
                var form = $('#addEventForm');
                var formData = form.serialize();
                var eventId = $('#event_id').val();
                var url = '{{ route('update-event-results') }}';

                $('.text-danger').text('');
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#EventModal').modal('hide');
                            location.reload();
                        } else {
                            alert('Error saving event');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.event_name) {
                            $('#event_name').addClass('is-invalid');
                            $('#eventNameError').text(errors.event_name[0]);
                        }
                        if (errors.gold_winner) {
                            $('#gold_winner').addClass('is-invalid');
                            $('#goldWinnerError').text(errors.gold_winner[0]);
                        }
                        if (errors.gold_division) {
                            $('#gold_division').addClass('is-invalid');
                            $('#goldDivisionError').text(errors.gold_division[0]);
                        }
                        if (errors.silver_winner) {
                            $('#silver_winner').addClass('is-invalid');
                            $('#silverWinnerError').text(errors.silver_winner[0]);
                        }
                        if (errors.silver_division) {
                            $('#silver_division').addClass('is-invalid');
                            $('#silverDivisionError').text(errors.silver_division[0]);
                        }
                        if (errors.bronze_winner) {
                            $('#bronze_winner').addClass('is-invalid');
                            $('#bronzeWinnerError').text(errors.bronze_winner[0]);
                        }
                        if (errors.bronze_division) {
                            $('#bronze_division').addClass('is-invalid');
                            $('#bronzeDivisionError').text(errors.bronze_division[0]);
                        }
                        hideLoader();
                    }
                });
            });
        });
    </script>
@endsection

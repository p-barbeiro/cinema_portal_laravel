@extends('layouts.app')

@section('main')
    <div class="flex flex-col space-y-6">
        <h1>Search Ticket</h1>
        <form action="{{ route('tickets.search-result') }}" method="POST"> <!-- CHANGED HERE -->
            @csrf <!-- CHANGED HERE -->
            <div class="form-group">
                <label for="ticket_id">Ticket ID</label>
                <input type="text" name="ticket_id" id="ticket_id" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
@endsection

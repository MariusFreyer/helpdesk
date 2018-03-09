@extends('layouts.main') 
@section('content')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1>Create a ticket</h1>
        <p>Please describe your problem as detailed as possible. If necessary please add a screenshot!</p>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
    @include('layouts.partials.messages')
            <div class="card">
                <div class="card-header">
                    New Ticket
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('store_ticket') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="Subject">Subject:</label>
                            <input name="subject" type="subject" class="form-control" id="subject">
                        </div>
                        <div class="form-group">
                            <label for="body">Text:</label>
                            <textarea name="body" type="text" class="form-control" id="body" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" name="images[]" multiple>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
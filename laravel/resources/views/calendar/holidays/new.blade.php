@extends('layouts.app')

@section('title', '- dodaj święto')

@section('content')
    <h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Dodaj święto</h1>
    <div class="col-md-8 mx-auto">
        <form method="post">
        @csrf
            <div class="card">
                <div class="card-header">święto</div>
                <div class="card-body">
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nazwa święta</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa święta" name="name" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Data</span>
                        </div>
                        <input type="date" class="form-control" placeholder="Data" name="date" required>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{route('holidays')}}" class="btn btn-primary">Cofnij</a>
                <button type="submit" class="btn btn-success">Dodaj</button>
            </div>
        </form>
    </div>
@endsection
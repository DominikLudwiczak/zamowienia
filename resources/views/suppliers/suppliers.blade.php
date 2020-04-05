@extends('layouts.app')

@section('title', '- dostawcy')

@section('content')
<div class='row align-items-center pt-3'>
    <h1 style='text-decoration: underline;' class='col-md-7'>Dostawcy</h1>
    <div class='input-group col-md-5'>
        <input class="form-control" type="search" placeholder="Szukaj" aria-label="Szukaj">
        <button class="btn btn-outline-success" type="submit">Szukaj</button>
    </div>
</div>
<form action="{{ route('new_supplier') }}" class='pt-3'>
    <button class='btn btn-success float-right'>Dodaj dostawcę</button>
</form>
<table class="table table-striped table-responsive-sm text-center mt-4">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefon</th>
            <th scope="col">Edytuj</th>
            <th scope="col">Usuń</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if($_REQUEST)
                $x = $_REQUEST['page']*15-15; 
            else
                $x=0;
        ?>
        @foreach($suppliers as $supplier)
            <?php $x++; ?>
            <tr>
                <th scope="row">{{$x}}</th>
                <td>{{$supplier->name}}</td>
                <td>{{$supplier->email}}</td>
                <td>{{$supplier->phone}}</td>
                <td class="align-middle"><a href="{{route('edit_supplier',['id' => $supplier->id])}}"><svg class="bi bi-pencil" width="1.5rem" height="1.5rem" viewBox="0 0 16 16" fill="#2842AB" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/></svg></a></td>
                <td class="align-middle"><button class='btn' data-target="#delete" data-toggle="modal" value="{{$supplier->id}}" onclick="modal_delete(this.value)"><svg class="bi bi-trash" width="1.5rem" height="1.5rem" viewBox="0 0 16 16" fill="red" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/></svg></button></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{$suppliers->render()}}
<!-- modal -->
<form method="post" action="{{route('delete_supplier')}}">
@csrf
    <div class="modal fade" tabindex="-1" role="dialog" role="dialog" id="delete" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Czy na pewno chcesz usunąć tego dostawcę?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                Usunięcie tego dostawcy spowoduje usunięcie wszystkich jego produktów!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button class="btn btn-danger" name='id' id='delete_button'>Usuń</button>
            </div>
            </div>
        </div>
    </div>
</form>
<!-- end modal -->
@endsection
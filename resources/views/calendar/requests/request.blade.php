@extends('layouts.app')

@section('title', '- wniosek')

@section('content')
    <div class="col-md-8 mx-auto mt-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col float-left">Wniosek urlopowy</div>
                    <div class="col float-right text-right">{{$users->where('id', $request->user_id)->first()->name}}</div>
                </div>
            </div>
            <div class="card-body">
                <form method='post' id='form'>
                @csrf
                    <input type='hidden' name='url' value="{{URL::previous()}}"/>
                    <?php 
                        $min = date('Y-m-d', strtotime('+1 day'));
                        $max = date('Y-m-d', strtotime('+1 month 1 day'));
                    ?>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="start">Początek:</label>
                            <input class="form-control" type="date" id="start" name='start' value="{{old('start') ?? $request->start}}" min="{{$min}}" max="{{$max ?? ''}}" <?php if($request->confirmed != 0){echo "readonly";}?>/>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="end">Koniec:</label>
                            <input class="form-control" type="date" id="end" name='end' value="{{old('end') ?? $request->end}}" min="{{$min}}" max="{{$max ?? ''}}" <?php if($request->confirmed != 0){echo "readonly";}?>/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label form="status">Status:</label>
                            <input type='text' id='status' class="form-control" value="<?php if($request->confirmed == 0){echo 'do rozpatrzenia';}elseif($request->confirmed == 1){echo 'przyjęty';}else{echo 'odrzucony';} ?>" readonly/>
                        </div>

                        <div class="form-group col-md-6">
                            <label form="sended">Wysłany przez:</label>
                            <input type='text' id='sended' class="form-control" value="{{$users->where('id', $request->who_added)->first()->name}}" readonly/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="last_update">Ostatnia aktualizacja:</label>
                            <input type="text" id='last_update' class="form-control" value="<?php if($request->created_at != $request->updated_at){echo date('d-m-Y H:i:s', strtotime($request->updated_at));}else{echo 'Brak';} ?>" readonly/>
                        </div>

                        @if($request->confirmed != 0)
                            <div class="form-group col-md-6">
                                @if($request->confirmed == -1)
                                    <label for="who">Odrzucony przez:</label>
                                @else
                                    <label for="who">Przyjęty przez:</label>
                                @endif
                                <input type='text' id='who' class="form-control" value="{{$users->where('id', $request->who_conf)->first()->name}}" readonly/>
                            </div>
                        @elseif(Gate::allows('admin'))
                            <div class="row col-md-6 text-center">
                                <div class="col-md-6"><label style="opacity: 0; visibility: hidden;">label</label><br/><button type='button' class="btn btn-danger" data-toggle="modal" data-target="#deny">Odrzuć</button></div>
                                <div class="col-md-6"><label style="opacity: 0; visibility: hidden;">label</label><br/><button type='button' class="btn btn-success" data-toggle="modal" data-target="#allow">Przyjmij</button></div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer text-center">
                    {{date('d-m-Y H:i:s', strtotime($request->created_at))}}
                </div>
            </form>
        </div>
        <div class="row col">
            <a href="{{ session('url') ?? URL::previous() }}" class="btn btn-primary mt-3">Cofnij</a>
            @if($request->confirmed == 0)
                    <button type='submit' class='btn btn-success ml-2 mt-3' form='form'>Zapisz</button>
            @endif
        </div>
    </div>


     <!-- deny modal -->
     <div class="modal" tabindex="-1" role="dialog" id='deny'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Odrzucić wniosek?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                Czy na pewno chcesz odrzucić ten wniosek?
            </div>
            <div class="modal-footer">
                <div class="row mr-1">
                    <button class='btn btn-primary' data-dismiss="modal" aria-label="Close">Zamknij</button>
                    <button type='submit' class='btn btn-danger ml-2' form='form' name='status' value="deny">Odrzuć</button>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- allow modal -->
    <div class="modal" tabindex="-1" role="dialog" id='allow'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Przyjąć wniosek?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                Czy na pewno chcesz przyjąć ten wniosek?<br/>
                <span style='text-decoration: underline;'>UWAGA!</span><br/>
                Spowoduje to usunięcie wszystkich pozostałych wniosków pokrywajacych się z tym terminem.
            </div>
            <div class="modal-footer">
                <div class="row mr-1">
                    <button class='btn btn-primary' data-dismiss="modal" aria-label="Close">Zamknij</button>
                    <button type='submit' class='btn btn-success ml-2' form='form' name='status' value="allow">Przyjmij</button>
                </div>
            </div>
            </div>
        </div>
    </div>


    <!-- double modal -->
    @if(session('double'))
        <div class="modal" tabindex="-1" role="dialog" id='alert'>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alert!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(session('double') === 'proposal')
                        <div class='alert alert-primary'>Istnieje wniosek o urlop, który się pokrywa z twoim, czy pomimo tego zmienić wniosek?</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Popraw</button>
                    @if(session('double') === 'proposal')
                        <button type='submit' class='btn btn-success' form='form' name='double' value="true">Wyślij</button>
                    @endif
                </div>
                </div>
            </div>
        </div>
    @endif
@endsection
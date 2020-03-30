
@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" class="mt-2 mr-5">
            <div style="position: absolute; top: 0; right: 0; z-index:2;">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" type='info' data-delay="3000" style="min-width:15rem;">
                    <div class="toast-header text-white" style='background-color: #d30303;'>
                        <strong class="mr-auto">Błąd!</strong>
                    </div>
                    <div class="toast-body">
                        {{ $error }}
                    </div>
            </div>
        </div>
    @endforeach
@endif

@if(session('success'))
    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" class="mt-2">
        <div style="position: absolute; top: 0; right: 0; z-index:2;">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" type='info' data-delay="3000" style="min-width:15rem;">
                <div class="toast-header text-white" style='background-color: #00991e;'>
                    <strong class="mr-auto">Gratulacje!</strong>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
        </div>
    </div>
@endif

@if(session('failed'))
    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" class="mt-2">
        <div style="position: absolute; top: 0; right: 0; z-index:2;">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" type='info' data-delay="3000" style="min-width:15rem;">
                <div class="toast-header text-white" style='background-color: #d30303;'>
                    <strong class="mr-auto">Błąd!</strong>
                </div>
                <div class="toast-body">
                    {{ session('failed') }}
                </div>
        </div>
    </div>
@endif
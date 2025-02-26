{{-- Page Loader Types --}}

{{-- Spinner Message --}}
@if (config('layout.page-loader.type') == 'spinner-message')
    <div class="loading-screen">
        <div class="loading d-flex justify-content-center">
            <div class="d-flex loading-block">
                <span>Vui lòng chờ...</span>
                <span><div class="spinner-border text-primary"></div></span>
            </div>
        </div>
    </div>
@endif

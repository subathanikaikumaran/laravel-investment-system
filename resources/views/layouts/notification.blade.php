<script src="{{ asset('plugins/js/sweetalert.min.js') }}"></script>
@if ($message = Session::get('success'))
<script>
    swal({
        title: "Success",
        text: "{{ $message }}",
        icon: "success",
        // timer: 10000,
        button: "Ok"
    });
</script>
<!-- <div class="notifi-message">
    <span>
        <div class="notifi-message-notice">
            <div class="notifi-message-notice-content">
                <div class="notifi-message-custom-content notifi-message-success">
                    <span role="img" aria-label="check-circle" class="anticon anticon-check-circle">
                        <svg viewBox="64 64 896 896" focusable="false" class="" data-icon="check-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                            <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm193.5 301.7l-210.6 292a31.8 31.8 0 01-51.7 0L318.5 484.9c-3.8-5.3 0-12.7 6.5-12.7h46.9c10.2 0 19.9 4.9 25.9 13.3l71.2 98.8 157.2-218c6-8.3 15.6-13.3 25.9-13.3H699c6.5 0 10.3 7.4 6.5 12.7z"></path>
                        </svg>
                    </span>
                    <span>{{ $message }}</span>
                </div>
            </div>
        </div>
    </span>
</div> -->
@endif

@if ($cerror = Session::get('error'))
<script>
    swal({
        title: "Error!",
        text: "{{ $cerror }}",
        icon: "error",
        // timer: 10000,
        button: "Ok"
    });
</script>
<!-- <div class="notifi-message"><span>
        <div class="notifi-message-notice">
            <div class="notifi-message-notice-content">
                <div class="notifi-message-custom-content notifi-message-error">
                    <span role="img" aria-label="close-circle" class="anticon anticon-close-circle">
                        <svg viewBox="64 64 896 896" focusable="false" class="" data-icon="close-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                            <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 01-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path>
                        </svg>
                    </span>
                    <span>Error! - {{ $cerror }}</span>
                </div>
            </div>
        </div>
    </span>
</div> -->
@endif



@if (count($errors) > 0)
<div class="notifi-message"><span>
        <div class="notifi-message-notice">
            <div class="notifi-message-notice-content">
                <div class="notifi-message-custom-content notifi-message-error">
                    <span role="img" aria-label="close-circle" class="anticon anticon-close-circle">
                        <svg viewBox="64 64 896 896" focusable="false" class="" data-icon="close-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                            <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 01-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"></path>
                        </svg>
                    </span>
                    <span>
                        @foreach ($errors->all() as $error)
                        {{ $error }}
                        @endforeach
                    </span>
                </div>
            </div>
        </div>
    </span>
</div>
@endif
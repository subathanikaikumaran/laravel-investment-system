<script src="{{ asset('plugins/js/sweetalert.min.js') }}"></script>

<script>
    function cancelConfirmation(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        swal({
                title: "Are you sure?",
                text: "Do you want to cancel the process?",
                icon: "warning",
                timer: 30000,
                buttons: {
                    confirm: 'Yes',
                    cancel: 'No'
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = urlToRedirect;
                }
            });
    }


    function confirmationStatus(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        swal({
                title: "Are you sure?",
                text: "Do you want to change the status?",
                icon: "warning",
                timer: 30000,
                buttons: {
                    confirm: 'Yes',
                    cancel: 'No'
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = urlToRedirect;
                }
            });
    }
</script>
<!-- JAVASCRIPT -->
<script src="{{ asset('ui/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('ui/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('ui/js/custom.min.js') }}"></script>
<script src="{{ asset('ui/js/dlabnav-init.js') }}"></script>
<script src="{{ asset('ui/js/demo.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
<!-- Datatable -->
<script src="{{ asset('ui/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('ui/js/plugins-init/datatables.init.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    })

    $(document).ready(function() {
        $('.select2').select2({})
    })
    //-- Loader
    $(document).ready(function() {
        $('.loader').remove();
        $('#userTable').removeClass('d-none');
        $('#HistoryTable').removeClass('d-none');
        $('#departementTable').removeClass('d-none');
    })
    //-- End Loader


    //-- DataTables
    $(function() {
        bsCustomFileInput.init();
        //Initialize Select2 Elements
        $('.select2').select2()

        $("#userTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
        })

        $('#departementTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true
        });

        $('#HistoryTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true
        });
    })
    //-- End DataTables

    $("#checkbox").click(function() {
        if ($("#checkbox").is(':checked')) {
            $("#e1 > option").prop("selected", "selected");
            $("#e1").trigger("change");
        } else {
            $("#e1 > option").removeAttr("selected");
            $("#e1").val("");
            $("#e1").trigger("change");
        }
    });

    function detailModal(title, url, width) {
        $.confirm({
            title: title,
            theme: 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'URL:' + url,
            animation: 'zoom',
            closeAnimation: 'scale',
            animationSpeed: 400,
            closeIcon: true,
            columnClass: width,
            buttons: {
                close: {
                    btnClass: 'btn-dark font-bold',
                }
            },
        });
    }

    function modalDelete(title, name, url, link) {
        $.confirm({
            title: `Delete ${title}?`,
            content: `Are you sure want to delete ${name}`,
            autoClose: 'cancel|8000',
            buttons: {
                delete: {
                    text: 'delete',
                    action: function() {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_method": 'delete',
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                window.location.href = link
                                console.log(data);
                            },
                            error: function(data) {
                                // $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function() {

                }
            }
        });
    }

    function logout() {
        $.confirm({
            icon: 'fas fa-sign-out-alt',
            title: 'Logout',
            theme: 'supervan',
            content: 'Are you sure want to logout?',
            autoClose: 'cancel|8000',
            buttons: {
                logout: {
                    text: 'logout',
                    action: function() {
                        $.ajax({
                            type: 'POST',
                            url: '/logout',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                location.reload();
                            },
                            error: function(data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function() {

                }
            }
        });
    }



    document.getElementById('submit-link').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the link
        document.getElementById('my-form').submit(); // Submit the form
    });
</script>

@stack('script')

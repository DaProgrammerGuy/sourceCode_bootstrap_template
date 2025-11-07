<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbAdmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- PLUGINS CSS (CDNs) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/css/dropify.min.css" rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/css/tempusdominus-bootstrap-4.min.css"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbAdmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <x-sidebar />
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <x-topbar />
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <x-footer />
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbAdmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbAdmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbAdmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbAdmin2/js/sb-admin-2.min.js') }}"></script>
    <!-- ... rest of body ... -->

    <!-- PLUGINS JS (CDNs) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/js/tempusdominus-bootstrap-4.min.js">
    </script>

    <!-- ONLY RUN ON FORM PAGES -->
@hasSection('form-plugins')
<script>
    window.addEventListener('load', function () {
        // SELECT2
        $('.select2').each(function () {
            var $el = $(this);
            var placeholder = $el.data('placeholder') || 'Select an option';

            $el.select2({
                placeholder: placeholder,
                allowClear: true,
                width: '100%',
                theme: 'default'
            });

            setTimeout(function () {
                var val = $el.val();
                if (val) $el.val(val).trigger('change.select2');
            }, 50);
        });

        // DROPIFY - SMALL & NO CSS
        $('.dropify').dropify({
            messages: {
                'default': 'Click or drop',
                'replace': 'Replace',
                'remove':  '×',
                'error':   'Error'
            },
            height: 90  // ← small height
        });

        // DATETIMEPICKER
        $('.datetimepicker').datetimepicker({ format: 'YYYY-MM-DD' });
        $('.timepicker').datetimepicker({ format: 'LT' });
    });

    $(document).ready(function () {
        // Handle subcategory loading on any page where the selects exist
        $(document).on('change', 'select[name="main_category_id"]', function () {
            var mainCategoryId = $(this).val();
            var subCategorySelect = $('select[name="sub_category_id"]');

            subCategorySelect.empty();
            subCategorySelect.append('<option value="">Select Sub Category</option>');

            if (mainCategoryId) {
                $.ajax({
                    url: '/get-subcategories/' + mainCategoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (key, subcat) {
                            subCategorySelect.append('<option value="' + subcat.id + '">' + subcat.name + '</option>');
                        });

                        // Reinitialize Select2 (if used)
                        if ($.fn.select2) {
                            subCategorySelect.select2();
                        }
                    },
                    error: function () {
                        alert('Error loading subcategories');
                    }
                });
            }
        });
    });
    // Handle delete confirmation modal (for courses and other resources)
    $(document).on('click', '.delete-btn', function() {
        var itemId = $(this).data('id');
        var itemTitle = $(this).data('title');
        var deleteUrl = $(this).data('url') || window.location.pathname.split('/').slice(0, -1).join('/') + '/' + itemId;
        
        // If data-url is not provided, construct it from current route
        if (!$(this).data('url')) {
            var baseUrl = window.location.origin;
            var path = window.location.pathname.split('/')[1]; // Get 'courses' from '/courses'
            deleteUrl = baseUrl + '/' + path + '/' + itemId;
        }
        
        // Set the item title in modal
        $('#courseTitle').text(itemTitle);
        
        // Set the form action
        $('#deleteForm').attr('action', deleteUrl);
        
        // Show the modal
        $('#deleteModal').modal('show');
    });
</script>
@yield('form-plugins')
@endif

    @stack('scripts')
</body>

</html>

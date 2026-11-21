    <!-- Feather Icon JS -->
    <script src = "{{URL::asset('build/js/feather.min.js')}}"></script>

	<!-- Simplebar JS -->
	<script src="{{URL::asset('build/plugins/simplebar/simplebar.min.js')}}"></script>

@if (!Route::is(['signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3' , 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3'
, 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'error-404', 'error-500','coming-soon','under-maintenance', 'success', 'success-2', 'success-3']))
    <!-- Datatable JS -->
    <script src="{{URL::asset('build/js/datatable.js')}}"></script>

    <!-- Datetimepicker JS -->
    <script src="{{URL::asset('build/plugins/flatpickr/flatpickr.min.js')}}"></script>
@endif

@if (Route::is(['chat', 'file-manager', 'notes', 'pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5', 'product-details', 'social-feed', 'video-call']))
    <!-- Swiper JS -->
    <script src="{{URL::asset('build/plugins/swiper/swiper-bundle.min.js')}}"></script>
@endif

    <!-- Bootstrap Core JS -->
    <script src="{{URL::asset('build/js/bootstrap.bundle.min.js')}}"></script>

@if (!Route::is(['signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3' , 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3'
, 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'error-404', 'error-500','coming-soon','under-maintenance', 'success', 'success-2', 'success-3']))
    <!-- Quill JS -->
    <script src="{{URL::asset('build/plugins/quill/quill.min.js')}}"></script>
@endif

@if (Route::is(['chart-c3']))
    <!-- Chart c3 JS -->
    <script src="{{URL::asset('build/plugins/c3-chart/d3.v5.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/c3-chart/c3.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/c3-chart/chart-data.js')}}"></script>
@endif

@if (Route::is(['form-fileupload']))
    <!-- Fileupload JS -->
    <script src="{{URL::asset('build/plugins/dropzone/dropzone-min.js')}}"></script>
    <script src="{{URL::asset('build/js/form-fileupload.js')}}"></script>
@endif

@if (Route::is(['form-mask']))
    <!-- Mask JS -->
    <script src="{{URL::asset('build/plugins/imask/js/imask.min.js')}}"></script>
    <script src="{{URL::asset('build/js/mask.js')}}"></script>
@endif

@if (Route::is(['chart-flot']))
    <!-- Chart flot JS -->
    <script src="{{URL::asset('build/plugins/flot/chart-data.js')}}"></script>
@endif

@if (Route::is(['chart-js', 'dashboard', 'index', 'layout-boxed', 'layout-dark', 'layout-detached', 'layout-horizontal', 'layout-hovered', 'layout-rtl', 'layout-two-column', 'subscription']))
    <!-- Chart JS -->
    <script src="{{URL::asset('build/plugins/chartjs/chart.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/chartjs/chart-data.js')}}"></script>
@endif

@if (Route::is(['chart-morris']))
    <!-- Chart JS -->
    <script src="{{URL::asset('build/plugins/morris/chart-data.js')}}"></script>
@endif

@if (Route::is(['chart-peity', 'dashboard', 'subscription']))
    <!-- Chart JS -->
    <script src="{{URL::asset('build/js/peity.js')}}"></script>
    <script src="{{URL::asset('build/plugins/peity/chart-data.js')}}"></script>
@endif

@if (Route::is(['calendar']))
    <!-- Fullcalendar JS -->
    <script src="{{URL::asset('build/plugins/fullcalendar/index.global.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/fullcalendar/calendar-data.js')}}"></script>
@endif

@if (Route::is(['add-product', 'all-blog', 'blog-tag', 'domain', 'edit-product', 'email-reply', 'localization-settings', 'otp-settings', 'packages', 'product-list', 'purchase-transaction', 'reviews', 'subscription', 'varriant-attributes']))
    <!-- Bootstrap Tagsinput JS -->
    <script src="{{URL::asset('build/js/tagsinput.js')}}"></script>
@endif

@if (Route::is(['admin-dashboard', 'barcode', 'calendar', 'chart-apex', 'companies', 'email-reply', 'dashboard', 'email', 'file-manager', 'form-elements', 'icon-feather', 'icon-flag', 'icon-fontawesome', 'icon-ionic', 'icon-material', 'icon-pe7', 'icon-remix', 'icon-simpleline', 'icon-tabler', 'icon-themify', 'icon-typicon', 'icon-weather', 'index', 'layout-boxed', 'layout-dark', 'layout-detached', 'layout-horizontal', 'layout-hovered', 'layout-rtl', 'layout-two-column', 'notes', 'pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5', 'qrcode', 'sales-dashboard', 'todo-list', 'todo']))
    <!-- Chart Apex JS -->
    <script src="{{URL::asset('build/plugins/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/apexchart/chart-data.js')}}"></script>
@endif

@if (Route::is(['sales-dashboard']))
    <!-- Map JS -->
    <script src="{{URL::asset('build/plugins/jsvectormap/js/jsvectormap.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/jsvectormap/js/world.js')}}"></script>
    <script src="{{URL::asset('build/js/jvectormap.js')}}"></script>
@endif

@if (!Route::is(['signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3' , 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3'
, 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'error-404', 'error-500','coming-soon','under-maintenance', 'success', 'success-2', 'success-3']))
    <!-- Select2 JS -->
    <script src="{{URL::asset('build/plugins/tom-select/js/tom-select.complete.min.js')}}"></script>
@endif

@if (Route::is(['billers', 'blog-comments', 'chat', 'contacts', 'customers', 'expired-products', 'security-settings', 'warehouse', 'form-mask']))
    <!-- Mobile Input -->
    <script src="{{URL::asset('build/plugins/intltelinput/js/intlTelInput.js')}}"></script>
@endif

@if (Route::is(['chat', 'email-reply', 'social-feed', 'search-list']))
    <!-- FancyBox JS -->
    <script src="{{URL::asset('build/plugins/fancybox/fancybox.umd.min.js')}}"></script>
@endif

@if (Route::is(['file-manager']))
    <!-- Player JS -->
    <script src="{{URL::asset('build/js/plyr-js.js')}}"></script>
@endif

@if (Route::is(['ui-drag-drop', 'ui-clipboard', 'projects', 'search-list']))
    <!-- Drag Card -->
    <script src="{{URL::asset('build/plugins/dragula/dragula.min.js')}}"></script>
    <script src="{{URL::asset('build/js/dragula.js')}}"></script>
@endif

@if (Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))
    <!-- Calculator JS -->
    <script src="{{URL::asset('build/js/calculator.js')}}"></script>
@endif

@if (Route::is(['ui-lightbox']))
    <!-- Lightbox JS -->
    <script src="{{URL::asset('build/plugins/lightbox/glightbox.min.js')}}"></script>
    <script src="{{URL::asset('build/plugins/lightbox/lightbox.js')}}"></script>
@endif

@if (Route::is(['ui-modals']))
    <!-- Modal JS -->
    <script src="{{URL::asset('build/js/modal.js')}}"></script>
@endif

@if (Route::is(['all-blog', 'blog-categories', 'blog-tag', 'best-seller', 'calendar', 'companies', 'customer-due-report', 'customer-report', 'dashboard', 'expense-report', 'form-pickers', 'income-report', 'index', 'inventory-report', 'invoice-report', 'layout-boxed', 'layout-dark', 'layout-detached', 'layout-rtl', 'layout-horizontal', 'layout-two-column', 'layout-hovered', 'notes', 'pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5', 'product-expiry-report', 'product-quantity-alert', 'product-report', 'profit-and-loss', 'projects', 'purchase-report', 'sales-dashboard', 'sales-report', 'sales-tax', 'search-list', 'sold-stock', 'stock-history', 'supplier-due-report', 'supplier-report', 'tax-reports', 'todo-list', 'todo']))
    <!-- Daterangepicker JS -->
    <script src="{{URL::asset('build/js/daterangepicker.js')}}"></script>
@endif

@if (Route::is(['ui-clipboard']))
    <!-- Clipboard JS -->
    <script src="{{URL::asset('build/plugins/clipboard/clipboard.min.js')}}"></script>
@endif

@if (Route::is(['ui-sweetalerts']))
	<!-- Sweet Alerts js -->
	<script src="{{URL::asset('build/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
	<script src="{{URL::asset('build/js/sweetalerts.js')}}"></script>
@endif

@if (Route::is(['form-select', 'form-select2', 'form-pickers']))
    <!-- Custom Select JS -->
    <script src="{{URL::asset('build/js/custom-tomselect.js')}}"></script>
@endif

@if (Route::is(['form-wizard']))
    <!-- Wizard JS -->
    <script src="{{URL::asset('build/plugins/vanilla-wizard/js/wizard.min.js')}}"></script>
    <script src="{{URL::asset('build/js/form-wizard.js')}}"></script>
@endif

@if (Route::is(['form-pickers']))
    <!-- Form Date PIckers JS -->
    <script src="{{URL::asset('build/plugins/flatpickr/flatpickr.js')}}"></script>
    <script src="{{URL::asset('build/js/forms-pickers.js')}}"></script>
@endif

@if (Route::is(['security-settings']))
    <!-- Validation-->
    <script src="{{URL::asset('build/js/validation.js')}}"></script>
@endif

@if (Route::is(['chat', 'video-call']))
    <!-- Validation-->
    <script src="{{URL::asset('build/js/chat.js')}}"></script>
@endif

    <script src = "{{URL::asset('build/js/script.js')}}"></script>

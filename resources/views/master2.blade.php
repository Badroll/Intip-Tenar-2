<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link rel="icon" href="{!! url("assets/logo-main-imigrasi.png")  !!}" type="image/x-icon">
    <title>INTIP RUDIMARANG</title>

    <!-- year month picker -->
    <!-- <script type="text/javascript" src="{!! url('/') !!}/lib/monthPicker/jquery.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/monthPicker/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="{!! url('/') !!}/lib/monthPicker/jquery-ui.css"></script>
    <script type="text/javascript">
        $(function() {
            $('.date-picker-cstm').datepicker(
                {
                    dateFormat: "yy-mm",
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    onClose: function(dateText, inst) {


                        function isDonePressed(){
                            return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
                        }

                        if (isDonePressed()){
                            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                            $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');
                            
                             $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
                        }
                    },
                    beforeShow : function(input, inst) {

                        inst.dpDiv.addClass('month_year_datepicker')

                        if ((datestr = $(this).val()).length > 0) {
                            year = datestr.substring(datestr.length-4, datestr.length);
                            month = datestr.substring(0, 2);
                            $(this).datepicker('option', 'defaultDate', new Date(year, month-1, 1));
                            $(this).datepicker('setDate', new Date(year, month-1, 1));
                            $(".ui-datepicker-calendar").hide();
                        }
                    }
                })
        });
    </script>
    <style>
    .ui-datepicker-calendar {
        display: none;
    }
    </style> -->

    <!-- Global stylesheets -->
    <!--link href="{!! url('/') !!}/lib/css/css.css" rel="stylesheet" type="text/css"-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{!! url('/') !!}/lib/css/icons/icomoon/styles.css?t={{ date('YmdHis') }}" rel="stylesheet" type="text/css">

    <link href="{!! url('/') !!}/lib/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{!! url('/') !!}/lib/css/minified/core.min.css" rel="stylesheet" type="text/css">
    <link href="{!! url('/') !!}/lib/css/minified/components.min.css" rel="stylesheet" type="text/css">
    <link href="{!! url('/') !!}/lib/css/minified/colors.min.css" rel="stylesheet" type="text/css">

    <!-- <link href="{!! url('/') !!}/lib/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="{!! url('/') !!}/lib/css/core.css" rel="stylesheet" type="text/css">
    <link href="{!! url('/') !!}/lib/css/components.css" rel="stylesheet" type="text/css">
    <link href="{!! url('/') !!}/lib/css/colors.css" rel="stylesheet" type="text/css"> -->

    <link href="{!! url('/') !!}/lib/css/extras/animate.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Plugins stylesheets -->
    <link rel="stylesheet" type="text/css" href="{!! url('/') !!}/lib/js/plugins/sweetalert/sweetalert.css">
    <!-- 
    <link rel="stylesheet" type="text/css" href="{!! url('/') !!}/lib/js/plugins/datatables/dataTables.bootstrap.css"> -->

    <!-- /Plugins stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->

    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/core/app.js"></script>
    <!-- 
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/pages/datatables_basic.js"></script> -->

    <!-- <script type="text/javascript" src="{!! url('/') !!}/lib/js/datatables.min.js"></script> -->
    
    <!-- /theme JS files -->

    <!-- JS Plugins files -->


    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/notifications/pnotify.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/notifications/noty.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/pages/components_notifications_pnotify.js"></script>

    <script type="text/javascript" src="{{ url('/') }}/lib/js/plugins/toastr/toastr.js"></script>
    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/lib/js/plugins/toastr/toastr.css" />  

    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/autoNumeric.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/pages/form_inputs.js"></script>

    <!-- datepicker -->
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/core/libraries/jquery_ui/datepicker.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/core/libraries/jquery_ui/effects.min.js"></script>

    <!-- daterangepicker -->
    <link rel="stylesheet" type="text/css" href="{!! url('/') !!}/lib/js/plugins/pickers/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/pickers/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/pickers/daterangepicker/daterangepicker.js"></script>
    
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/custom.js"></script>
    <!-- /JS Plugins files -->
    <script type="text/javascript">
        // here
    </script>

    <!-- iOS overlay -->
    <script src="{!! url('/') !!}/lib/js/plugins/overlay/iosOverlay.js"></script>
    <script src="{!! url('/') !!}/lib/js/plugins/overlay/spin.min.js"></script>
    <link rel="stylesheet" href="{!! url('/') !!}/lib/js/plugins/overlay/iosOverlay.css">
    <script src="{!! url('/') !!}/lib/js/plugins/overlay/modernizr-2.0.6.min.js"></script>

    <link rel="stylesheet" type="text/css" media="screen" href="{!! url('/') !!}/lib/monthPicker2/datepicker.min.css"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/monthPicker2/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/monthPicker2/bootstrap-datepicker.id.js"></script>

    <script type="text/javascript" src="{!! url('/') !!}/lib/js/plugins/visualization/echarts/echarts.js"></script>
    <script type="text/javascript" src="{!! url('/') !!}/lib/js/charts/echarts/timeline_option.js"></script>

    <script type="text/javascript">
        // here
    </script>

    @yield('style')
    <style type="text/css">
        label.error {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            padding: 5px;
        }
        .datatable-basic > thead > tr > th {
            padding: 6px 6px;
        }
        .datatable-basic > tbody > tr > td {
            padding: 6px 6px;
        }
    </style>

</head>

<body class="default">

    <!-- Main navbar -->
    @include('topnav2')
    <!-- /main navbar -->


    <!-- Page container -->
    <div style="margin: -12px -12px ">
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">

                    @yield('content')
                    

                    <!-- Footer -->
                    
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    </div>
    <!-- /page container -->

    <div class=" text-muted" align="center" style="margin-top: -40px !important;">
        &copy;{{ date("Y") . " Rumah Detensi Imigrasi Semarang" }}
    </div>

    <script type="text/javascript">
        var gUserMode = false;

        $(document).ready(function(){

            // $(window).resize(function() { 
            //     delayReload(100);
            // });

            // $.extend( $.fn.dataTable.defaults, {
            //     autoWidth: false,        
            //     /*
            //     columnDefs: [{ 
            //         orderable: false,
            //         width: '80px',
            //         targets: [ 3 ]
            //     }],*/
            //     dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            //     language: {
            //         search: '<span>Cari &nbsp;</span> _INPUT_',
            //         lengthMenu: '<span>Tampil &nbsp;</span> _MENU_',
            //         paginate: { 'first': 'Awal', 'last': 'Akhir', 'next': '&rarr;', 'previous': '&larr;' }
            //     },
            //     drawCallback: function () {
            //         $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            //     },
            //     preDrawCallback: function() {
            //         $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            //     }
            // });

            // // Datatable with saving state
            /*
            $('.datatable-basic').DataTable({
                "order": [[ 1, "desc" ]],
                scrollY:        true,
                scrollX:        true,
                scrollCollapse: true,
                paging:         true,
                fixedColumns:   {
                  leftColumns: 1,
                  rightColumns: 0
                }
            });
            */


            // // External table additions
            // // ------------------------------
            // // Add placeholder to the datatable filter option
            // $('.dataTables_filter input[type=search]').attr('placeholder','Kata kunci...');

            // // Enable Select2 select for the length option
            // $('.dataTables_length select').select2({
            //     minimumResultsForSearch: "-1"
            // });   


            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,        
                
                // columnDefs: [{ 
                //     orderable: false,
                //     width: '80px',
                //     targets: [ 3]
                // }],
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Cari &nbsp;</span> _INPUT_',
                    lengthMenu: '<span>Tampil &nbsp;</span> _MENU_',
                    paginate: { 'first': 'Awal', 'last': 'Akhir', 'next': '&rarr;', 'previous': '&larr;' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });
            // Datatable with saving state
            $('.datatable-basic').DataTable({
                scrollY: true
                ,scrollX: true
                //,"order": [[ (typeof(gOrder) == "undefined") ? 0 : gOrder, "asc" ]]
                ,ordering: false
            });

            // External table additions
            // ------------------------------
            // Add placeholder to the datatable filter option
            $('.dataTables_filter input[type=search]').attr('placeholder','Kata kunci...');

            // Enable Select2 select for the length option
            $('.dataTables_length select').select2({
                minimumResultsForSearch: "-1"
            }); 

            $("#liCollapse").click(function() {
                var table = $('.datatable-basic').DataTable();

                table.columns.adjust().draw();
            });


            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };

            $(".force-number").inputFilter(function(value) {
                return /^-?\d*(\.\d+)?$/.test(value);
            });

            $(".month-picker").datepicker({
                format: "yyyy-MM",
                minViewMode: 1,
                autoclose: true,
                language: 'id'
            });

            toastr.options = {
                "closeButton": true,
                "debug": true,
                "positionClass": "toast-bottom-full-width",
                "onclick": null,
                "showDuration": "5000",
                "hideDuration": "5000",
                "timeOut": "5000",
                "extendedTimeOut": "5000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "slideDown",
                "hideMethod": "slideUp"
            }

            //autonumeric
                $(".numeric-input").autoNumeric({aSep: '.', aDec: ',', aSign: 'USD '});
                $(".numeric-input-idr").autoNumeric({aSep: ',', aDec: '.', aSign: 'Rp '});
                $(".numeric-input-no-sign").autoNumeric('init', {mDec: '0'});
                $(".numeric-input-no-sign-decimal").autoNumeric({aSep: ',', aDec: '.', aSign: '', mDec: 2});
                $(".numeric-input-allow-negative").autoNumeric({aSep: '.', aDec: ',', aSign: 'USD. ', vMin: '-999999999'});
                $(".numeric-input-allow-negative-idr").autoNumeric({aSep: '.', aDec: ',', aSign: 'IDR. ', vMin: '-999999999'});
                $(".numeric-input-no-sign-allow-negative-decimal").autoNumeric({aSep: '.', aDec: ',', vMin: '-999999999'});
                $(".numeric-input-no-sign-allow-negative").autoNumeric('init', {mDec: '0', vMin: '-999999999'});
            //------------

            @if(Session::has('error'))
                notify("e", "{!! Session::get('error') !!}");
                @php
                    Session::forget('error');
                @endphp
            @endif
            @if(Session::has('message'))
                notify("s", "{!! Session::get('message') !!}");
                @php
                    Session::forget('message');
                @endphp
            @endif
            @if(Session::has('info'))
                notify("i", "{!! Session::get('info') !!}");
                @php
                    Session::forget('info');
                @endphp
            @endif
            @if(Session::has('warning'))
                notify("w", "{!! Session::get('warning') !!}");
                @php
                    Session::forget('warning');
                @endphp
            @endif

            $('.select').select2();


            $("input").focusout(function(){
                var id = this.id;
                var str = parseToJson(this.value);
                $("#"+id).val(str);
            });

        });

        var echartGrid = {
            x: 80,
            x2: 80,
            y: 60,
            y2: 50
        };

        var url = "{{ url('/') }}";
        var gEchartResources = '/lib/js/plugins/visualization/echarts';
        if(url.includes('/public')){
            gEchartResources = '/{{ env("APP_MAIN_URL", "-") }}/public/lib/js/plugins/visualization/echarts';
        }


        function notify(typ, msg){
            var t = "information";
            if(typ == "s")  t = "success";
            else if(typ == "w")  t = "warning";
            else if(typ == "e")  t = "error";

            noty({
                width: 200,
                text: msg,
                type: t,
                dismissQueue: true,
                timeout: 4000,
                layout: "topRight",
                buttons: (t != 'confirm') ? false : [
                    {
                        addClass: 'btn btn-primary btn-xs',
                        text: 'Ok',
                        onClick: function ($noty) {
                            $noty.close();
                            noty({
                                force: true,
                                text: 'You clicked "Ok" button',
                                type: 'success',
                                layout: "topRight"
                            });
                        }
                    },
                    {
                        addClass: 'btn btn-danger btn-xs',
                        text: 'Cancel',
                        onClick: function ($noty) {
                            $noty.close();
                            noty({
                                force: true,
                                text: 'You clicked "Cancel" button',
                                type: 'error',
                                layout: "topRight"
                            });
                        }
                    }
                ]
            });
        }


        function createOverlay(screenText) {
            var target = document.createElement("div");
            document.body.appendChild(target);
            var opts = {
                lines: 13, // The number of lines to draw
                length: 11, // The length of each line
                width: 5, // The line thickness
                radius: 17, // The radius of the inner circle
                corners: 1, // Corner roundness (0..1)
                rotate: 0, // The rotation offset
                color: '#FFF', // #rgb or #rrggbb
                speed: 1, // Rounds per second
                trail: 60, // Afterglow percentage
                shadow: false, // Whether to render a shadow
                hwaccel: false, // Whether to use hardware acceleration
                className: 'spinner', // The CSS class to assign to the spinner
                zIndex: 2e9, // The z-index (defaults to 2000000000)
                top: 'auto', // Top position relative to parent in px
                left: 'auto' // Left position relative to parent in px
            };
            var spinner = new Spinner(opts).spin(target);
            gOverlay = iosOverlay({
                text: screenText,
                /*duration: 2e3,*/
                spinner: spinner
            });
        }


        function bulanIndo(periode){
            var arrPeriode = periode.split("-");
            var arrBln = ["Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "November", "Desember"];
            return arrBln[parseInt(arrPeriode[1] - 1)] + " " + arrPeriode[0];
        }


        function summaryTrigger(arrId, totalId){
            var total = 0;
            for(i = 0; i < arrId.length; i++){
                var value = parseInt($("#"+arrId[i]).val());
                total += value;
            }
            $("#"+totalId).val(total);
        }


        function insertAtCaret(areaId, text) {
          var txtarea = document.getElementById(areaId);
          if (!txtarea) { return; }

          var scrollPos = txtarea.scrollTop;
          var strPos = 0;
          var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
            "ff" : (document.selection ? "ie" : false ) );
          if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart ('character', -txtarea.value.length);
            strPos = range.text.length;
          } else if (br == "ff") {
            strPos = txtarea.selectionStart;
          }

          var front = (txtarea.value).substring(0, strPos);
          var back = (txtarea.value).substring(strPos, txtarea.value.length);
          txtarea.value = front + text + back;
          strPos = strPos + text.length;
          if (br == "ie") {
            txtarea.focus();
            var ieRange = document.selection.createRange();
            ieRange.moveStart ('character', -txtarea.value.length);
            ieRange.moveStart ('character', strPos);
            ieRange.moveEnd ('character', 0);
            ieRange.select();
          } else if (br == "ff") {
            txtarea.selectionStart = strPos;
            txtarea.selectionEnd = strPos;
            txtarea.focus();
          }

          txtarea.scrollTop = scrollPos;
        }

        var gOverlay; 


        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }


        function checkIsInteger(id){
            var value = $("#"+id).val();
            var tryParse = parseInt(value);

            if(String(tryParse) === "NaN" || String(tryParse) === "undefined" || typeof(tryParse) == "undefined"){
                $("#"+id).val("");
                var label = " "
                label = " \"" + $("label[for="+id+"]").text() + "\" ";
                notify("e", "Harap isikan" + label + "dengan benar");
                return false;
            }
            return tryParse;
        }

        function preview(event, id) {
            var output = document.getElementById(id);
            output.src = URL.createObjectURL(event.target.files[0]);
        }

        function delayReload(time = 500){
            setTimeout(function(){
                window.location.reload(true);      
            }, 500);
        }


        function getCurrentDateLimit(){
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            var show_mm = parseInt(mm) - 1
            if(show_mm < 10){
                show_mm = "0" + show_mm;
            }

            return [yyyy + "-" + show_mm, "-"];
        }
        

        function getCurrentDate(){
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            return yyyy + "-" + mm + "-" + dd;
        }


        function parseToString(jsonString){ // saat render data dari controller
            return jsonString.replaceAll("&amp;", '&')
                            .replaceAll("&gt;", '>')
                            .replaceAll("&lt;", '<')
                            .replaceAll("&#039;", "'")
                            .replaceAll("&quot;", '"');
        }


        function parseToJson(str) {
            str = str.replaceAll(/\"/g, "'");
            str = str.replaceAll(/\t/g, ' ');
            str = str.replaceAll(/\\/g, '');

            str = str.toString().trim().replaceAll(/(\r\n|\n|\r)/g,"");
            return str;
        }


    </script>

    @yield('script')

</body>
</html>
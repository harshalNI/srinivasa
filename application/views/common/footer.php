<div class="footer">
                    <div>
                        <span style="float:right"> Design & Developed by <a href="http://www.nehainfosystems.com">NehaInfosystems</a></span>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url('assets');?>/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url('assets');?>/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/jeditable/jquery.jeditable.js"></script>

    

    <!-- Flot -->
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/flot/jquery.flot.pie.js"></script>

    <!-- Peity -->
    <script src="<?php echo base_url('assets');?>/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->

    <script src="<?php echo base_url('assets');?>/js/inspinia.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?php echo base_url('assets');?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- GITTER -->
    <script src="<?php echo base_url('assets');?>/js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- Sparkline -->
    <script src="<?php echo base_url('assets');?>/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="<?php echo base_url('assets');?>/js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="<?php echo base_url('assets');?>/js/plugins/chartJs/Chart.min.js"></script>

    <!-- Toastr -->
    <script src="<?php echo base_url('assets');?>/js/plugins/toastr/toastr.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/dataTables/datatables.min.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="<?php echo base_url('assets');?>/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <script>

        $(document).ready(function() {

            $(".cheque_return").click(function(){
                var payment_id = $(this).parent().parent().attr('id');
                //alert(payment_id);
                swal({
                    title: "Are you sure?",
                    text: "The cheque has been returned!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { payment_id: payment_id },
                        url: "<?php echo base_url('payment/ChequeReturn');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Cheque has been returned!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            $(".delete_payment").click(function(){
                var payment_id = $(this).parent().parent().attr('id');
                
                swal({
                    title: "Are you sure?",
                    text: "This will delete the payment record",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Confirm!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { payment_id: payment_id },
                        url: "<?php echo base_url('payment/DeletPayment');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Payment details has been deleted!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            $('#customerName1').change(function(){
                var cust_id = $(this).val();
                $.ajax({
                    type: "POST",
                    data: { cust_id: cust_id },
                    url: "<?php echo base_url('sales/getTotalCreditBalance');?>",
                    success: function(res) {
                      // Wme'll put some code here in a minute
                      //$('.dummy').hide();
                      if(res != ''){
                        var amt = res;
                        $('#advance').prop('disabled',true);
                        
                      }else{
                        var amt = 0;
                        $('#advance').prop('disabled',false);
                      }
                        $('#creditBalance').val(amt);

                    }
                  });
            });

            
            $('#customerName').change(function(){
                var cust_id = $(this).val();
                //alert(cust_id);
                $.ajax({
                    type: "POST",
                    data: { cust_id: cust_id },
                    url: "<?php echo base_url('sales/getTotalCreditBalance');?>",
                    success: function(res) {
                       // alert(res);//die();
                        var amt = res;
                        var result=amt.split('-');
                         //alert(result);die();
                         if(result[0] == 'Credit'){
                            $('#balAmt').val('');
                            $("#creditBalance").val(result[1]);
                            $("#oldcreditAmt").val(result[1]);
                            $('#advance').prop('disabled',true);
                            $("#payment_mode123").hide();
                         } else{
                            $("#creditBalance").val('');
                            $('#balAmt').val(result[1]);
                            $('#oldbalAmt').val(result[1]);
                            $('#advance').prop('disabled',false);
                            $("#payment_mode123").show();
                         } 
                    }
                  });
            });

            $('#viewdetails').click(function(){
                $('#paymentdetails').show();
            });
            $('#pay').click(function(){
                var cust_id = $(this).parent().parent().attr('id');
                $("#customer").val($("#customerName").val());
            });

            $('.pay').click(function(){
                var cust_id = $(this).parent().parent().parent().attr('id');
                var recpt = $(this).parent().parent().prev().prev().prev().prev().prev().prev().html();
                var exp_recpt = recpt.split('-');
                //alert(exp_recpt);
                $("#receipt_no").val(exp_recpt[1]);
                $("#customer").val(cust_id);
            });

            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
            $('#from_date .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
            $('#to_date .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
            $('#paid_date .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
            $('#date').click(function(){
                $('#date').hide();
                $('#data_1').show();
                $('#hide-date').show();
            });
            $('#hide-date').click(function(){
                $('#date').show();
                $('#data_1').hide();
                $('#hide-date').hide();
            });
            $('#paymentMode').change(function(){
                if($('#paymentMode').val() == 'cheque'){
                    $('#bankName').show();
                    $('#branchName').show();
                    $('#chequeNumber').show();
                }else{
                    $('#bankName').hide();
                    $('#branchName').hide();
                    $('#chequeNumber').hide();
                }
            });
            var count = 0;
            $("#addMore").click(function(){
                count += 1;
                $.ajax({
                    type: "POST",
                    data: { count: count },
                    url: "<?php echo base_url('sales/add-new-row');?>",
                    success: function(res) {
                       $('#container').append(res);

                       var categoryID = '#category-'+count;
                       var productID = '#product-'+count;
                       $(categoryID).change(function(){
                        var cat_id = $(this).val();
                            $.ajax({
                                type: "POST",
                                data: { cat_id: cat_id },
                                url: "<?php echo base_url('sales/GetAllProductsByCategory');?>",
                                success: function(res1) {
                                  // We'll put some code here in a minute
                                  //$('.dummy').hide();
                                    $(productID).html(res1);
                                }
                              });
                       });
                       //alert(count);
                       /* ratePerItem = "#ratePerItem-"+count;
                       $(ratePerItem).keyup(function(){
                            //var ratePerItem = "#ratePerItem-"+count;
                            var rate_per_item = $(ratePerItem).val();
                           // alert(rate_per_item);
                            var quantity = $("#quantity-"+count).val();
                            var total_price = quantity * rate_per_item;
                            $("#rate-"+count).val(total_price); 

                            var amount = $('#rate').val();
                            if(amt == ''){
                                amt = 0;
                            }else{
                                amt = amt;
                            }
                            var sum = 0;
                            $(".rate").each(function(){
                                sum += +$(this).val();
                            });
                            $("#totalAmount").val(sum);
                        });*/

                       $('.rate').keyup(function(){
                         var sum = 0;
                            $(".rate").each(function(){
                                sum += +$(this).val();
                            });
                            $("#totalAmount").val(sum);
                       });
                    }
                  });
    
            });

            amt = $('#totalAmount').val();

            $("#ratePerItem").keyup(function(){
                var rate_per_item = $("#ratePerItem").val();
                var quantity = $("#quantity").val();
                var total_price = quantity * rate_per_item;
                $("#rate").val(total_price); 

                var amount = $('.rate').val();
                if(amt == ''){
                    amt = 0;
                }else{
                    amt = amt;
                }
                var total = parseInt(amount) + parseInt(amt);
                $('#totalAmount').val(total);
            });

            $('.rate').keyup(function(){
                var sum = 0;
                $(".rate").each(function(){
                    sum += +$(this).val();
                });
                $("#totalAmount").val(sum);
            });
            $('#addNewRow').click(function(){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('sales/addnewrow');?>",
                    success: function(res) {
                      // We'll put some code here in a minute
                      //$('.dummy').hide();
                        $('#product').html(res);
                    }
                  });
            });
            $('#category').change(function(){
                var cat_id = $('#category').val();
                $.ajax({
                    type: "POST",
                    data: { cat_id: cat_id },
                    url: "<?php echo base_url('categories/GetAllProductsByCategory');?>",
                    success: function(res) {
                      // We'll put some code here in a minute
                      //$('.dummy').hide();
                        $('#product').html(res);
                    }
                  });
            });
            $("#advance").focusout(function(){
                var bal_amt = $("#balAmt").val();
                var old_bal_amt = $("#oldbalAmt").val();
                var amount = $("#totalAmount").val();
                var amount_paid = $("#advance").val();
                var balance = parseInt(old_bal_amt) + parseInt(amount);
                var new_bal = balance - parseInt(amount_paid);
                //alert(new_bal);

                //var balance = amount-amount_paid;
                $("#balAmt").val(new_bal);
            });

            $('#addNewProd').click(function(){
                $.ajax({
                type:'POST',
                data:$('form').serialize(),
                url:'<?php echo base_url("customer/product/add");?>',
                success:function(data) {
                  location.reload();
                }
              });
            });

            $('.deactivate_user').click(function () {
                var user_id = $(this).parent().parent().attr('id');
            swal({
                title: "Are you sure?",
                text: "This will deactivate the user!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Deactivate!",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type: "POST",
                    data: { user_id: user_id },
                    url: "<?php echo base_url('user/inactivate');?>",
                    success: function(res) {
                      // We'll put some code here in a minute
                      //$('.dummy').hide();
                     swal("User has been deactivated!", "", "success");
                     location.reload();
                    }
                  });
            });
        });
            $('.activate_user').click(function () {
                var user_id = $(this).parent().parent().attr('id');
            swal({
                title: "Are you sure?",
                text: "This will activate the user!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Activate!",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type: "POST",
                    data: { user_id: user_id },
                    url: "<?php echo base_url('user/activate');?>",
                    success: function(res) {
                      // We'll put some code here in a minute
                      //$('.dummy').hide();
                     swal("User has been activated!", "", "success");
                     location.reload();
                    }
                  });
            });
        });

            //Delete user
            $('.delete_user').click(function () {
                var user_id = $(this).parent().parent().attr('id');
            swal({
                title: "Are you sure?",
                text: "This will permanently delete the user!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete!",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type: "POST",
                    data: { user_id: user_id },
                    url: "<?php echo base_url('user/delete');?>",
                    success: function(res) {
                      // We'll put some code here in a minute
                      //$('.dummy').hide();
                     swal("User has been deleted!", "", "success");
                     location.reload();
                    }
                  });
            });
        });

            //Deactivate category
            $('.deactivate_category').click(function () {
                var category_id = $(this).parent().parent().attr('id');
            swal({
                title: "Are you sure?",
                text: "This will deactivate the category!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Deactivate!",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type: "POST",
                    data: { category_id: category_id },
                    url: "<?php echo base_url('category/inactivate');?>",
                    success: function(res) {
                      // We'll put some code here in a minute
                      //$('.dummy').hide();
                     swal("Category has been deactivated!", "", "success");
                     location.reload();
                    }
                  });
            });
        });
            //Activate category
            $('.activate_category').click(function () {
                var category_id = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will activate the category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Activate!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { category_id: category_id },
                        url: "<?php echo base_url('category/activate');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Category has been activated!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            //Delete Category
            $('.delete_category').click(function () {
                var category_id = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will permanently delete the category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Delete!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { category_id: category_id },
                        url: "<?php echo base_url('category/delete');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Category has been deleted!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            //Deactivate Product
            $('.deactivate_product').click(function () {
                var prod_id = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will deactivate the product!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Deactivate!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { prod_id: prod_id },
                        url: "<?php echo base_url('categories/product/deactivate');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Product has been Deactivated!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            //Activate Product
            $('.activate_product').click(function () {
                var prod_id = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will activate the product!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Activate!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { prod_id: prod_id },
                        url: "<?php echo base_url('categories/product/activate');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Product has been activated!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

             //Activate Product
            $('.delete_product').click(function () {
                var prod_id = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will permanently delete the product!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Delete!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { prod_id: prod_id },
                        url: "<?php echo base_url('categories/product/delete');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Product has been deleted!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            //Delete Customer
            $('.delete_customer').click(function () {
                var cust_id = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will permanently delete the customer!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Delete!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { cust_id: cust_id },
                        url: "<?php echo base_url('customers/delete');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Customer has been deleted!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            //Deactivate Branch
            $('.deactivate_branch').click(function () {
                var branch_id = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will deactivate the branch!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Deactivate!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { branch_id: branch_id },
                        url: "<?php echo base_url('branches/deactivate');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Branch has been Deactivated!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            //Activate Branch
            $('.activate_branch').click(function () {
                var branch_id = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will activate the branch!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Activate!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { branch_id: branch_id },
                        url: "<?php echo base_url('branches/activate');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Branch has been Activated!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            //Delete Branch
            $('.delete_branch').click(function () {
                var branch_id = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will permanently delete the branch!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Delete!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { branch_id: branch_id },
                        url: "<?php echo base_url('branches/delete');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Branch has been deleted!", "", "success");
                         location.reload();
                        }
                      });
                });
            });

            //Delete Sales
            $('.delete_sale').click(function () {
                var recpt_no = $(this).parent().parent().attr('id');
                swal({
                    title: "Are you sure?",
                    text: "This will permanently delete the sale!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Delete!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type: "POST",
                        data: { recpt_no: recpt_no },
                        url: "<?php echo base_url('sales/delete');?>",
                        success: function(res) {
                          // We'll put some code here in a minute
                          //$('.dummy').hide();
                         swal("Sale Transaction has been deleted!", "", "success");
                         location.reload();
                        }
                      });
                });
            });


        });
    </script>
    <script>
        $(document).ready(function() {
            /* Init DataTables */
            var oTable = $('#editable').DataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( '../example_ajax.php', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },

                "width": "90%",
                "height": "100%"
            } );

            $('.dataTables-example').DataTable({
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {
                        extend: 'print', 
                        title: 'report',
                        exportOptions: {
                            columns: "thead th:not(.noExport)"
                        }
                    },
                    {
                        extend: 'excel', 
                        title: 'report',
                        exportOptions: {
                            columns: "thead th:not(.noExport)"
                        }
                    },
                ]
                /*buttons: [
                    {extend: 'print', title: 'report'},
                    {extend: 'excel', title: 'report'},
                ]*/

            });

            var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

            $('.demo1').colorpicker();

            var data1 = [
                [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
            ];
            var data2 = [
                [0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
            ];
            $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                data1, data2
            ],
                    {
                        series: {
                            lines: {
                                show: false,
                                fill: true
                            },
                            splines: {
                                show: true,
                                tension: 0.4,
                                lineWidth: 1,
                                fill: 0.4
                            },
                            points: {
                                radius: 0,
                                show: true
                            },
                            shadowSize: 2
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#d5d5d5",
                            borderWidth: 1,
                            color: '#d5d5d5'
                        },
                        colors: ["#1ab394", "#1C84C6"],
                        xaxis:{
                        },
                        yaxis: {
                            ticks: 4
                        },
                        tooltip: false
                    }
            );

            var doughnutData = [
                {
                    value: 300,
                    color: "#a3e1d4",
                    highlight: "#1ab394",
                    label: "App"
                },
                {
                    value: 50,
                    color: "#dedede",
                    highlight: "#1ab394",
                    label: "Software"
                },
                {
                    value: 100,
                    color: "#A4CEE8",
                    highlight: "#1ab394",
                    label: "Laptop"
                }
            ];

            var doughnutOptions = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45, // This is 0 for Pie charts
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false
            };

            var ctx = document.getElementById("doughnutChart").getContext("2d");
            var DoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);

            var polarData = [
                {
                    value: 300,
                    color: "#a3e1d4",
                    highlight: "#1ab394",
                    label: "App"
                },
                {
                    value: 140,
                    color: "#dedede",
                    highlight: "#1ab394",
                    label: "Software"
                },
                {
                    value: 200,
                    color: "#A4CEE8",
                    highlight: "#1ab394",
                    label: "Laptop"
                }
            ];

            var polarOptions = {
                scaleShowLabelBackdrop: true,
                scaleBackdropColor: "rgba(255,255,255,0.75)",
                scaleBeginAtZero: true,
                scaleBackdropPaddingY: 1,
                scaleBackdropPaddingX: 1,
                scaleShowLine: true,
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false
            };
            var ctx = document.getElementById("polarChart").getContext("2d");
            var Polarchart = new Chart(ctx).PolarArea(polarData, polarOptions);



        });
    </script>
</body>
</html>
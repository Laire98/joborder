@extends('layout.master')
@section('title','Add Charge Invoice')
@section('maincontent')

    <div class="container px-4">
        <form id="form_charginvoice_register">
            <h1 class="mt-4">Add Charge Invoice</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{route("chargeinvoice")}}">Charge Invoice</a></li>
                <li class="breadcrumb-item active">Add Charge Invoice</li>
            </ol>

            <div class="card mb-4 border-dark ">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Customer Information:
                </div>
                <div class="card-body table-responsive">
                    <div class="row align-items-center mb-4">
                        <i class="fas fa-user mx-0 pe-2 fa-lg fa-fw"></i>
                        <div class="col-5 px-0">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name') }}" onkeydown="EnterKey(event, 'address')" required/>
                        </div>
                        <i class="fas fa-map-marker-alt mx-0 ps-5 pe-2 fa-lg fa-fw"></i>
                        <div class="col px-0 pe-3">
                            <input type="text" name="address" id="address" class="form-control" placeholder="Address" value="{{ old('address') }}" onkeydown="EnterKey(event, 'contact')" required/>
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <i class="fas fa-phone mx-0 pe-2 fa-lg fa-fw"></i>
                        <div class="col-5 px-0">
                            <input type="numeric" name="contact" id="contact" class="form-control" placeholder="Contact" value="{{ old('contact') }}" onkeydown="EnterKey(event, 'email')" required/>
                        </div>
                        <i class="fas fa-envelope mx-0 ps-5 pe-2 fa-lg fa-fw"></i>
                        <div class="col px-0 pe-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}"  onkeydown="EnterKey(event, 'tin')" />
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <i class="fa-solid fa-scale-unbalanced-flip mx-0 pe-2 fa-lg fa-fw"></i>
                        <div class="col-5 px-0">
                            <input type="text" name="tin" id="tin" class="form-control" placeholder="TIN" value="{{ old('tin') }}" onkeydown="EnterKey(event, 'remarks')" required/>
                        </div>
                        <i class="fas fa-marker mx-0 ps-5 pe-2 fa-lg fa-fw"></i>
                        <div class="col  px-0 pe-3">
                            <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks" value="{{ old('remarks') }}"  onkeydown="EnterKey(event, 'btn_list_additem')" required/>
                        </div>
                    </div>


                </div>
            </div>

            <div class="card mb-4 border-dark ">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of items
                </div>
                <div class="card-body  table-responsive">
                    <div class="row">
                        <div class="col">
                            <button type="button" id="btn_list_additem"  class="btn btn-success" onclick="open_modal_additem()" ><i class="fas fa-cart-shopping" title="Add Item"></i>&nbsp; Add Item</button>
                        </div>
                    </div>
                    <hr>
                    <table id="table_listofitems" class="table table-hover  text-center mb-5">
                        <thead>
                            <tr>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Articles</th>
                                <th style="text-align:right">Unit Price</th>
                                <th style="text-align:right">Total Amount</th>
                                <th style="text-align:center">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--  JS Script used  --}}
                        </tbody>
                    </table>
                    <hr>
                    <div class="container">
                        <div class="row justify-content-end ">
                            <div class="col mt-2 " style="text-align:right; font-weight:bold">
                                <label>Grand Total:</label>
                            </div>
                            <div class="col-3 ">
                                <input class="form-control text-end border-1 border-dark" style="font-weight:bold" id="grand_total" value="0.00" readonly/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row px-2 mb-4">
                <button type="submit" id="btn_register" class="btn btn-primary btn-lg" >Register</button>
            </div>
        </form>
    </div>

    {{--  Add Item modal  --}}
    <div class="modal fade" id="Modal_Additem" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                    <h2> Add Items:</h2>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="row mb-4">
                            <i class="fas fa-basket-shopping pe-0 fa-xl fa-fw mt-4"></i>
                            <div class="col">
                                <label for="articles">Articles:</label>
                                <input type="text" name="articles" id="articles" class="form-control" placeholder="Articles" value="{{ old('articles') }}" onkeydown="EnterKey(event, 'quantity')" required/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <i class="fas fa-sack-dollar pe-0 fa-xl fa-fw mt-4"></i>
                            <div class="col-5">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" class="form-control cost_input" placeholder="Quantity" value="{{ old('quantity') }}" onkeydown="EnterKey(event, 'unit')" min="1" onclick="highlight()" required/>
                            </div>
                            <i class="fas fa-scale-balanced pe-0 fa-xl fa-fw mt-4"></i>
                            <div class="col">
                                <label for="unit">Unit:</label>
                                <input type="text" name="unit" id="unit" class="form-control" placeholder="Unit" value="{{ old('unit') }}" onkeydown="EnterKey(event, 'price')"  readonly/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <i class="fas fa-wallet pe-0 fa-xl fa-fw mt-4"></i>
                            <div class="col-5">
                                <label for="price">Unit Price:</label>
                                <input type="number" name="price" id="price" class="form-control cost_input" placeholder="Price" value="{{ old('price') }}" onkeydown="EnterKey(event, 'total')" min="0" onclick="highlight()" required/>
                            </div>
                            <i class="fas fa-receipt pe-0 fa-xl fa-fw mt-4"></i>
                            <div class="col">
                                <label for="articles">Total Amount:</label>
                                <input type="text" name="total" id="total" class="form-control" placeholder="Total Amount" value="{{ old('quantity') }}" onkeydown="EnterKey(event, 'add_item_confirmed')"  readonly/>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="add_item_confirmed" id="add_item_confirmed"  class="btn btn-success" style="justify-content: flex-start;" >Confirmed</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"  onclick="close_modal_additem()">Close</button>
                    </div>

            </div>
        </div>
    </div>

     {{--  Notification modal after submit  --}}
     <div class="modal fade" id="notifyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notification:</h5>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  onclick="closeNotify()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function EnterKey(event, nextInputId) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById(nextInputId).focus();
            }
        }

        function closeNotify()
        {
             $('#notifyModal').modal('hide');
        }

        function open_modal_additem() {
            $('#Modal_Additem').modal('show');

        }

        function close_modal_additem() {
            $('#Modal_Additem').modal('hide');
        }

        function highlight()
        {
            $(".cost_input").on('focus', function() {
                this.select();
            });
        }

        $('input[name="quantity"]').on('blur', function () {
            var inputValue = $(this).val();
            var quantity = $('#price').val();
            if (inputValue === '' || isNaN(inputValue) || inputValue < 0) {
                $(this).val('1');
                $('#price').val('0.00');
                $('#total').val('0.00');
            } else {
                $(this).val(parseFloat(inputValue));
                inputValue = inputValue * quantity;
                $('#total').val(parseFloat(inputValue).toFixed(2));
            }
        });

        $('input[name="price"]').on('blur', function () {
            var inputValue = $(this).val();
            var quantity = $('#quantity').val();
            if (inputValue === '' || isNaN(inputValue) || inputValue < 0) {
                $(this).val('0.00');
                $('#total').val('0.00');
            } else {
                $(this).val(parseFloat(inputValue).toFixed(2));
                inputValue = inputValue * quantity;
                $('#total').val(parseFloat(inputValue).toFixed(2));
            }
        });

        $('#quantity').on('blur', function (){
            var quantity = $('#quantity').val();
            if (quantity === '' || isNaN(quantity) || quantity <= 1) {
                $(this).val('1');
                $('#unit').val('pc');
            } else {
                $('#unit').val('pcs');
            }
        });

        $('#non_vat').on('blur', function (){
            var non_vat = $('#non_vat').val();
            if (non_vat === '' || isNaN(non_vat) || non_vat < 0) {
                $(this).val('0.00');
            }
            else
            {
                $(this).val(parseFloat(non_vat).toFixed(2));
            }
        });


        $("#add_item_confirmed").on('click', function(){


            var grandtotal = 0;
            var tbody = $('#table_listofitems tbody');
            var quantity = $('#quantity').val();
            var unit = $('#unit').val();
            var articles = $('#articles').val().trim();
            var price = $('#price').val();
            var total = $('#total').val();

            var isDuplicate = false;
            tbody.find('tr').each(function() {
                var existingArticle = $(this).find('td:nth-child(3)').text().trim();
                if (existingArticle === articles) {
                    alert('Duplicate article. Please create a different one.');
                    isDuplicate = true;
                    return false;
                }
            });
            if (isDuplicate) {
                $("#articles").focus();
                return;
            }

            if(articles.length === 0 )
            {
                alert('Please fill the blank.');
                $("#articles").focus();
            }
            else if (parseFloat(quantity) === 0 || isNaN(quantity) || quantity === '' )
            {
                alert('Quantity is zero.');
                $("#quantity").focus();
            }
            else if (parseFloat(total) === 0)
            {
                alert('Unit Price is zero.');
                $("#price").focus();
            }
            else
            {
                var newRow = '<tr>' +
                    '<td>' + quantity + '</td>' +
                    '<td>' + unit + '</td>' +
                    '<td>' + articles + '</td>' +
                    '<td style="text-align:right"> ' + number_format(price, 2, '.', ',') + '</td>' +
                    '<td style="text-align:right"> ' + number_format(total, 2, '.', ',') + '</td>' +
                    '<td style="text-align:center; cursor:pointer"><i class="fas fa-trash delete-button" title="Remove">Delete</i></td>' +
                    '</tr>';

                tbody.append(newRow);

                tbody.find('tr').each(function () {

                    var cells = $(this).find('td');
                    var total = parseFloat(cells.eq(4).text().replace(',', ''));
                    grandtotal += total;

                });

                $('#grand_total').val(number_format(grandtotal, 2, '.', ','));

                //Clear data
                $('#quantity').val('');
                $('#unit').val('');
                $('#articles').val('');
                $('#price').val('');
                $('#total').val('');

                $("#articles").focus();
            }
        });

        $("#table_listofitems tbody").on('click', '.delete-button', function() {
            var confirmed = confirm("Are you sure you want to remove this item?");
            if (confirmed)
            {
                $(this).closest('tr').remove();

                var grandtotal = 0;
                $('#table_listofitems tbody tr').each(function() {
                    var total = parseFloat($(this).find('td').eq(4).text().replace(',', ''));
                    grandtotal += total;
                });
                $('#grand_total').text(number_format(grandtotal, 2, '.', ','));

            }
        });

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = parseFloat(number);
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };

            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }

            return s.join(dec);
        }

        $('#form_charginvoice_register').on('submit', function(e){
            e.preventDefault();

            var table = $('#table_listofitems');
            var dataToSend = [];

            // Loop through each row in the table
            table.find('tbody tr').each(function () {
                var row = $(this);
                var quantity = row.find('td:eq(0)').text();
                var unit = row.find('td:eq(1)').text();
                var articles = row.find('td:eq(2)').text();
                var price = parseFloat(row.find('td:eq(3)').text().replace(',', ''));
                var total = parseFloat(row.find('td:eq(4)').text().replace(',', ''));

                // Create an object with the row data
                var rowData = {
                    quantity: quantity,
                    unit: unit,
                    articles: articles,
                    price: price,
                    total: total
                };

                // Add the object to the array
                dataToSend.push(rowData);
            });


            if (dataToSend.length === 0) {
                alert("Please add at least one item to the table.");
                return;
            }

            dataToSend.push({
                name: $('#name').val(),
                address: $('#address').val(),
                contact: $('#contact').val(),
                email: $('#email').val(),
                tin: $('#tin').val(),
                remarks: $('#remarks').val()
            });


            var url_data = "{{ route('chargeinvoice.register') }}";
            $.ajax({
                url: url_data,
                type: 'POST',
                data: JSON.stringify(dataToSend),
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    $('#notifyModal').modal('show');
                    $('#notifyModal .modal-body').text(response.message);

                    setTimeout( function (){
                      window.location.href = "{{route('chargeinvoice')}}";
                    }, 1000);
                },

            });

        });


        $('#name').autocomplete({
            source: [], // Empty array initially
            minLength: 1, // Minimum characters before making an AJAX request
            select: function (event, ui) {
                var selectedCustomer = ui.item.value;

                // Fetch additional details for the selected customer
                $.ajax({
                    url: "{{ route('chargeinvoice.autocomplete')}}",
                    method: 'GET',
                    data: {
                             query: selectedCustomer,
                          },

                    success: function (response) {
                        var customerList = response.customerList;
                        var selectedCustomerid = customerList.find(customerList => customerList.name === selectedCustomer);

                        $('#contact').val(selectedCustomerid.contact).prop('readonly',true);
                        $('#email').val(selectedCustomerid.email).prop('readonly',true);
                        $('#address').val(selectedCustomerid.address).prop('readonly',true);

                    }
                });
            }
        }).on('input',function(){

            $('#contact').val('').prop('readonly',false);
            $('#email').val('').prop('readonly',false);
            $('#address').val('').prop('readonly',false);

            var query = $('#name').val();

            $.ajax({
                url: "{{ route('workorder.autocomplete')}}",
                method: 'GET',
                data:{query: query},

                success: function (response)
                {
                    var customerList = response.customerList;

                     $('#name').autocomplete({
                        source: customerList.map(customerList => customerList.name),
                        open: function (event, ui) {
                            // Add custom class to the autocomplete dropdown
                            $('.ui-autocomplete').addClass('ui-autocomplete-custom');
                        },
                        focus: function (event, ui) {
                            // Add custom class to the focused item
                            $(ui.item.label).addClass('ui-state-highlight-custom');
                        },
                        close: function (event, ui) {
                            // Reset styling when the autocomplete menu is closed
                            $('.ui-menu-item-wrapper').removeClass('ui-state-highlight-custom');
                        }
                    });
                }
            });

        });

    </script>

@endsection

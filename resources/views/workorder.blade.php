@extends('layout.master')
@section('title','Work Order')
@section('maincontent')

    <div class="container px-4">

        <h1 class="mt-4">Work Order</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Work Order</li>
        </ol>

        <form action="{{route("workorder.store")}}" method="POST">
            @csrf

            <div class="row justify-content-center ">

                <div class="card mb-4 border-dark mx-3 mb-1 " style="width:30rem">

                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Client Information:
                    </div>

                    <div class="card-body ">

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name') }}" onkeydown="EnterKey(event, 'contact')" required/>
                            </div>
                        </div>


                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-phone fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="numeric" name="contact" id="contact" class="form-control" placeholder="Contact" value="{{ old('contact') }}" onkeydown="EnterKey(event, 'email')" required/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}"  onkeydown="EnterKey(event, 'address')" />
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-2">
                            <i class="fas fa-map-marker-alt fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="text" name="address" id="address" class="form-control" placeholder="Address" value="{{ old('address') }}" onkeydown="EnterKey(event, 'device')" required/>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card mb-4 border-dark mx-3 mb-1" style="width:30rem">

                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Device Information:
                    </div>

                    <div class="card-body ">
                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-desktop fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="text" name="device" id="device" class="form-control" placeholder="Device Type" value="{{ old('device') }}" onkeydown="EnterKey(event, 'model')" required/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="far fa-file-alt fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="text" name="model" id="model" class="form-control" placeholder="Model" value="{{ old('model') }}"  onkeydown="EnterKey(event, 'serial')" required/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-barcode fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="text" name="serial" id="serial" class="form-control" placeholder="Serial Number" value="{{ old('serial') }}" onkeydown="EnterKey(event, 'access')" required/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-shield-alt fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="text" name="access" id="access" class="form-control" placeholder="Password/Access Information" value="{{ old('access') }}" onkeydown="EnterKey(event, 'issue')" />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card mb-4 border-dark mx-5 mb-1" style="width:62rem">

                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Issue Description:
                    </div>

                    <div class="card-body ">
                        <div class="d-flex flex-row align-items-center mb-4">
                            {{--  <i class="fas fa-desktop fa-lg me-3 fa-fw"></i>  --}}
                            <div class="form-outline flex-fill mb-0">
                                <textarea name="issue" id="issue" class="form-control" placeholder="Detailed description of the problem reported by the client." onkeydown="EnterKey(event, 'inspection')" required>{{ old('issue') }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card mb-4 border-dark mx-3 mb-1 " style="width:30rem">

                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Diagnostic Information:
                    </div>

                    <div class="card-body ">

                        <div class="d-flex flex-row align-items-center mt-3 mb-5">
                            <i class="fas fa-search fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input class="form-check-input"  type="checkbox" name="inspection" id="inspection" onkeydown="EnterKey(event, 'software')"  {{ old('inspection') ? 'checked' : '' }}  />
                                <label class="form-check-label" for="inspection" style="cursor: pointer">Physical inspection</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-5">
                            <i class="fas fa-project-diagram fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input class="form-check-input" type="checkbox" name="software" id="software" onkeydown="EnterKey(event, 'interview')"  {{ old('software') ? 'checked' : '' }} />
                                <label class="form-check-label" for="software" style="cursor: pointer">Software diagnostic tools</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-male fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input class="form-check-input" type="checkbox" name="interview" id="interview" onkeydown="EnterKey(event, 'replacement')"  {{ old('interview') ? 'checked' : '' }} />
                                <label class="form-check-label" for="interview" style="cursor: pointer">Customer interview</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card mb-4 border-dark mx-3 mb-1 " style="width:30rem">

                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Repair/Resolution Plan:
                    </div>

                    <div class="card-body ">

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-tools fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input class="form-check-input" type="checkbox" name="replacement" id="replacement" onkeydown="EnterKey(event, 'patch')"  {{ old('replacement') ? 'checked' : '' }} />
                                <label class="form-check-label" for="replacement" style="cursor: pointer">Hardware repair/replacement</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-shield-virus fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input class="form-check-input" type="checkbox" name="patch" id="patch" onkeydown="EnterKey(event, 'backup')"  {{ old('patch') ? 'checked' : '' }} />
                                <label class="form-check-label" for="patch" style="cursor: pointer">Software update/patch</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-database fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input class="form-check-input" type="checkbox" name="backup" id="backup" onkeydown="EnterKey(event, 'other')"  {{ old('backup') ? 'checked' : '' }} />
                                <label class="form-check-label" for="backup" style="cursor: pointer">Data backup/recovery</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-envelope-open-text fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input class="form-check-input" type="checkbox" name="other" id="other" onkeydown="EnterKey(event, 'completion_time')" {{ old('other') ? 'checked' : '' }} />
                                <label class="form-check-label" for="other" style="cursor: pointer">Other (specify):</label>
                            </div>
                        </div>

                        <div class="form-text">
                            <textarea name="other_desc" id="other_desc" for="other" class="form-check-label w-100" style="cursor: pointer" placeholder="Detailed description of the resolution plan." >{{ old('other_desc') }}</textarea>
                        </div>

                    </div>

                </div>

                <div class="card mb-4 border-dark mx-3 mb-1 " style="width:30rem">

                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Timeline:
                    </div>

                    <div class="card-body ">

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="far fa-clock  fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-check-label" style="cursor: pointer">Estimated Time for Completion:</label>
                                <input type="time" name="completion_time" id="completion_time" class="form-control"  value="{{ old('completion_time') }}"  onkeydown="EnterKey(event, 'start_date')" required/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-calendar-day  fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-check-label"  style="cursor: pointer">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"  value="{{ old('start_date') }}" onkeydown="EnterKey(event, 'completion_date')" required/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-calendar-check fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-check-label"  style="cursor: pointer">Expected Completion Date:</label>
                                <input type="date" name="completion_date" id="completion_date" class="form-control"  value="{{ old('completion_date') }}"  onkeydown="EnterKey(event, 'labor_charges')" required/>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card mb-4 border-dark mx-3 mb-1 " style="width:30rem">

                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Cost Estimate:
                    </div>

                    <div class="card-body ">

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-digging  fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-check-label"  style="cursor: pointer">Labor Charges:</label>
                                <input type="number"  name="labor_charges" id="labor_charges"  class="form-control cost_input"  value="{{ old('labor_charges') ? old('labor_charges') : '0.00' }}" min="0" ="highlight()"  onkeydown="EnterKey(event, 'software_cost')" required/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-viruses  fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-check-label" style="cursor: pointer">Parts/Software Costs:</label>
                                <input type="number" name="software_cost" id="software_cost"  class="form-control cost_input" value="{{ old('software_cost') ? old('software_cost') : '0.00' }}"  min="0" onclick="highlight()"  onkeydown="EnterKey(event, 'miscellaneous_expense')" required/>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-book fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-check-label" style="cursor: pointer">Miscellaneous Expenses:</label>
                                <input type="number" name="miscellaneous_expense" id="miscellaneous_expense"  class="form-control cost_input" value="{{ old('miscellaneous_expense') ? old('miscellaneous_expense') : '0.00'  }}"  min="0" onclick="highlight()" onkeydown="EnterKey(event, 'total_cost')" required/>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-money-check-alt fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-check-label" style="cursor: pointer">Total Estimated Cost:</label>
                                <input type="number" name="total_cost" id="total_cost" class="form-control" style="background-color: white;"  value="{{ old('total_cost') ? old('total_cost') : '0.00' }}" onkeydown="EnterKey(event, 'register')" readonly/>
                            </div>
                        </div>

                    </div>


                </div>

                <div class="d-grid gap-2 mx-5 px-5 mb-5">
                    <button type="submit" id="register" class="btn btn-primary btn-lg" >Register</button>
                </div>

            </div>

        </form>



    </div>

    <script>

        function EnterKey(event, nextInputId) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById(nextInputId).focus();
            }
        }

        function highlight()
        {
            $(".cost_input").on('focus', function() {
                this.select();
            });

        }

        $('input[name="labor_charges"]').on('blur', function () {
            var inputValue = $(this).val();
            if (inputValue === '' || isNaN(inputValue) || inputValue < 0) {
                $(this).val('0.00');
            } else {
                $(this).val(parseFloat(inputValue).toFixed(2));
            }
        });

        $('input[name="software_cost"]').on('blur', function () {
            var inputValue = $(this).val();
            if (inputValue === '' || isNaN(inputValue) || inputValue < 0) {
                $(this).val('0.00');
            } else {
                $(this).val(parseFloat(inputValue).toFixed(2));
            }
        });

        $('input[name="miscellaneous_expense"]').on('blur', function () {
            var inputValue = $(this).val();
            if (inputValue === '' || isNaN(inputValue) || inputValue < 0) {
                $(this).val('0.00');
            } else {
                $(this).val(parseFloat(inputValue).toFixed(2));
            }
        });

        var costInputs = $('.cost_input');
        costInputs.on('input', function () {
            var totalCost = 0;
            costInputs.each(function () {
                var inputValue = parseFloat($(this).val()) || 0;
                if (inputValue >= 0) {
                    totalCost += inputValue;
                }
            });

            $('input[name="total_cost"]').val(totalCost.toFixed(2));
        });


        function getCurrentTime() {
           const now = new Date();
           const hours = now.getHours().toString().padStart(2, '0');
           const minutes = now.getMinutes().toString().padStart(2, '0');
           return `${hours}:${minutes}`;
        }




        $('#completion_time').on('focus', function() {
            this.value = getCurrentTime();
          });

        $('#start_date').on('focus', function() {
            const now = new Date();
            this.value = now.toISOString().split('T')[0];
        });

        $('#completion_date').on('focus', function() {
            const now = new Date();
            this.value = now.toISOString().split('T')[0];
        });

        $('#other').on('change', function(){
           var textarea = document.getElementById('other_desc');
           textarea.disabled = !this.checked;
           if (!this.checked) {
            textarea.value = '';
          }
        });

        window.addEventListener('load', function (){
          $othervalue = $('#other').prop('checked');
            if($othervalue == false)
            {
                var textarea = document.getElementById('other_desc');
                textarea.disabled = true;
            }

        });



        //autocomplete
        $('#name').autocomplete({
            source: [], // Empty array initially
            minLength: 1, // Minimum characters before making an AJAX request
            select: function (event, ui) {
                var selectedCustomer = ui.item.value;

                // Fetch additional details for the selected customer
                $.ajax({
                    url: "{{ route('workorder.autocomplete')}}",
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

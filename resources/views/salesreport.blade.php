@extends('layout.master')
@section('title','User')
@section('maincontent')
    <div class="container px-4">
        <h1 class="mt-4">Sales Report</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Sales Report</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
               Total Income
            </div>
            <div class="card-body table-responsive">
                <form action="{{route("salesreport")}}" method="GET" >
                    <div class="row">
                        <div class="col-6 col-sm-3">
                            <label class="form-check-label"  style="cursor: pointer">Year Date:</label>
                            <input type="number" name="receivable_start_date" id="receivable_start_date" class="form-control form-control-sm "   onkeydown="EnterKey(event, 'receivable_search')" min="2000" max="2100" step="1"  required/>
                        </div>
                        <div class="col align-self-end">
                            <button type="submit" name="receivable_search" class="btn btn-primary" ><i class="fas fa-search" title="Search"></i>&nbsp; Search</button>
                        </div>
                        <div class="col-auto align-self-end">
                            <button type="button" class="btn btn-success mt-2" style="justify-content: flex-start;" id="convertPDF_income" ><i class="fas fa-print" title="Print"></i>&nbsp; Convert to PDF</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div style="height: 400px; width:900px; margin:auto">
                    <canvas id="barChart"></canvas>
                </div>

            </div>
        </div>
    </div>

     {{--  Income modal  --}}
     <div class="modal fade table-responsive " id="IncomeModal" tabindex="-1" role="dialog" >
        <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content " style="width: 800px">
                <div class="modal-body ">

                    <div id="pdfContent">
                        <div class="container align-center" style="font-family: calibri">
                            <div class="col">
                                    <h2 class="mb-0"> JHAZEKE COMPUTER SHOP </h2>
                                    <p class="mb-0">BRGY.4 CORDERO ST., KABANKALAN CITY </p>
                                    <p class="mb-0">09630865616</p>
                            </div>
                            <hr>
                            <div style="height: 350px; width:auto; margin:auto">
                                <canvas id="barChartModal"></canvas>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" style="justify-content: flex-start;" onclick="generatePDF()" >Download to PDF</button>
                    <button type="button" class="btn btn-dark" data-dismiss="modal"  onclick="incomeCloseModal()">Cancel</button>
                </div>

            </div>

        </div>
    </div>

    <script>

        $('#convertPDF_income').on('click', function(){
            $('#IncomeModal').modal('show');
        });

        function incomeCloseModal()
        {
            $('#IncomeModal').modal('hide');
        }

        $(function ()
        {
            var incomeData = @json($IncomeList);

            function fillMissingMonths(data) {
                var result = [];
                for (var i = 1; i <= 12; i++) {
                    var monthData = data.find(item => item.month === i);
                    result.push({
                        month: i,
                        total_income: monthData ? monthData.total_income : 0
                    });
                }
                return result;
            }

            var filledData = fillMissingMonths(incomeData);
            var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var labels = filledData.map(item => monthNames[item.month - 1]);
            var data = filledData.map(item => item.total_income);
            var Year =  $('#receivable_start_date').val();
            var barCanvas = $('#barChart');
            var barChart = new Chart(barCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets:[{
                        label: 'Total Income ' + Year,
                        data: data,
                        backgroundColor: ['rgba(75, 192, 192, 0.5)'], // rgba(75, 192, 192, 0.2)
                        borderColor: 'rgba(75, 192, 192, 1)', // Adjust color as needed
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });
        });

        function EnterKey(event, nextInputId)
        {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById(nextInputId).focus();
            }
        }

        function getCurrentYear()
        {
            const now = new Date();
            var value = now.getFullYear().toString();
            return value;
        }

        window.addEventListener('load', function ()
        {
            const urlParams = new URLSearchParams(window.location.search);
            const startDateParam = urlParams.get('receivable_start_date');
            $('#receivable_start_date').val(startDateParam || getCurrentYear());
        });



        //Modal for Bar Chart
        $(function ()
        {
            var incomeData = @json($IncomeList);

            function fillMissingMonths(data) {
                var result = [];
                for (var i = 1; i <= 12; i++) {
                    var monthData = data.find(item => item.month === i);
                    result.push({
                        month: i,
                        total_income: monthData ? monthData.total_income : 0
                    });
                }
                return result;
            }

            var filledData = fillMissingMonths(incomeData);
            var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var labels = filledData.map(item => monthNames[item.month - 1]);
            var data = filledData.map(item => item.total_income);
            var Year =   $('#receivable_start_date').val();
            var barCanvas = $('#barChartModal');
            var barChart = new Chart(barCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets:[{
                        label: 'Total Income ' + Year,
                        data: data,
                        backgroundColor: ['rgba(75, 192, 192, 0.5)'], // rgba(75, 192, 192, 0.2)
                        borderColor: 'rgba(75, 192, 192, 1)', // Adjust color as needed
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });

        });

        function getCurrentYear()
        {
            const now = new Date();
            var value = now.getFullYear().toString();
            return value;
        }

        window.addEventListener('load', function ()
        {
            const urlParams = new URLSearchParams(window.location.search);
            const startDateParam = urlParams.get('receivable_start_date');
            $('#receivable_start_date').val(startDateParam || getCurrentYear());
        });

        function generatePDF() {
            const source = document.getElementById('pdfContent');
            var Year =   $('#receivable_start_date').val();
            const options = {
                margin: 10, // Adjust the margin as needed
                filename: 'TotalIncome'+Year+'.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'letter', orientation: 'landscape' } // Adjust paper size and orientation
            };

            // Pass options to html2pdf
            html2pdf(source, options);
        }

    </script>

@endsection

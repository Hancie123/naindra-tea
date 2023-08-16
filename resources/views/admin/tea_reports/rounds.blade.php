<!doctype html>
<html lang="en">
@include('layouts/admin_header')
@push('title')
<title>Naindra Tea Farm | Tea Record Report</title>
</head>

<body>

    @if(session('success'))
    @php
    $success = Session::get('success');
    $fail = Session::get('fail');
    @endphp
    <script>
    Swal.fire({
        title: '{{ $success }}',
        width: 600,
        padding: '3em',
        backdrop: 'rgba(0, 0, 123, 0.4) left top no-repeat',
    });
    </script>
    @endif

    @if(session('fail'))
    @php
    $success = Session::get('success');
    $fail = Session::get('fail');
    @endphp
    <script>
    Swal.fire({
        title: '{{ $fail }}',
        width: 600,
        padding: '3em',
        backdrop: 'rgba(0, 0, 123, 0.4) left top no-repeat'
    });
    </script>
    @endif


    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('layouts/admin_sidebar')
        <!--  Main wrapper -->
        <div class="body-wrapper">
            @include('layouts/admin_nav')
            <div class="container-fluid">


                <!-- The Side Image Image Chnage Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title text-center">Change application logo</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                Modal body..
                            </div>



                        </div>
                    </div>
                </div>
                <!-- The Side Image Image Chnage Modal -->


                <div id="w3-bar" class="w3-bar">
                    <a href="{{url('/admin/tea-reports/tea-bill')}}" class="w3-bar-item w3-button">Tea
                        Bills</a>
                    <a href="{{url('/admin/tea-reports/employees')}}" class="w3-bar-item w3-button">Employees</a>
                    <a href="{{url('/admin/tea-reports/tea-records')}}" class="w3-bar-item w3-button">Tea
                        Records</a>
                    <a href="{{url('/admin/tea-reports/rounds')}}" class="w3-bar-item w3-button w3-green">Rounds
                        System</a>

                </div>


                <div class="container rounded-container bg-light mt-4">
                    <h2 class=" text-center">Tea Analytics and Reports by Rounds</h2>
                    <p class="text-center mb-3 text-dark h5">Naindra Tea Farm</p><br>
                    <form action="{{url('/admin/tea-reports/rounds')}}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <label class="h5 mt-2 p-0 m-0">Search By Round:</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group mb-3">
                                    <select class="select2 form-control" name="remarks" id="remarks">
                                        @foreach($teabills as $data)
                                        <option value="{{$data['remarks']}}">{{$data['remarks']}}</option>
                                        @endforeach()
                                    </select>
                                    @error('remarks')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <button class="btn btn-primary" type="submit">Search</button>
                                    <a class="btn btn-danger" onclick="printTable()">Print</a>

                                </div>
                            </div>

                        </div><br>

                    </form>
                </div>


                <div id="print-table" class="container rounded-container bg-light mt-4">
                    @if($tearecordcount>=1)
                    <div >
                        <div class="container">
                            <img id="logoImage" class="mx-auto d-block" src="{{asset('assets/Images/2.png')}}"
                                width="80" alt="" /><br>
                            <h3 class="text-center text-dark m-0">Naindra Tea Field</h3>
                            <p class="text-center text-dark p-0 m-0">Address: Bhadrapur-2</p>
                            <p class="text-center text-dark p-0 m-0">Email: {{Session()->get('email')}}</p>
                            <p class="text-center text-dark p-0 m-0">Mobile no: 9816043149</p><br>



                            <h5>Showing Record(s) of
                                @if(!empty($remark))
                                {{$remark}}
                                @else
                                All Time
                                @endif

                            </h5>


                            <div class="row">
                                <div class="col-md-4">
                                    <div id="card" class="card">
                                        <div class="card-body w3-border-green w3-leftbar rounded">
                                            <h4 class="card-title text-dark"><i class='bx bx-leaf'></i>Net Profit</h4>
                                            <h4 class="text-dark">Rs. {{ $netprofit }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div id="card" class="card">
                                        <div class="card-body w3-border-green w3-leftbar rounded">
                                            <h4 class="card-title text-dark"><i class='bx bx-leaf'></i>Net Income</h4>
                                            <h4 class="text-dark">Rs. {{ $teaincome }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div id="card" class="card">
                                        <div class="card-body w3-border-green w3-leftbar rounded">
                                            <h4 class="card-title text-dark"><i class='bx bx-leaf'></i>Expenses Amount
                                            </h4>
                                            <h4 class="text-dark">Rs. {{ $total_expenses }}</h4>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <h4 class="text-center">{{$remark}} Tea Record</h4>
                            <div class="table-responsive mt-2">

                                <table id="tea-table"
                                    class="table rounded-billing-table table-bordered rounded w3-border ">
                                    <thead id="table-heading" class="text-center text-light rounded">
                                        <tr>
                                            <th>Date</th>
                                            <th>Plucked Time</th>
                                            <th>Tea Kg</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="billtablebody" class="text-center text-dark">
                                        @foreach($tearecord as $data)
                                        <tr>
                                            <td>{{$data['nep_date']}}</td>
                                            <td>{{$data['plucked_time']}}</td>
                                            <td>{{$data['total_tea_kg']}} Kg</td>
                                            <td>Rs. {{$data['total_amount']}}</td>
                                        </tr>
                                        @endforeach
                                        <tr id="total-row">
                                            <td colspan="2"></td>
                                            <td id="total-kg"></td>
                                            <td id="total-amount"></td>
                                        </tr>
                                    </tbody>


                                </table>
                            </div>

                        </div>

                    </div>
                    @else
                    <p class="text-center p-3 bg-danger rounded text-light mt-3">No record found for tea record!</p>

                    @endif



                    @if($countfertilizer>=1)
                    <div class="container table-responsive">
                        <div>
                            <p class="text-dark text-center h4 mt-4">{{$remark}} Fertilizer Record</p>
                            <table id="bill-table" class="table table-bordered  w3-border  rounded">
                                <thead id="table-heading" class="text-center text-light rounded">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Product Name</th>
                                        <th>Rate</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>


                                    </tr>
                                </thead>
                                <tbody id="billtablebody" class="text-dark">
                                    @foreach($fertilizer as $data)
                                    <tr>
                                        <td>{{$data['fertilizer_id']}}</td>
                                        <td>{{$data['nep_date']}}</td>
                                        <td>{{$data['product_name']}}</td>
                                        <td>Rs. {{$data['rate']}}</td>
                                        <td>{{$data['quantity']}}</td>
                                        <td>Rs. {{$data['total_amount']}}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <p class="text-center p-3 bg-danger rounded text-light mt-3">No data found for fertilizer expenses!
                    </p>
                    @endif


                    @if($countchemical>=1)
                    <div class="container table-responsive">
                        <div>
                            <p class="text-dark text-center h4 mt-4">{{$remark}} Chemical Record</p>
                            <table id="bill-table" class="table table-bordered  w3-border  rounded">
                                <thead id="table-heading" class="text-center text-light rounded">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Product Name</th>
                                        <th>Rate</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>


                                    </tr>
                                </thead>
                                <tbody id="billtablebody" class="text-dark">
                                    @foreach($chemical as $data)
                                    <tr>
                                        <td>{{$data['chemicalexpenses_id']}}</td>
                                        <td>{{$data['nep_date']}}</td>
                                        <td>{{$data['product_name']}}</td>
                                        <td>{{$data['rate']}}</td>
                                        <td>{{$data['quantity']}}</td>
                                        <td>{{$data['total_amount']}}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <p class="text-center p-3 bg-danger rounded text-light mt-3">No data found for chemical expenses!
                    </p>
                    @endif


                    @if($teabillcount>=1)
                    <div class="container table-responsive">
                        <div>
                            <p class="text-dark text-center h4 mt-4">{{$remark}} Tea Bill Record</p>
                            <table id="bill-table" class="table table-bordered  w3-border rounded">
                                <thead id="table-heading" class="rounded text-light">
                                    <tr>
                                        <th>Bill ID</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Wage (Tea)</th>
                                        <th>Wage Amount</th>
                                        <th>Total Tea</th>
                                        <th>Overtime Amount</th>
                                        <th>Total Amount</th>

                                    </tr>
                                </thead>
                                <tbody id="billtablebody" class="text-dark">
                                    @foreach($teabillquery as $data)
                                    <tr>
                                        <td>{{$data->teabill_id}}</td>
                                        <td>{{$data->nep_date}}</td>
                                        <td>{{$data->Name}}</td>
                                        <td>{{$data->total_wage_kg}} Kg</td>
                                        <td>Rs. {{$data->total_wage_amount}}</td>
                                        <td>{{$data->total_tea_kg}} Kg</td>
                                        <td>Rs. {{$data->total_ot_amount}}</td>
                                        <td>Rs. {{$data->total_amount}}</td>

                                    </tr>
                                    @endforeach
                                    <tr id="total-row">
                                        <td colspan="7"></td>
                                        <td id="bill_total-amount" colspan="1"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <p class="text-center p-3 bg-danger rounded text-light mt-3">No bill record found!</p>
                    @endif














                </div>



















                <script>
                // Wait for the document to load before executing the JavaScript code
                document.addEventListener('DOMContentLoaded', function() {
                    // Calculate total amount
                    var rows = document.querySelectorAll('#tea-table tbody tr');
                    var totalAmount = 0;
                    for (var i = 0; i < rows.length - 1; i++) { // Exclude the last row (total row)
                        var amountCell = rows[i].querySelector('td:nth-child(3)');
                        if (amountCell) {
                            totalAmount += parseFloat(amountCell.innerText.replace('Rs. ', ''));
                        }
                    }

                    // Display total amount
                    var totalAmountCell = document.getElementById('total-kg');
                    if (totalAmountCell) {
                        const quantilFactor = 100; // Adjust the factor as needed
                        const totalQuantil = totalAmount / quantilFactor;
                        const formattedTotalQuantil = totalQuantil.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                            "$&,");

                        totalAmountCell.innerText = 'Total: ' + formattedTotalQuantil + ' Quantils';
                    }

                });
                </script>


                <script>
                // Wait for the document to load before executing the JavaScript code
                document.addEventListener('DOMContentLoaded', function() {
                    // Calculate total amount
                    var rows = document.querySelectorAll('#tea-table tbody tr');
                    var totalAmount = 0;
                    for (var i = 0; i < rows.length - 1; i++) { // Exclude the last row (total row)
                        var amountCell = rows[i].querySelector('td:nth-child(4)');
                        if (amountCell) {
                            totalAmount += parseFloat(amountCell.innerText.replace('Rs. ', ''));
                        }
                    }



                    // Assuming 'totalAmount' is a numeric value representing the total amount
                    // Display total amount with commas as thousands separators and in words
                    var totalAmountCell = document.getElementById('total-amount');
                    if (totalAmountCell) {
                        var formattedTotalAmount = totalAmount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");

                        totalAmountCell.innerText = 'Total Rs: ' + formattedTotalAmount;
                    }

                });
                </script>

                <script>
                // Wait for the document to load before executing the JavaScript code
                document.addEventListener('DOMContentLoaded', function() {
                    // Calculate total amount
                    var rows = document.querySelectorAll('#bill-table tbody tr');
                    var totalAmount = 0;
                    for (var i = 0; i < rows.length - 1; i++) { // Exclude the last row (total row)
                        var amountCell = rows[i].querySelector('td:nth-child(8)');
                        if (amountCell) {
                            totalAmount += parseFloat(amountCell.innerText.replace('Rs. ', ''));
                        }
                    }

                    // Function to convert numeric value to words
                    function numberToWords(num) {
                        const ones = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight',
                            'Nine', 'Ten',
                            'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen',
                            'Eighteen', 'Nineteen'
                        ];

                        const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy',
                            'Eighty', 'Ninety'
                        ];

                        function convertToWords(num) {
                            if (num < 20) return ones[num];
                            if (num < 100) return tens[Math.floor(num / 10)] + (num % 10 !== 0 ? '-' + ones[
                                num % 10] : '');
                            if (num < 1000) return ones[Math.floor(num / 100)] + ' Hundred' + (num % 100 !== 0 ?
                                ' and ' + convertToWords(num % 100) : '');
                            if (num < 1000000) return convertToWords(Math.floor(num / 1000)) + ' Thousand' + (
                                num % 1000 !== 0 ? ' ' + convertToWords(num % 1000) : '');
                            if (num < 1000000000) return convertToWords(Math.floor(num / 1000000)) +
                                ' Million' + (num % 1000000 !== 0 ? ' ' + convertToWords(num % 1000000) :
                                    '');
                            return 'Number too large';
                        }

                        return convertToWords(num);
                    }

                    // Assuming 'totalAmount' is a numeric value representing the total amount
                    // Display total amount with commas as thousands separators and in words
                    var totalAmountCell = document.getElementById('bill_total-amount');
                    if (totalAmountCell) {
                        var formattedTotalAmount = totalAmount
                            .toLocaleString(); // Convert to string with commas
                        var totalAmountInWords = numberToWords(totalAmount);
                        totalAmountCell.innerText = 'Total Rs: ' + formattedTotalAmount;
                    }
                });
                </script>


                <script>
                function printTable() {
                    var printContents = document.getElementById("print-table").innerHTML;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;

                    var logoImage = document.getElementById("logoImage");
                    logoImage.onload = function() {
                        window.print();
                        document.body.innerHTML = originalContents;
                    };
                }
                </script>





                @include('layouts/admin_footer')

                <style>
                .rounded-container {
                    border: 1px solid #ccc;
                    border-radius: 10px;
                    padding: 20px;
                }

                #table-heading {
                    background: #3F3E91;
                    font-size: 0.93em;
                    font-weight: normal;
                    font-size: normal;


                }

                #billtablebody {
                    font-size: 0.93em;
                    font-weight: normal;
                    font-size: normal;
                }

                #w3-bar {
                    background-color: rgb(63, 62, 145);
                    color: #fff;
                    font-size: 16px;
                    font-family: Verdana, sans-serif;

                }

                .select2-container .select2-selection--single {
                    height: calc(2.25rem + 2px) !important;

                }
                </style>

                <script>
                $(document).ready(function() {
                    $('.select2').select2({
                        placeholder: 'Select an option'
                    });
                });
                </script>















            </div>
        </div>
    </div>


</body>

</html>
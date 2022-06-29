<x-app-layout>
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center">
            <div class="col-md-3">
                <img src="{{ Config::get('settings.company.images.logo')  }}" alt="">
            </div>
            <div class="col-md-5 text-center">
                <h4 class="font-18 weight-500 mb-10 text-capitalize">{{ Config::get('settings.company.caption') }}
                    <div class="weight-600 font-30 text-blue">{{ ENV('APP_NAME') }}</div>
                </h4>
                <p class="font-18 max-width-600">
                    {{ Config::get('settings.company.moto')  }} <br>
                    <span class="max-width-600">
                        <small>{{ Config::get('settings.company.address') }}</small><br>
                        <small>{{ Config::get('settings.company.email') }}</small><br>
                        <small>{{ Config::get('settings.company.mobile') }}</small><br>
                    </span>
                </p>
            </div>
            <div class="col-md-4">
                <img src="assets/vendors/images/banner-img.png" alt="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="progress-data">
                        <div id="chart"></div>
                    </div>
                    <div class="widget-data">
                        <div class="h4 mb-0">{{ $customerCount }}</div>
                        <div class="weight-600 font-14">Customer</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="progress-data">
                        <div id="chart2"></div>
                    </div>
                    <div class="widget-data">
                        <div class="h4 mb-0">{{ format_amount_bn($customerDue) }}</div>
                        <div class="weight-600 font-14">Total Due</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="progress-data">
                        <div id="chart3"></div>
                    </div>
                    <div class="widget-data">
                        <div class="h4 mb-0">{{ $invoiceCount }}</div>
                        <div class="weight-600 font-14">Total Invoice</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 mb-30">
            <div class="card-box height-100-p widget-style1">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="progress-data">
                        <div id="chart4"></div>
                    </div>
                    <div class="widget-data">
                        <div class="h4 mb-0">{{ $dueInvoiceCount }}</div>
                        <div class="weight-600 font-14">Due Invoice</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card-box height-100-p pd-20">
                <h2 class="h4 mb-20">Purchase Sale Chart</h2>
                <div id="chart-report" data-chart="{{ $chartData }}"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card-box mb-30">
                <h2 class="h4 pd-20">Top Due Customer</h2>
                <table class="data-table table nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th>Due</th>
                            <th>Due Invoice</th>
                            <th>Details:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topCustomers as $row)
                        <tr>
                            <td class="table-plus">{{ $row->name }}</td>
                            <td>{{ $row->balance }}</td>
                            <td>{{ $row->dueInvoices->count() }}</td>
                            <td>
                                <div class="flex-container">
                                    <div><strong>Email:</strong> {{ $row->email }}</div>
                                    <div><strong>Mobile:</strong> {{ $row->mobile }}</div>
                                    <div><strong>Address:</strong> {{ $row->address }}</div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card-box mb-30">
                <h2 class="h4 pd-20">Top Due Invoice</h2>
                <table class="data-table table nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Invoice No</th>
                            <th>Amount</th>
                            <th>Due</th>
                            <th>Customer:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topInvoices as $row)
                        <tr>
                            <td class="table-plus">{{ $row->invoice_no }}</td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $row->total - $row->paid }}</td>
                            <td>
                                <div class="flex-container">
                                    <div><strong>Name:</strong> {{ $row->customer->name }}</div>
                                    <div><strong>Email:</strong> {{ $row->customer->email }}</div>
                                    <div><strong>Mobile:</strong> {{ $row->customer->mobile }}</div>
                                    <div><strong>Address:</strong> {{ $row->customer->address }}</div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            new Dashboard();
        </script>
    @endpush
</x-app-layout>

@extends('layouts.app_sneat_blank')

@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <div class="page-content container">
        <div class="page-header text-blue-d2">
            <h1 class="page-title text-secondary-d1">
                KWITANSI PEMBAYARAN
                {{-- <small class="text-600 text-110 text-blue align-middle">
                    SMK YADIKA
                </small> --}}
            </h1>

            <div class="page-tools">
                <div class="action-buttons">
                    <a class="btn bg-white btn-light mx-1px text-95" href="#" onclick="window.print()" data-title="Print">
                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                        Print
                    </a>
                    <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="PDF">
                        <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                        Export
                    </a>
                </div>
            </div>
        </div>

        <div class="container px-0">
            <div class="row mt-4">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center text-150">
                                {{-- <i class="fa fa-book fa-2x text-success-m2 mr-1"></i> --}}
                                <small class="text-600 text-110 text-blue align-middle">
                                    {{-- <i class="fa fa-angle-double-right text-80"></i> --}}
                                    SMK YADIKA
                                </small>                            
                            </div>
                        </div>
                    </div>
                    <!-- .row -->

                    {{-- <hr class="row brc-default-l1 mx-n1 mb-4" /> --}}

                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">Wali Murid:</span>
                                <span class="text-600 text-110 text-blue align-middle">Alex Doe</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">
                                    Depok
                                </div>
                                <div class="my-1">
                                    Indonesia
                                </div>
                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b
                                        class="text-600">111-111-111</b></div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">
                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                    Kwitansi Pembayaran
                                </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">ID:</span> #SMKY-{{ $pembayaran->id }}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Tanggal Tagihan:</span> {{ $pembayaran->tanggal_bayar->translatedFormat('d F Y') }}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Status:</span> <span
                                        class="badge badge-warning badge-pill px-25">{{ $pembayaran->tagihan->status }}</span></div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="mt-4">
                        <div class="row text-600 text-white bgc-default-tp1 py-25">
                            <div class="d-none d-sm-block col-1">#</div>
                            <div class="col-9 col-sm-5">Tanggal Pembayaran</div>
                            <div class="d-none d-sm-block col-4 col-sm-2">Metode Bayar</div>
                            <div class="d-none d-sm-block col-sm-2">Jumlah Bayar</div>
                            {{-- <div class="col-2">Amount</div> --}}
                        </div>

                        <div class="text-95 text-secondary-d3">
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">1</div>
                                <div class="col-9 col-sm-5">{{ $pembayaran->tanggal_bayar->translatedFormat('d F Y') }}</div>
                                <div class="d-none d-sm-block col-2 text-95">{{ $pembayaran->metode_pembayaran }}</div>
                                <div class="d-none d-sm-block col-2">{{ formatRupiahHelper($pembayaran->jumlah_dibayar) }}</div>
                                {{-- <div class="col-2 text-secondary-d2">$20</div> --}}
                            </div>

                        </div>

                        <div class="row border-b-2 brc-default-l2"></div>

                        <!-- or use a table instead -->
                        <!--
                <div class="table-responsive">
                    <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                        <thead class="bg-none bgc-default-tp1">
                            <tr class="text-white">
                                <th class="opacity-2">#</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th width="140">Amount</th>
                            </tr>
                        </thead>

                        <tbody class="text-95 text-secondary-d3">
                            <tr></tr>
                            <tr>
                                <td>1</td>
                                <td>Domain registration</td>
                                <td>2</td>
                                <td class="text-95">$10</td>
                                <td class="text-secondary-d2">$20</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                -->

                        <div class="row mt-3">
                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                <i>{{ ucwords(terbilang($pembayaran->jumlah_dibayar)) }}</i>
                            </div>

                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                {{-- <div class="row my-2">
                                    <div class="col-7 text-right">
                                        SubTotal
                                    </div>
                                    <div class="col-5">
                                        <span class="text-120 text-secondary-d1">$2,250</span>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Tax (10%)
                                    </div>
                                    <div class="col-5">
                                        <span class="text-110 text-secondary-d1">$225</span>
                                    </div>
                                </div> --}}

                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right">
                                        Total Dibayar
                                    </div>
                                    <div class="col-5">
                                        <span class="text-150 text-success-d3 opacity-2">{{ formatRupiahHelper($pembayaran->jumlah_dibayar) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div>
                            <span class="text-secondary-d1 text-105 float-right">Depok, {{ $pembayaran->tanggal_bayar->translatedFormat('d F Y') }}</span>
                            <br><br><br>
                            <span class="text-secondary-d1 text-105 float-right ml-5"><u>{{ $pembayaran->user->name }}</u></span>
                            {{-- <a href="#" class="btn btn-info btn-bold px-4 float-right mt-3 mt-lg-0">Pay Now</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container d-flex justify-content-center mt-50 mb-50">

        <div class="row">

            <div class="col-md-12">

                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <h6 class="card-title">Sale invoice</h6>
                        <div class="header-elements">
                            <button type="button" class="btn btn-light btn-sm"><i class="fa fa-file mr-2"></i> Save</button>
                            <button type="button" class="btn btn-light btn-sm ml-3"><i class="fa fa-print mr-2"></i>
                                Print</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-4 pull-left">
                                    <h6>BBBOOTSTRAP.COM</h6>
                                    <ul class="list list-unstyled mb-0 text-left">
                                        <li>2269 Six Sigma</li>
                                        <li>New york city</li>
                                        <li>+1 474 44737 47 </li>

                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-4 ">
                                    <div class="text-sm-right">
                                        <h4 class="invoice-color mb-2 mt-md-2">Invoice #BBB1243</h4>
                                        <ul class="list list-unstyled mb-0">
                                            <li>Date: <span class="font-weight-semibold">March 15, 2020</span></li>
                                            <li>Due date: <span class="font-weight-semibold">March 30, 2020</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-md-flex flex-md-wrap">
                            <div class="mb-4 mb-md-2 text-left">
                                <span class="text-muted">Invoice To:</span>
                                <ul class="list list-unstyled mb-0">
                                    <li>
                                        <h5 class="my-2">Tibco Turang</h5>
                                    </li>
                                    <li><span class="font-weight-semibold">Samantha Mutual funds Ltd</span></li>
                                    <li>Gurung Street</li>
                                    <li>23 BB Lane</li>
                                    <li>Hong kong</li>
                                    <li>234 456 5678</li>
                                    <li><a href="#" data-abc="true">tibco@samantha.com</a></li>
                                </ul>
                            </div>

                            <div class="mb-2 ml-auto">
                                <span class="text-muted">Payment Details:</span>
                                <div class="d-flex flex-wrap wmin-md-400">
                                    <ul class="list list-unstyled mb-0 text-left">
                                        <li>
                                            <h5 class="my-2">Total Due:</h5>
                                        </li>
                                        <li>Bank name:</li>
                                        <li>Country:</li>
                                        <li>City:</li>
                                        <li>Address:</li>
                                        <li>IBAN:</li>
                                        <li>SWIFT code:</li>
                                    </ul>

                                    <ul class="list list-unstyled text-right mb-0 ml-auto">
                                        <li>
                                            <h5 class="font-weight-semibold my-2">$1,090</h5>
                                        </li>
                                        <li><span class="font-weight-semibold">Hong Kong Bank</span></li>
                                        <li>Hong Kong</li>
                                        <li>Thurnung street, 21</li>
                                        <li>New standard</li>
                                        <li><span class="font-weight-semibold">98574959485</span></li>
                                        <li><span class="font-weight-semibold">BHDHD98273BER</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-lg">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Rate</th>
                                    <th>Hours</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <td>
                                        <h6 class="mb-0">Arts and design template</h6>
                                        <span class="text-muted">in reprehenderit in voluptate velit esse cillum dolore eu
                                            fugiat nulla pariatur.Duis aute irure dolor in reprehenderit</span>
                                    </td>
                                    <td>$120</td>
                                    <td>180</td>
                                    <td><span class="font-weight-semibold">$300</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="mb-0">Template for desnging the arts</h6>
                                        <span class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                            sed do eiusmod tempor</span>
                                    </td>
                                    <td>$140</td>
                                    <td>100</td>
                                    <td><span class="font-weight-semibold">$240</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="mb-0">Technical support international</h6>
                                        <span class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                            sed do eiusmod tempor</span>
                                    </td>
                                    <td>$250</td>
                                    <td>$250</td>
                                    <td><span class="font-weight-semibold">$500</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body">
                        <div class="d-md-flex flex-md-wrap">


                            <div class="pt-2 mb-3 wmin-md-400 ml-auto">
                                <h6 class="mb-3 text-left">Total due</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th class="text-left">Subtotal:</th>
                                                <td class="text-right">$1,090</td>
                                            </tr>
                                            <tr>
                                                <th class="text-left">Tax: <span class="font-weight-normal">(25%)</span>
                                                </th>
                                                <td class="text-right">$27</td>
                                            </tr>
                                            <tr>
                                                <th class="text-left">Total:</th>
                                                <td class="text-right text-primary">
                                                    <h5 class="font-weight-semibold">$1,160</h5>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-right mt-3">
                                    <button type="button" class="btn btn-primary"><b><i
                                                class="fa fa-paper-plane-o mr-1"></i></b> Send invoice</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <span class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in
                            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Duis aute irure
                            dolor in reprehenderit</span>
                    </div>
                </div>

            </div>


        </div>
    </div> --}}
    {{-- <div class="container">
        <div class="card">
            <div class="card-header">
                Invoice
                <strong>01/01/01/2018</strong>
                <span class="float-right"> <strong>Status:</strong> Pending</span>

            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="mb-3">From:</h6>
                        <div>
                            <strong>Webz Poland</strong>
                        </div>
                        <div>Madalinskiego 8</div>
                        <div>71-101 Szczecin, Poland</div>
                        <div>Email: info@webz.com.pl</div>
                        <div>Phone: +48 444 666 3333</div>
                    </div>

                    <div class="col-sm-6">
                        <h6 class="mb-3">To:</h6>
                        <div>
                            <strong>Bob Mart</strong>
                        </div>
                        <div>Attn: Daniel Marek</div>
                        <div>43-190 Mikolow, Poland</div>
                        <div>Email: marek@daniel.com</div>
                        <div>Phone: +48 123 456 789</div>
                    </div>



                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Item</th>
                                <th>Description</th>

                                <th class="right">Unit Cost</th>
                                <th class="center">Qty</th>
                                <th class="right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="center">1</td>
                                <td class="left strong">Origin License</td>
                                <td class="left">Extended License</td>

                                <td class="right">$999,00</td>
                                <td class="center">1</td>
                                <td class="right">$999,00</td>
                            </tr>
                            <tr>
                                <td class="center">2</td>
                                <td class="left">Custom Services</td>
                                <td class="left">Instalation and Customization (cost per hour)</td>

                                <td class="right">$150,00</td>
                                <td class="center">20</td>
                                <td class="right">$3.000,00</td>
                            </tr>
                            <tr>
                                <td class="center">3</td>
                                <td class="left">Hosting</td>
                                <td class="left">1 year subcription</td>

                                <td class="right">$499,00</td>
                                <td class="center">1</td>
                                <td class="right">$499,00</td>
                            </tr>
                            <tr>
                                <td class="center">4</td>
                                <td class="left">Platinum Support</td>
                                <td class="left">1 year subcription 24/7</td>

                                <td class="right">$3.999,00</td>
                                <td class="center">1</td>
                                <td class="right">$3.999,00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">

                    </div>

                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td class="right">$8.497,00</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Discount (20%)</strong>
                                    </td>
                                    <td class="right">$1,699,40</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>VAT (10%)</strong>
                                    </td>
                                    <td class="right">$679,76</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong>$7.477,36</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div> --}}
@endsection

@extends('layouts.app')

@section('content')
    <style>
        .map-container{
            height:40vh;
            width:100%;
            #position:absolute;
        }
        .sidebar{
            background-color: rgba(239, 172, 11, 0.65);
            margin:0;
            padding:10px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            overflow: auto;
            height: inherit;
        }
        .sidebar-left{
            position: absolute;
            top:50px;
            right:40px;
        }

        .sidebar-item{
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;

            flex: 1 1 auto;
            margin: 5px;
        }
        .sidebar-item img{
            border-radius: 90px;
            width: 40px;
            height: 40px;

        }
        .sidebar-item p.title{
            font-weight: bold;
            margin-bottom: 0;
        }
        .sidebar-item p.subtitle{
            font-size: 0.75em;
            font-style: italic;
        }


        ::-webkit-scrollbar{
            display: none;
        }
        .revenue-container{
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: stretch;
            width: 100%;
            background-color: #f2f2f2;
        }
        .revenue-container > .heading{

        }
        .revenue-overview{
            background-color: rgba(232, 232, 232, 0.65);
            padding: 0;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;

        }
        .overview-item{
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            padding:20px;

            flex: 1 0 auto;
        }
        .overview-item *{
            margin: 2px;
            color: #ffffff;
        }
        .overview-item h1{
            font-weight: 200;
        }


        .revenue-breakdown, .revenue-summary{
            display: flex;
            flex-flow: row wrap;

            align-items: center;
            justify-content: space-around;
            padding: 0;
            margin-bottom: 40px;

        }
        .summary-section-row{
            display:flex;
            flex-direction: row;
            justify-content: space-around;
            align-content: center;
            flex: 1 1 70%;
        }
        .summary-section-row > .summary-section{
            flex: 1 0 auto;
        }
        .summary-section-row > .summary-section:first-child{
            flex:1 0 70%;
        }
        .breakdown-section, .summary-section{
            flex: 1 0 auto;
            padding: 10px;
            margin:10px;
            border-radius: 10px;
            border: 1px solid #efac0b;
            background-color: #ffffff;
            box-shadow: 0px 0.5px 8px rgba(112, 112, 112, 0.47);
            background-color: rgba(255, 255, 255, 0.70);

            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-content: flex-start;
        }
        .breakdown-section{
            flex-basis:40%;
            max-width:50%;
        }

        .breakdown-section .data{
            padding: 10px;

        }
        .breakdown-section-row .data table *{
            text-align: center;
        }
        .breakdown-section i{
            margin-right: 5px;
        }
        .collapsed{
            display: none;
        }
        .group-row .data-names{
            font-style: italic;
            position: relative;
            left: 20px;
        }
        .group-row .data-values{

        }
        .revenue-raw{
            flex: 1 0 auto;
            padding: 10px;
            margin:10px;
            border-radius: 10px;
            border: 1px solid #efac0b;
            background-color: #ffffff;
            box-shadow: 0px 0.5px 8px rgba(112, 112, 112, 0.47);
        }

        .flex-container {
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        .heading{
            text-align: center;
            margin-bottom: 5px;
            cursor:pointer;
        }
    </style>


    <div class="flex-container">
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d19846.006685263703!2d-1.7580300999999998!3d51.55446775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1453767116129" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
            <div class="sidebar sidebar-left">
                <div class="sidebar-item">
                    <img src="http://mimedu.es/wp-content/uploads/2015/03/mercedes-logotipo.jpg">
                    <p class="title">Mercedes</p>
                    <p class="subtitle">London,SW14 7NJ</p>
                </div>
                <div class="sidebar-item">
                    <img src="http://mimedu.es/wp-content/uploads/2015/03/mercedes-logotipo.jpg">
                    <p class="title">Mercedes</p>
                    <p class="subtitle">London,SW14 7NJ</p>
                </div>
                <div class="sidebar-item">
                    <img src="http://mimedu.es/wp-content/uploads/2015/03/mercedes-logotipo.jpg">
                    <p class="title">Mercedes</p>
                    <p class="subtitle">London,SW14 7NJ</p>
                </div>

            </div>
        </div>
        <div class="revenue-container">

            <div class="revenue-summary">

                <div class="summary-section-row">
                    <div class="summary-section">
                        <div class="heading">
                            <h3>Revenue Overview</h3>
                        </div>
                        <div class="data-summary">
                            <table class="table table-bordered">
                                <tr>
                                    <th>       </th>
                                    <th>Since Joining</th>
                                    <th>For current accounting period</th>
                                </tr>
                                <tr>
                                    <td>Investor Revenue</td>
                                    <td>$400</td>
                                    <td>$100</td>
                                </tr>
                                <tr>
                                    <td>Paid to investor</td>
                                    <td>$330</td>
                                    <td>$90</td>
                                </tr>
                                <tr>
                                    <td>Balance</td>
                                    <td>$2600</td>
                                    <td>$290</td>
                                </tr>
                            </table>
                            <div class="heading">
                                <h4>*Subject to adjustments for VAT and other expenses</h4>
                            </div>
                        </div>
                    </div>
                    <div class="summary-section">

                        <div class="heading">
                            <h3>Total Cars</h3>
                        </div>
                        <div class="heading">
                            <h1>5</h1>
                        </div>

                    </div>
                </div>





            </div>

        </div>
        <div class="revenue-container">
            <div class="heading">
                <h3>Revenue breakdown by Car</h3>
            </div>
            <div class="revenue-breakdown">
                <div class="breakdown-section">
                    <div class="heading">
                        <h3>Revenue summary for Car 1</h3>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-bordered">
                            <tr>
                                <th>       </th>
                                <th>Since Joining</th>
                                <th>For current accounting period</th>
                            </tr>
                            <tr>
                                <td>Investor Revenue</td>
                                <td>$400</td>
                                <td>$100</td>
                            </tr>
                            <tr>
                                <td>Paid to investor</td>
                                <td>$330</td>
                                <td>$90</td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>$2600</td>
                                <td>$290</td>
                            </tr>
                        </table>
                        <div class="heading">
                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                        </div>
                    </div>
                    <div class="heading">
                        <h5>Driver breakdown for this car</h5>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-striped">
                            <tr>
                                <th>Driver</th>
                                <th>Revenue</th>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Driver1</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Driver2</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="breakdown-section">
                    <div class="heading">
                        <h3>Revenue summary for Car 2</h3>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-bordered">
                            <tr>
                                <th>       </th>
                                <th>Since Joining</th>
                                <th>For current accounting period</th>
                            </tr>
                            <tr>
                                <td>Investor Revenue</td>
                                <td>$400</td>
                                <td>$100</td>
                            </tr>
                            <tr>
                                <td>Paid to investor</td>
                                <td>$330</td>
                                <td>$90</td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>$2600</td>
                                <td>$290</td>
                            </tr>
                        </table>
                        <div class="heading">
                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                        </div>
                    </div>
                    <div class="heading">
                        <h5>Driver breakdown for this car</h5>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-striped">
                            <tr>
                                <th>Driver</th>
                                <th>Revenue</th>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Driver1</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Driver2</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="revenue-container">
            <div class="heading">
                <h3>Revenue breakdown by Drivers</h3>
            </div>
            <div class="revenue-breakdown">
                <div class="breakdown-section">
                    <div class="heading">
                        <h3>Revenue summary for Driver 1</h3>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-bordered">
                            <tr>
                                <th>       </th>
                                <th>Since Joining</th>
                                <th>For current accounting period</th>
                            </tr>
                            <tr>
                                <td>Investor Revenue</td>
                                <td>$400</td>
                                <td>$100</td>
                            </tr>
                            <tr>
                                <td>Paid to investor</td>
                                <td>$330</td>
                                <td>$90</td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>$2600</td>
                                <td>$290</td>
                            </tr>
                        </table>
                        <div class="heading">
                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                        </div>
                    </div>
                    <div class="heading">
                        <h5>Car breakdown for this driver</h5>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-striped">
                            <tr>
                                <th>Car</th>
                                <th>Revenue</th>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Car 1</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Car 2</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="breakdown-section">
                    <div class="heading">
                        <h3>Revenue summary for Driver 2</h3>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-bordered">
                            <tr>
                                <th>       </th>
                                <th>Since Joining</th>
                                <th>For current accounting period</th>
                            </tr>
                            <tr>
                                <td>Investor Revenue</td>
                                <td>$400</td>
                                <td>$100</td>
                            </tr>
                            <tr>
                                <td>Paid to investor</td>
                                <td>$330</td>
                                <td>$90</td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>$2600</td>
                                <td>$290</td>
                            </tr>
                        </table>
                        <div class="heading">
                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                        </div>
                    </div>
                    <div class="heading">
                        <h5>Car breakdown for this driver</h5>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-striped">
                            <tr>
                                <th>Car</th>
                                <th>Revenue</th>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Car 1</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Car 2</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="breakdown-section">
                    <div class="heading">
                        <h3>Revenue summary for Driver 3</h3>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-bordered">
                            <tr>
                                <th>       </th>
                                <th>Since Joining</th>
                                <th>For current accounting period</th>
                            </tr>
                            <tr>
                                <td>Investor Revenue</td>
                                <td>$400</td>
                                <td>$100</td>
                            </tr>
                            <tr>
                                <td>Paid to investor</td>
                                <td>$330</td>
                                <td>$90</td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>$2600</td>
                                <td>$290</td>
                            </tr>
                        </table>
                        <div class="heading">
                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                        </div>
                    </div>
                    <div class="heading">
                        <h5>Car breakdown for this driver</h5>
                    </div>
                    <div class="data collapsed">
                        <table class="table table-striped">
                            <tr>
                                <th>Car</th>
                                <th>Revenue</th>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Car 1</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-row">
                                <td><p><i class="fa fa-plus"></i>Car 2</p></td>
                                <td>
                                    <p class="data-values">$250</p>
                                    <div class="data-values collapsed">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>       </th>
                                                <th>Since Joining</th>
                                                <th>For current accounting period</th>
                                            </tr>
                                            <tr>
                                                <td>Investor Revenue</td>
                                                <td>$400</td>
                                                <td>$100</td>
                                            </tr>
                                            <tr>
                                                <td>Paid to investor</td>
                                                <td>$330</td>
                                                <td>$90</td>
                                            </tr>
                                            <tr>
                                                <td>Balance</td>
                                                <td>$2600</td>
                                                <td>$290</td>
                                            </tr>
                                        </table>
                                        <div class="heading">
                                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function(){
           $('.group-row').click(function(){
               $(this).find("[class^=data-]").toggleClass('collapsed');
           });
            $('.heading').click(function(){
                $(this).next('.data').toggleClass('collapsed');
            });
        });
    </script>

@endsection

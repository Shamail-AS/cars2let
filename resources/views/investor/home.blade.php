@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')

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
    @if(Auth::user()->active == 0))
    <div class="floater">
        <p>Your account is inactive. Please use the activation link sent to you to activate or enter code now</p>
        <button id="btn-code-enter" class="btn btn-sm btn-primary">Enter code</button>
        <button id="btn-code-resend" class="btn btn-sm btn-danger">Resend code</button>
        

    </div>
    @endif
    <script>
        $(document).ready(function(){
           $('.group-row').click(function(){
               $(this).find("[class^=data-]").toggleClass('collapsed');
           });
            $('.heading').click(function(){
                $(this).next('.data').toggleClass('collapsed');
            });
            $("#btn-code-enter").click(function(){
                bootbox.prompt('Please enter the code',function(result){
                    if(result === null)
                    {

                    }
                    else
                    {
                        $.get('/api/code/'+result+'/verify',function(response)
                        {
                           if(response.indexOf('Sorry') > -1)
                           {
                               bootbox.alert(response);
                           }
                            else{
                               bootbox.alert('Your account has been activated! ');
                               $('.floater').addClass('collapsed');
                           }

                        });
                    }
                });
            })
        });
    </script>

@endsection

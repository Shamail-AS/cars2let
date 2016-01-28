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

            flex-grow: 0;
            margin: 5px;
        }
        .sidebar-item img{
            border-radius: 90px;
            width: 40px;
            height: auto;

        }
        .sidebar-item p.title{
            font-weight: bold;
            margin-bottom: 0;
        }
        .sidebar-item p.subtitle{
            font-size: 0.75em;
            font-style: italic;
        }

        .image-bunch img{
            margin-top: 20px;
            margin-right: -20px;
            height: 40px;
            width: 40px;
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
        .revenue-overview{
            background-color: rgba(232, 232, 232, 0.65);
            padding: 0;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
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


        .revenue-breakdown{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-around;
            padding: 0;

        }
        .breakdown-section{
            flex: 1 0 auto;
            padding: 10px;
            margin:10px;
            border-radius: 10px;
            border: 1px solid #efac0b;
            background-color: #ffffff;
            box-shadow: 0px 0.5px 8px rgba(112, 112, 112, 0.47);

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-content: flex-start;
        }
        .breakdown-section .heading{
            text-align: center;
            margin-bottom: 5px;
        }
        .breakdown-section .data{
            padding: 10px;

        }
        .breakdown-section i{
            margin-right: 5px;
        }
        .data .group-row .collapsed{
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
        .revenue-raw .heading{
            text-align: center;
            margin-bottom: 5px;
        }

        .flex-container {
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
    </style>


    <!--<div class="flexbox">
        <div class="flexbox-map">
            <div style="height: 300px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d19846.006685263703!2d-1.7580300999999998!3d51.55446775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1453767116129" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
        <br>
        <div class="flexbox">
            <div class="panel panel-default">
                <div class="panel-heading">Revenue</div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-4" style="background-color: #00b3ee">
                            <div class="box">

                            </div>
                        </div>
                        <div class="col-lg-4" style="background-color: #00D3ee">
                            <div class="box">

                            </div>
                        </div>
                        <div class="col-lg-4" style="background-color: #F0b3ee">
                            <div class="box">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="image-bunch flexbox-row">
                                <img src="http://icons.iconarchive.com/icons/elegantthemes/beautiful-flat-one-color/128/car-icon.png">
                                <img src="http://icons.iconarchive.com/icons/elegantthemes/beautiful-flat-one-color/128/car-icon.png">
                                <img src="http://icons.iconarchive.com/icons/elegantthemes/beautiful-flat-one-color/128/car-icon.png">
                                <img src="http://icons.iconarchive.com/icons/elegantthemes/beautiful-flat-one-color/128/car-icon.png">
                                <img src="http://icons.iconarchive.com/icons/elegantthemes/beautiful-flat-one-color/128/car-icon.png">
                                <img src="http://icons.iconarchive.com/icons/elegantthemes/beautiful-flat-one-color/128/car-icon.png">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="image-bunch flexbox-row">
                                <img src="https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-128.png">
                                <img src="https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-128.png">
                                <img src="https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-128.png">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <h2>$4,399</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="flexbox">
            <table class="table table-striped">
                <tr>
                    <th>Car</th>
                    <th>Driver</th>
                    <th>Revenue</th>
                </tr>
                <tr car="MotorCar1">
                    <td>MotorCar1</td>
                    <td>Driver1</td>
                    <td>$100</td>
                </tr>
                <tr car="MotorCar1">
                    <td>MotorCar1</td>
                    <td>Driver2</td>
                    <td>$100</td>
                </tr>
                <tr car="MotorCar2">
                    <td>MotorCar2</td>
                    <td>Driver2</td>
                    <td>$100</td>
                </tr>
                <tr car="MotorCar3">
                    <td>MotorCar3</td>
                    <td>Driver3</td>
                    <td>$100</td>
                </tr>
                <tr car="MotorCar4">
                    <td>MotorCar4</td>
                    <td>Driver3</td>
                    <td>$100</td>
                </tr>
                <tr car="MotorCar5">
                    <td>MotorCar5</td>
                    <td>Driver4</td>
                    <td>$100</td>
                </tr>
                <tr car="MotorCar5">
                    <td>MotorCar5</td>
                    <td>Driver5</td>
                    <td>$100</td>
                </tr>
                <tr car="MotorCar6">
                    <td>MotorCar6</td>
                    <td>Driver6</td>
                    <td>$100</td>
                </tr>
            </table>
        </div>
    </div>
    -->

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
            <div class="revenue-overview">
                <div class="overview-item" style="background-color: #3e98a7;">
                    <h3>Total Cars</h3>
                    <h1>5</h1>
                </div>
                <div class="overview-item" style="background-color: #4fc48e;">
                    <h3>Total Drivers</h3>
                    <h1>2</h1>
                </div>
                <div class="overview-item" style="background-color: #1dbd48;">
                    <h3>Total Revenue</h3>
                    <h1>$4000</h1>
                </div>
            </div>
            <div class="revenue-breakdown">
                <div class="breakdown-section">
                    <div class="heading">
                        <h3>Breakdown by Cars</h3>
                    </div>
                    <div class="data">
                        <table class="table table-striped">
                            <tr>
                                <th>Car</th>
                                <th>Revenue</th>
                            </tr>
                            <tr class="group-row">
                                <td>
                                    <p><i class="fa fa-plus"></i>Car1</p>
                                    <div class="data-names collapsed">
                                        <p>Driver1</p>
                                        <p>Driver2</p>
                                    </div>

                                </td>
                                <td>
                                    <p>$400</p>
                                    <div class="data-values collapsed">
                                        <p>$100</p>
                                        <p>$300</p>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-row">
                                <td>
                                    <p><i class="fa fa-plus"></i>Car2</p>
                                    <div class="data-names collapsed">
                                        <p>Driver2</p>
                                        <p>Driver3</p>
                                    </div>

                                </td>
                                <td>
                                    <p>$400</p>
                                    <div class="data-values collapsed">
                                        <p>$100</p>
                                        <p>$300</p>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-row">
                                <td>
                                    <p><i class="fa fa-plus"></i>Car3</p>
                                    <div class="data-names collapsed">
                                        <p>Driver3</p>
                                    </div>

                                </td>
                                <td>
                                    <p>$100</p>
                                    <div class="data-values collapsed">
                                        <p>$100</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="breakdown-section">
                    <div class="heading">
                        <h3>Breakdown by Drivers</h3>
                    </div>
                    <div class="data">
                        <table class="table table-striped">
                            <tr>
                                <th>Driver</th>
                                <th>Revenue</th>
                            </tr>
                            <tr class="group-row">
                                <td>
                                    <p><i class="fa fa-plus"></i>Driver1</p>
                                    <div class="data-names collapsed">
                                        <p>Car1</p>
                                        <p>Car2</p>
                                    </div>

                                </td>
                                <td>
                                    <p>$400</p>
                                    <div class="data-values collapsed">
                                        <p>$100</p>
                                        <p>$300</p>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-row">
                                <td>
                                    <p><i class="fa fa-plus"></i>Driver2</p>
                                    <div class="data-names collapsed">
                                        <p>Car2</p>
                                        <p>Car3</p>
                                    </div>

                                </td>
                                <td>
                                    <p>$400</p>
                                    <div class="data-values collapsed">
                                        <p>$100</p>
                                        <p>$300</p>
                                    </div>
                                </td>
                            </tr>
                            <tr class="group-row">
                                <td>
                                    <p><i class="fa fa-plus"></i>Driver3</p>
                                    <div class="data-names collapsed">
                                        <p>Car3</p>
                                    </div>

                                </td>
                                <td>
                                    <p>$100</p>
                                    <div class="data-values collapsed">
                                        <p>$100</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="revenue-raw">
                <div class="heading"><h3>All Driver and Car combinations</h3></div>
                <div class="data">
                    <table class="table table-striped">
                        <tr>
                            <th>Car</th>
                            <th>Driver</th>
                            <th>Revenue</th>
                        </tr>
                        <tr>
                            <td>Car1</td>
                            <td>Driver1</td>
                            <td>$100</td>
                        </tr>
                        <tr>
                            <td>Car1</td>
                            <td>Driver2</td>
                            <td>$50</td>
                        </tr>
                        <tr>
                            <td>Car2</td>
                            <td>Driver1</td>
                            <td>$300</td>
                        </tr>
                        <tr>
                            <td>Car3</td>
                            <td>Driver2</td>
                            <td>$300</td>
                        </tr>
                        <tr>
                            <td>Car2</td>
                            <td>Driver3</td>
                            <td>$300</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
           $('.group-row').click(function(){
               $(this).find("[class^=data-]").toggleClass('collapsed');
           });
        });
    </script>

@endsection

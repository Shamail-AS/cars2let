    <div class="card-container">
           <div class="card-container-vertical">
               @for($i = 0; $i < 5; $i++)
                   <div class="card">
                       <div class="tag-header {{$i == 0? 'ongoing' : 'complete'}}">
                           <p>Contract {{$i == 0? 'Ongoing' : 'Completed on '.$i.' June 2016'}}</p>
                       </div>
                       <div class="card-body">
                           <div class="contract">
                               <h3>Contract Overview</h3>
                               <table class="table table-bordered">

                                   <tr>
                                       <td>Start Date</td>
                                       <td>09/10/2016</td>

                                   </tr>
                                   <tr>
                                       <td>End Date</td>
                                       <td>10/11/2017</td>
                                   </tr>
                                   <tr>
                                       <td>Driver</td>
                                       <td>Adam Joshua</td>
                                   </tr>
                                   <tr>
                                       <td>Rent/Week</td>
                                       <td>$280</td>
                                   </tr>
                                   <tr>
                                       <td>Weeks completed</td>
                                       <td>4</td>
                                   </tr>
                                   <tr>
                                       <td>Gross Rent</td>
                                       <td>280 x 4</td>
                                   </tr>
                                   <tr>
                                       <td>Paid to Investor</td>
                                       <td>$2600</td>
                                   </tr>

                               </table>
                               <div class="heading">
                                   <h4>*Subject to adjustments for VAT and other expenses</h4>
                               </div>
                           </div>
                       </div>
                   </div>
               @endfor

        </div>

        <div class="card-container-vertical">
            <div class="card">
                <div class="card-body">
                    <h3>Revenue Overview</h3>
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

            <div class="card">
                <div class="tag-header">
                    <p>Hello</p>
                </div>
                <div class="card-body">
                    <div class="contract">
                        <h3>Current Contract Overview</h3>
                        <table class="table table-bordered">

                            <tr>
                                <td>Start Date</td>
                                <td>09/10/2016</td>

                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td>10/11/2017</td>
                            </tr>
                            <tr>
                                <td>Driver</td>
                                <td>Adam Joshua</td>
                            </tr>
                            <tr>
                                <td>Rent/Week</td>
                                <td>$280</td>
                            </tr>
                            <tr>
                                <td>Weeks completed</td>
                                <td>4</td>
                            </tr>
                            <tr>
                                <td>Gross Rent</td>
                                <td>280 x 4</td>
                            </tr>
                            <tr>
                                <td>Paid to Investor</td>
                                <td>$2600</td>
                            </tr>

                        </table>
                        <div class="heading">
                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>

@include('includes/header')

<body>
    @include('includes/navbar')
    <!-- Main content -->
    <div class="container">
        <div class="page-heading">

       <!--
        Display the error message when logged in user as superadmin
        version doesn't match
        -->
        {{-- @if ( ($user->role == "admin") && env("APP_VERSION") != "1.3" )
            <div class="alert alert-danger" role="alert">
                <b>ERROR: Your database isn't up to date.</b><br/>Please go to the <a href="{{  route('update.get') }}">update</a> page to upgrade your database.</b><br/>
            </div>
            <br/>
        @endif --}}


            <a class="btn btn-default pull-right ml-5" href="{{  route('budget.index') }}"><span><i class="mdi mdi-adjust"></i></span>{{__('overview.button.check-budget')}}</a>
            <div class="heading-content">
                <div class="user-image">
                @if(empty($user->avatar))
                <img src="{{ asset('assets/images/avatar.png') }}" class="img-circle img-responsive">
                @else
                <img src="{{ asset('uploads/avatar/'.$user->avatar) }}" class="img-circle img-responsive">
                @endif
            </div>
            <div class="heading-title">
                <h2>{{__('overview.heading.welcome')}}, {{$user->fname}} {{$user->lname}}</h2>
                    <p>{{__('overview.heading.intro')}}</p>
                </div>
            </div>
        </div>

        <div class="row overview-widgets">
            {{-- <div class="col-md-4">
                @if( $stats['percentage'] < 33 )
                <div class="card bg-green text-white">
                @elseif($stats['percentage'] < 66)
                <div class="card bg-info text-white">
                @elseif($stats['percentage'] < 100)
                <div class="card bg-warning text-white">
                @elseif($stats['percentage'] > 100)
                <div class="card bg-danger text-white">
                @endif
                  <div class="card-header">
                    <h4 class="text-white">{{__('budget.info-box.budget-status')}}</h4>
                  </div>
                  <div class="card-body">
                    <div class="insight-card text-center">

                      @if( $stats['percentage'] < 33 )
                      <h3>{{__('budget.info-box.looking-good')}}, {{ $user->fname }}!</h3>
                      @elseif($stats['percentage'] < 66)
                      <h3>{{__('budget.info-box.good-progress')}}, {{ $user->fname }}!</h3>
                      @elseif($stats['percentage'] < 100)
                      <h3>{{__('budget.info-box.almost-there')}}, {{ $user->fname }}!</h3>
                      @elseif($stats['percentage'] > 100)
                      <h3>{{__('budget.info-box.ooh')}} {{ $user->fname }}!</h3>
                      @endif

                      @if($stats['percentage'] > 100)
                      <p>{{ sprintf(__('budget.info-box.overbudget'), ( ($stats['spent']) ) , ( $stats['percentage'] - 100 )) }}</p>
                      @else
                      <p>{{ sprintf(__('budget.info-box.underbudget'), ( $stats['percentage'] ) , ( 100 - $stats['percentage'] )) }}</p>
                      @endif
                      <a href="{{ route('budget.index') }}" >{{__('budget.links.adjust-budget')}}<span><i class="mdi mdi-hand-pointing-right"></i></span></a>
                    </div>
                  </div>
                </div>
            </div> --}}
          
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('overview.info-box.transactions')}}</h4>
                    </div>
                    <div class="card-body overflow">
                        <div class="transaction-amount">
                            <!-- item -->
                            <div class="transaction-amount-item">
                                <div class="transaction-icon">
                                    <i class="mdi mdi-checkbox-blank-circle text-primary"></i>
                                </div>
                                <div class="transaction-info">
                                    <strong>{{ number_format($stats['income'], 0, ',', '.') . ' ₫' }}</strong>
                                    <span>{{__('overview.info-box.income')}}</span>
                                </div>
                            </div>
                            <!-- item -->
                            <div class="transaction-amount-item">
                                <div class="transaction-icon">
                                    <i class="mdi mdi-checkbox-blank-circle text-danger"></i>
                                </div>
                                <div class="transaction-info">
                                    <strong>{{ number_format($stats['expenses'], 0, ',', '.') . ' ₫' }}</strong>
                                    <span>{{__('overview.info-box.expenses')}}</span>
                                </div>
                            </div>
                            <!-- item -->
                            <div class="transaction-amount-item">
                                <div class="transaction-icon">
                                    <i class="mdi mdi-checkbox-blank-circle text-info"></i>
                                </div>
                                <div class="transaction-info">
                                    <strong>{{ number_format($stats['savings'], 0, ',', '.') . ' ₫' }}</strong>
                                    <span>{{__('overview.info-box.savings')}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="transaction-visual">
                            <div id="transactions" style="height: 200px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('overview.info-box.budget-status')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="transaction-progress">
                            <div class="item mt-5">
                                <strong class="pull-right">{{ number_format($stats['expenseTransactions'], 0, ',', '.') }} {{__('overview.info-box.transactions')}}</strong>
                                <p class="text-muted"> <i class="mdi mdi-checkbox-blank-circle-outline text-info"></i> {{__('overview.info-box.expenses')}}</p>
                                <div class="progress progress-bar-primary-alt">
                                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100" style="width:{{ $stats['expensePercentage'] }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <strong class="pull-right">{{ number_format($stats['incomeTransactions'], 0, ',', '.') }} {{__('overview.info-box.transactions')}}</strong>
                                <p class="text-muted"> <i class="mdi mdi-checkbox-blank-circle-outline text-primary"></i> {{__('overview.info-box.income')}}</p>
                                <div class="progress progress-bar-success-alt">
                                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width:{{ $stats['incomePercentage'] }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row transaction-links">
                                <div class="col-md-12">
                                    <p class="text-center view-all-transaction">{{__('overview.info-box.view-all-transactions')}}</p>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('expense.index') }}" class="btn btn-danger btn-block" type="button">{{__('overview.button.expenses')}}</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('income.index')  }}" class="btn btn-primary btn-block" type="button">{{__('overview.button.income')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="range">
           
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <div class="reportrange" id="reportrange" name="reportrange">
                            <i class="mdi mdi-calendar-text"></i>&nbsp;
                            <span></span>
                            <i class="mdi mdi-menu-down-outline"></i>
                        </div> --}}
                        <div id="reportrange" class="reportrange"   name="reportrange" >
                            <i class="mdi mdi-calendar-text"></i>&nbsp;
                            <span></span>   <i class="mdi mdi-menu-down-outline"></i>
                        </div>
                      
                       
                    
                        <h4><span class="reports-title">{{__('overview.graph.last-30-days')}}</span> {{__('overview.graph.activities')}}</h4>
               
                        <select class="form-control select2" id="accountSelect" style="width:20%!important ">
    <option value="00">Tất cả tài khoản</option>
    @if (!empty($accounts))
        @foreach ($accounts as $account)
            <option value="{{ $account->id }}">{{ $account->name }}</option>
        @endforeach
    @endif
</select>
                       
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 figure-stats">
                                <div class="figure-section">
                                    <p>{{__('overview.graph.total-income')}}</p>
                                    <span class="badge badge-primary pull-right income-count" data-toggle="tooltip" data-original-title="{{__('overview.graph.transactions')}}">{{ $reports['income']['count'] }} {{__('overview.graph.trns')}}</span>
                                    <h2 class="text-primary reports-income">{{ number_format($reports['income']['total'], 0, ',', '.') . ' ₫' }}</h2>
                                </div>
                                <div class="figure-section">
                                    <p>{{__('overview.graph.total-expenses')}}</p>
                                    <span class="badge badge-danger pull-right expenses-count" data-toggle="tooltip" data-original-title="{{__('overview.graph.transactions')}}">{{ $reports['expenses']['count'] }} {{__('overview.graph.trns')}}</span>
                                    <h2 class="text-danger reports-expenses">{{ number_format($reports['expenses']['total'], 0, ',', '.') . ' ₫' }}</h2>
                                </div>
                                <div class="figure-section">
                                    <span class="pull-right text-primary">{{__('overview.graph.amount')}}</span>
                                    <p>{{__('overview.graph.top-expenses')}}</p>
                                    <table>
                                        <tbody class="top-expenses">
                                            @if (!empty($reports['expenses']['top']))
                                            @foreach($reports['expenses']['top'] as $topExpense)
                                              <tr>
                                                <td>{{ $topExpense->title }}</td>
                                                <td class="text-right">{{ number_format($topExpense->amount, 0, ',', '.') . ' ₫' }}</td>
                                              </tr>
                                            @endforeach
                                            @else
                                              <tr>
                                                <td class="text-center">{{__('overview.graph.empty')}}</td>
                                              </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div id="monthly" style="height:360px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- footer -->
        @include('includes/footer')

    </div>

    <!--Add Account-->
    <div class="modal fade" id="create" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('overview.accounts-form.add-title')}}</h4>
                </div>
                <form class="simcy-form" action="{{ route('dashboard.create') }}" data-parsley-validate="" loader="true" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p>{{__('overview.accounts-form.add-intro')}}</p>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('overview.accounts-form.label.name')}}</label>
                                    <input type="text" class="form-control" name="name" placeholder="{{__('overview.accounts-form.placeholder.name')}}" required="">
                                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('overview.accounts-form.label.balance')}}</label>
                                    <span class="input-prefix">VND</span>
                                    <input type="number" class="form-control prefix" step="0.01" data-parsley-pattern="^[+-]?[0-9]*\.[0-9]{2}$" name="balance" placeholder="{{__('overview.accounts-form.placeholder.balance')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('overview.accounts-form.label.type')}}</label>
                                    <select class="form-control select2" name="type">
                                        <option value="Cash">{{__('overview.accounts-form.types.cash')}}</option>
                                        <option value="Bank">{{__('overview.accounts-form.types.bank')}}</option>
                                        <option value="Card">{{__('overview.accounts-form.types.card')}}</option>
                                        <option value="E-Wallet">{{__('overview.accounts-form.types.ewallet')}}</option>
                                        <option value="Other">{{__('overview.accounts-form.types.other')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <label>{{__('overview.accounts-form.label.status')}}</label>
                                    <select class="form-control select2" name="status">
                                        <option value="Active">{{__('overview.accounts-form.status.active')}}</option>
                                        <option value="Inactive">{{__('overview.accounts-form.status.inactive')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('overview.button.close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('overview.button.add-account')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
        <!-- view edit modal -->
    <div class="modal fade" id="update" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="update-form"></div>
      </div>
    </div>

   
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/libs/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('assets/js/simcify.min.js') }}"></script>
    <script src="{{ asset('assets/js/echarts.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
    <!-- custom scripts -->
    <script type="text/javascript">
        const reportsUrl = "{{route('dashboard.getreports')}}";
        // doughnut
        var totalIncome = {{ $stats['income'] }},
            totalExpenses = {{ $stats['expenses'] }},
            totalSavings = {{ $stats['savings'] }},
            currency = "VND",
            expense_title = "{{__('overview.info-box.expenses')}}",
            income_title = "{{__('overview.info-box.income')}}";
        //Date range labels
        var today = "{{__('overview.date-range-label.today')}}",
            yesterday = "{{__('overview.date-range-label.yesterday')}}",
            last_7_days = "{{__('overview.date-range-label.last-7-days')}}",
            last_30_days = "{{__('overview.date-range-label.last-30-days')}}",
            this_month = "{{__('overview.date-range-label.this-month')}}",
            last_month = "{{__('overview.date-range-label.last-month')}}",
            custom_range = "{{__('overview.date-range-label.custom-range')}}",
            apply = "{{__('overview.date-range-label.apply')}}",
            cancel = "{{__('overview.date-range-label.cancel')}}";
  <?php 
  $labels = json_encode($reports['chart']['label'], JSON_UNESCAPED_UNICODE);
  ?>
      // graph
      var labels =  <?=$labels ?>;
      
      var income = [{{ implode(', ', $reports['chart']['income']) }}];
      var expenses = [{{ implode(', ', $reports['chart']['expenses']) }}];
  
    
    </script>
    
    <script src="{{ asset('assets/js/overview.js') }}"></script>

  
   
    
</body>

</html>
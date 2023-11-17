@include('includes/header')

<body>
    @include('includes/navbar')
    <!-- Main content -->
    <div class="container">
        <div class="page-heading">
            {{-- <button class="btn btn-default pull-right ml-5" type="button" data-toggle="modal" data-target="#create"
                data-backdrop="static" data-keyboard="false"><span><i class="mdi mdi-adjust"></i></span>
                {{__('budget.button.adjust')}} </button> --}}
                <button class="btn btn-primary pull-right ml-5" type="button" data-toggle="modal"
                data-target="#addLimit"><span><i class="mdi mdi-plus-circle-outline"></i></span>
                Thêm hạn mức chi</button>
            <div class="heading-content">
                <div class="user-image">
                    @if(empty($user->avatar))
                    <img src="{{ asset('assets/images/avatar.png') }}" class="img-circle img-responsive">
                    @else
                    <img src="{{ asset('uploads/avatar/'.$user->avatar) }}" class="img-circle img-responsive">
                    @endif
                </div>
                <div class="heading-title">
                    <h2>{{__('budget.heading.welcome')}}, {{$user->fname}} {{$user->lname}}</h2>
                    <p>{{__('budget.heading.intro')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {{-- <div class="card">
              <div class="card-header">
                <h4>{{__('budget.budget-graph.budgeting-chart')}}</h4>
            </div>
            <div class="card-body">
                <div id="container" style="height: 400px"></div>
            </div>
        </div> --}}
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>{{ date("M") }} {{__('budget.budget-table.budgeting-goals')}}</h4>
                    </div>
                    <div class="col-md-6">
             
                    </div>

                </div>


            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display table-striped" id="datatable">

                        <tbody>
                            <tr>
                                <td></td>
                                <td>Tên hạn mức chi</td>
                                <td>Tên hạng mục</td>
                                <td>Đã tiêu</td>
                                <td>Đặt mục tiêu</td>
                                <td>Thời hạn</td>
                                <td>Tiến trình</td>
                                <td></td>

                            </tr>
                            @php
                            $i=1;
                            @endphp
                            @foreach($budgets1 as $key => $budget)
                          
                            @if($budget->budget == 0 )

                            @elseif($budget->spent <= $budget->budget )
                                @php
                                $cash = DB::table('cashlimit')->where('category', $budget->id)->first();
                                @endphp
                                @if($cash)
                                <tr>
                                    <td><span class="badge badge-success">{{ $i++ }}</span></td>
                                    <td width="150">{{ $cash->title }}</td>
                                    <td><strong>{{ $budget->name }}</strong><br></td>
                                    <td><strong>{{ number_format($budget->spent, 0, ',', '.') . ' ₫'}}</strong><br></td>
                                    <td><strong>{{ number_format($budget->budget, 0, ',', '.') . ' ₫' }}</strong><br></span>
                                    </td>
                                    @if(strtotime($cash->endday) >= time())
                                    <td>{{ date_format(date_create($cash->startday), 'd/m/Y') }} -
                                        {{ date_format(date_create($cash->endday), 'd/m/Y')  }}
                                    </td>
                                    @else
                                    <td>{{ date_format(date_create($cash->startday), 'd/m/Y') }} -
                                        {{ date_format(date_create($cash->endday), 'd/m/Y')  }}
                                        <div class="text-danger">
                                            Hết hạn
                                        </div>
                                    </td>
                                    @endif
                                    <td>
                                        <div>
                                            <strong
                                                class="pull-right">{{ number_format($budget->spent, 0, ',', '.') . ' ₫' }}
                                                / {{ number_format($budget->budget, 0, ',', '.') . ' ₫' }}</strong>
                                            <span>{{__('budget.budget-table.progress')}}</span>
                                            <div class="progress progress-bar-success-alt">
                                                <div class="progress-bar progress-bar-success progress-bar-striped"
                                                    role="progressbar" aria-valuenow="{{ $budget->percentage }}"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width:{{ $budget->percentage }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button"
                                                data-toggle="dropdown">{{ __('expenses.expense-table.actions') }}
                                                <span class="caret"></span> </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="c-dropdown__item dropdown-item fetch-display-click"
                                                        data="cashid:{{ $cash->id }}"
                                                        href="{{ route('budget.edit',$cash->id) }}"><i
                                                            class="mdi mdi-pencil"></i>
                                                        {{ __('expenses.expense-table.edit') }}</a></li>
                                                <li>
                                                    <form method="POST"
                                                        action="{{ route('budget.destroy', $cash->id) }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="hidden" name="cashid" value="{{ $cash->id }}">
                                                        <input type="hidden" name="category" value="{{ $budget->id }}">
                                                        <button type="submit"
                                                            onclick="return confirm('Bạn có chắc muốn xóa hạn mức chi này?')"
                                                            class="send-to-server-click btn-delete"
                                                            data="cashid:{{ $cash->id }}" loader="true">
                                                            <i class="mdi mdi-delete" style="margin-right: 10px;"></i>
                                                            {{ __('expenses.expense-table.delete') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                @endif
                                @elseif($budget->spent > $budget->budget )
                                @php
                                $cash = DB::table('cashlimit')->where('category', $budget->id)->first();
                                @endphp
                                @if($cash)
                                <tr>
                                    <td><span class="badge badge-success">{{ $i + 1 }}</span></td>
                                    <td width="150">{{ $cash->title }}</td>
                                    <td><strong>{{ $budget->name }}</strong><br></td>
                                    <td><strong>{{ number_format($budget->spent, 0, ',', '.') . ' ₫'}}</strong><br></td>
                                    <td><strong>{{ number_format($budget->budget, 0, ',', '.') . ' ₫' }}</strong><br></span>
                                    </td>
                                    @if(strtotime($cash->endday) >= time())
                                    <td>{{ date_format(date_create($cash->startday), 'd/m/Y') }} -
                                        {{ date_format(date_create($cash->endday), 'd/m/Y')  }}
                                    </td>
                                    @else
                                    <td>{{ date_format(date_create($cash->startday), 'd/m/Y') }} -
                                        {{ date_format(date_create($cash->endday), 'd/m/Y')  }}
                                        <div class="text-danger">
                                            Hết hạn
                                        </div>
                                    </td>
                                    @endif
                                    <td>
                                        <div>
                                            <strong
                                                class="pull-right">{{ number_format($budget->spent, 0, ',', '.') . ' ₫' }}
                                                / {{ number_format($budget->budget, 0, ',', '.') . ' ₫' }}</strong>
                                            <span>{{__('budget.budget-table.progress')}}</span>
                                            <div class="progress progress-bar-danger-alt">
                                                <div class="progress-bar progress-bar-danger progress-bar-striped"
                                                    role="progressbar" aria-valuenow="{{ $budget->percentage }}"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width:{{ $budget->percentage }}%">
                                                </div>
                                            </div>
                                            <div id="error-toast" class="toast bg-danger">
                                                <div class="toast-body text-white text-center">
                                                    {{ __('budget.messages.over-spending') }}:
                                                    {{ number_format($budget->spent - $budget->budget, 0, ',', '.') . ' ₫' }}
                                                </div>
                                            </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button"
                                                data-toggle="dropdown">{{ __('expenses.expense-table.actions') }}
                                                <span class="caret"></span> </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="c-dropdown__item dropdown-item fetch-display-click"
                                                        data="cashid:{{ $cash->id }}"
                                                        href="{{ route('budget.edit',$cash->id) }}"><i
                                                            class="mdi mdi-pencil"></i>
                                                        {{ __('expenses.expense-table.edit') }}</a></li>
                                                <li>
                                                    <form method="POST"
                                                        action="{{ route('budget.destroy', $cash->id) }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="hidden" name="cashid" value="{{ $cash->id }}">
                                                        <input type="hidden" name="category" value="{{ $budget->id }}">
                                                        <button type="submit"
                                                            onclick="return confirm('Bạn có chắc muốn xóa hạn mức chi này?')"
                                                            class="send-to-server-click btn-delete"
                                                            data="cashid:{{ $cash->id }}" loader="true">
                                                            <i class="mdi mdi-delete" style="margin-right: 10px;"></i>
                                                            {{ __('expenses.expense-table.delete') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endif
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-3">
            <div class="card">
              <div class="card-header">
                <h4>{{ date("M") }} {{__('budget.info-box.budget-usage')}}</h4>
    </div>
    <div class="card-body">
        <section class="text-center mt-15">
            <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200"
                xmlns="http://www.w3.org/2000/svg">
                <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431"
                    cy="16.91549431" r="15.91549431" />
                <circle class="circle-chart__circle" stroke="#F4BE4A" stroke-width="2"
                    stroke-dasharray="{{ $stats['percentage'] }},100" stroke-linecap="round" fill="none"
                    cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                    <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central"
                        text-anchor="middle" font-size="8">{{ $stats['percentage'] }}%</text>
                    <text class="circle-chart__subline" x="16.91549431" y="20.5" alignment-baseline="central"
                        text-anchor="middle" font-size="2"> {{ number_format($stats['spent'], 0, ',', '.') . ' ₫' }}
                        {{__('budget.info-box.spent')}}</text>
                </g>
            </svg>
            <div class="chart-insights">
                <p>{{__('budget.info-box.you-have-spent')}}</p>
                <h4><strong>{{ number_format($stats['spent'], 0, ',', '.') . ' ₫' }}</strong>
                    {{__('budget.info-box.out-of')}}
                    <strong>{{ number_format($user->monthly_spending, 0, ',', '.') . ' ₫' }}</strong></h4>
            </div>
        </section>
        <div></div>
    </div>
    </div>


    @if( $stats['percentage'] < 33 ) <div class="card bg-green text-white">
        @elseif($stats['percentage'] < 66) <div class="card bg-info text-white">
            @elseif($stats['percentage'] < 100) <div class="card bg-warning text-white">
                @elseif($stats['percentage'] > 100)
                <div class="card bg-danger text-white">
                    @endif
                    <div class="card-header">
                        <h4 class="text-white">{{__('budget.info-box.budget-status')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="insight-card text-center">

                            @if( $stats['percentage'] < 33 ) <h3>{{__('budget.info-box.looking-good')}},
                                {{ $user->fname }}!</h3>
                                @elseif($stats['percentage'] < 66) <h3>{{__('budget.info-box.good-progress')}},
                                    {{ $user->fname }}!</h3>
                                    @elseif($stats['percentage'] < 100) <h3>{{__('budget.info-box.almost-there')}},
                                        {{ $user->fname }}!</h3>
                                        @elseif($stats['percentage'] > 100)
                                        <h3>{{__('budget.info-box.ooh')}} {{ $user->fname }}!</h3>
                                        @endif

                                        @if($stats['percentage'] > 100)
                                        <p>{{ sprintf(__('budget.info-box.overbudget'), ( number_format($stats['spent'], 0, ',', '.') . ' ₫') , ( $stats['percentage'] - 100 )) }}
                                        </p>
                                        @else
                                        <p>{{ sprintf(__('budget.info-box.underbudget'), ( $stats['percentage'] ) , ( 100 - $stats['percentage'] )) }}
                                        </p>
                                        @endif
                                        <a href="{{ route('budget.index') }}">{{__('budget.links.adjust-budget')}}<span><i
                                                    class="mdi mdi-hand-pointing-right"></i></span></a>
                        </div>
                    </div>
                </div>
                </div> --}}
                </div>
                <!-- footer -->

                </div>

                <!--Record Income-->
                <div class="modal budget fade" id="create" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form class="simcy-form" action="{{ route('budget.adjust') }}" data-parsley-validate=""
                                loader="true" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="tab-content">
                                        <div id="adjust" class="tab-pane fade in active">
                                            <div class="row">
                                                <div class="col-md-6 float-center">
                                                    <div class="adjust-info text-center">
                                                        @if(empty($user->avatar))
                                                        <img src="{{ asset('assets/images/avatar.png') }}"
                                                            class="img-circle img-responsive">
                                                        @else
                                                        <img src="{{ asset('uploads/avatar/'.$user->avatar) }}"
                                                            class="img-circle img-responsive">
                                                        @endif
                                                        <h2>{{ sprintf(__('budget.budget-form.title'), $user->fname)}}
                                                        </h2>
                                                        <p>{{__('budget.budget-form.intro')}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8 float-center">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>{{__('budget.budget-form.label.spend-month')}}</label>
                                                                <span class="input-prefix">VNĐ</span>
                                                                <input type="number" class="form-control prefix"
                                                                    name="monthly_spending" oninput="updateSpan()"
                                                                    id="monthly_spending"
                                                                    data-parsley-pattern="^[0-9]*\$"
                                                                    value="{{ $user->monthly_spending }}"
                                                                    placeholder="i.e 4000" required>
                                                                <span
                                                                    class="help">{{__('budget.budget-form.label.per-month')}}</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>{{__('budget.budget-form.label.spend-annual')}}</label>
                                                                <span class="input-prefix">VNĐ</span>
                                                                <input type="number" class="form-control prefix"
                                                                    name="annual_spending"
                                                                    data-parsley-pattern="^[0-9]*\$"
                                                                    value="{{ $user->annual_spending }}"
                                                                    placeholder="i.e 12000" id="annualspend" required>
                                                                <span
                                                                    class="help">{{__('budget.budget-form.label.per-year')}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>{{__('budget.budget-form.label.save-month')}}</label>
                                                                <span class="input-prefix">VNĐ</span>
                                                                <input type="number" class="form-control prefix"
                                                                    name="monthly_saving"
                                                                    data-parsley-pattern="^[0-9]*\$"
                                                                    value="{{ $user->monthly_saving }}"
                                                                    placeholder="i.e 4000" required>
                                                                <span
                                                                    class="help">{{__('budget.budget-form.label.per-month')}}</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>{{__('budget.budget-form.label.earn-month')}}</label>
                                                                <span class="input-prefix">VNĐ</span>
                                                                <input type="number" class="form-control prefix"
                                                                    name="monthly_earning"
                                                                    data-parsley-pattern="^[0-9]*\$"
                                                                    value="{{ $user->monthly_earning }}"
                                                                    placeholder="i.e 12000" required>
                                                                <span
                                                                    class="help">{{__('budget.budget-form.label.per-month')}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="adjust-actions text-center">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal"><span><i
                                                            class="mdi mdi-close-circle-outline"></i></span>
                                                    {{__('budget.button.cancel')}}</button>
                                                <button type="submit" class="btn btn-primary" data-toggle="tab"
                                                    href="#distribute"><span><i
                                                            class="mdi mdi-source-branch"></i></span>
                                                    {{__('budget.button.distribute')}}</button>
                                            </div>
                                        </div>
                                        @if( $stats['allocated'] > $user->monthly_spending )
                                        <div id="distribute" class="tab-pane fade exceeded">
                                            @else
                                            <div id="distribute" class="tab-pane fade">
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-8 float-center">
                                                        <a data-toggle="tab" href="#adjust">
                                                            <h2><i class="mdi mdi-arrow-left-thick"></i></h2>
                                                        </a>
                                                        <div class="adjust-info text-center">
                                                            <h2>{{__('budget.distribute-form.title')}}</h2>
                                                            @if( $stats['allocated'] > $user->monthly_spending )
                                                            <p class="adjust-text"><span
                                                                    class="text-danger">{{__('budget.distribute-form.error')}}</span>
                                                            </p>
                                                            @else
                                                            <p class="adjust-text">
                                                                {{__('budget.distribute-form.intro')}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 float-center">
                                                        <div class="distribute">
                                                            @if(!empty($categories))
                                                            @foreach($categories as $category)
                                                            <div class="distribute-input">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <strong class="pull-right"><span
                                                                                    class="allocated-budget">{{ number_format($category->budget, 0, ',', '.') . ' ₫' }}
                                                                                </span> /
                                                                                <span>{{ number_format($user->monthly_spending, 0, ',', '.') . ' ₫' }}</span></strong>
                                                                            {{-- //class="total-budget" --}}
                                                                            <label>{{ $category->name }}</label>
                                                                            <input type="hidden" name="category[]"
                                                                                value="{{ $category->id }}">
                                                                            <input class="budget-slider" type="text"
                                                                                name="budget[]" data-slider-min="0"
                                                                                data-slider-step="1"
                                                                                data-slider-value="{{ $category->budget }}"
                                                                                data-slider-max="{{ $user->monthly_spending }}" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @else
                                                            <div class="distribute-input">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-12 text-center">
                                                                            {{__('budget.distribute-form.none')}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="adjust-actions text-center">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><span><i
                                                                class="mdi mdi-close-circle-outline"></i></span>
                                                        {{__('budget.button.cancel')}}</button>
                                                    <button class="btn btn-primary" type="submit"><span><i
                                                                class="mdi mdi-content-save"></i></span>
                                                        {{__('budget.button.save-changes')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal fade" id="addLimit" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Thêm hạn mức chi</h4>
                            </div>
                            <form class="simcy-form" action="{{ route('budget.add') }}" data-parsley-validate=""
                                loader="true" method="POST" enctype="multipart/form-data"
                                onsubmit="return kiemTraNgay()">
                                @csrf

                                <div class="modal-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>{{ __('expenses.expense-form.label.title') }}</label>
                                                <input type="text" class="form-control" name="title"
                                                    placeholder="{{ __('expenses.expense-form.placeholder.title') }}"
                                                    required="">
                                                {{-- <input type="hidden" name="csrf-token" value="{{csrf_token()}}" />
                                                --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>{{ __('expenses.expense-form.label.amount') }}</label>
                                                <span class="input-prefix">VND</span>
                                                <input type="number" class="form-control prefix" step="1"
                                                    data-parsley-pattern="^[0-9]$" min="1000" name="amount"
                                                    placeholder="Amount" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>{{ __('expenses.expense-form.label.account') }}</label>
                                                <select class="form-control select2" name="account">
                                                    <option value="00">Tất cả tài khoản
                                                    </option>
                                                    @if (!empty($accounts))
                                                    @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 ">
                                                <label>{{ __('expenses.expense-form.label.category') }}</label>
                                                <select class="form-control select2" name="category" id="category" required>
                                                    <option value="">Chọn hạng mục
                                                    </option>
                                                    @if (!empty($categories))
                                                    @foreach ($categories as $key => $val)

                                                    <option value="{{ $val->id }}">
                                                        @php
                                                        $str = '';
                                                        for ($i = 0; $i < $val->level; $i++) {
                                                            echo $str;
                                                            $str .= '---- ';
                                                            }
                                                            @endphp
                                                            {{ $val->name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                   
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Ngày bắt dầu</label>
                                                <input type="date" class="form-control datepicker" name="start_date"
                                                    id="start" placeholder="" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Ngày kểt thúc</label>
                                                <input type="date" class="form-control datepicker" name="end_date"
                                                    id="end" placeholder="">

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default"
                                        data-dismiss="modal">{{ __('expenses.button.close') }}</button>
                                    <button type="submit" class="btn btn-primary">Lưu hạn mức</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <!--update Income-->
                <div class="modal budget fade" id="update" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="updateform"></div>
                        </div>
                    </div>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var toast = document.getElementById('error-toast');
                    if (toast) {
                        var toastInstance = new bootstrap.Toast(toast);
                        toastInstance.show();
                    }
                });

                function updateSpan() {
                    // Lấy giá trị từ input1
                    var input1Value = document.getElementById('monthly_spending').value;

                    // Cập nhật nội dung của thẻ span
                    document.getElementById('spanOutput').textContent = input1Value;
                }
                </script>

                <!-- scripts -->
                {{-- <script src="{{ route('') }}lang/{{env('APP_LOCALE_DEFAULT')}}/simcify-lang.js"></script>
                <!-- js language translation --> --}}
                {{-- <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
                <script src="{{asset('assets/libs/bootstrap/js/bootstrap.min.js')}}"></script>
                <script src="{{asset('assets/libs/slider/bootstrap-slider.min.js')}}"></script>
                <script src="{{asset('assets/js//jquery.slimscroll.min.js')}}"></script>
                <script src="{{asset('assets/js/simcify.min.js')}}"></script>
                <script src="{{asset('assets/js/echarts.min.js')}}"></script>
                <!-- custom scripts -->
                <script src="{{asset('assets/js/budget.js')}}"></script>
                <script src="{{asset('assets/js/app.js')}}"></script> --}}
                <script type="text/javascript">
                var subtext = "{{ date('F Y', strtotime(date('Y-m').' -1 month')) }} vs {{ date('F Y') }}";
                var heading = "{{__('budget.budget-graph.budgeting-chart')}}";
                var keyText = "{{__('budget.budget-graph.budgeting')}}";
                </script>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            @include('includes/footer')
                        </div>
                    </div>
                </div>
                <script>
                <?php
if(isset($stats['thismonth'])) {
  $thisMonth = json_encode($stats['thismonth'], JSON_UNESCAPED_UNICODE);
}else {
  $thisMonth = 0;
}
if(isset($stats['lastmonth'])) {
  $lastMonth = json_encode($stats['lastmonth'], JSON_UNESCAPED_UNICODE);
} else {
  $lastMonth =0;
}
?>
                var thisMonth = <?= $thisMonth ?>;
                var lastMonth = <?= $lastMonth ?>;
                </script>

</body>

</html>
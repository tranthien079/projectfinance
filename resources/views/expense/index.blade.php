@include('includes/header')

<body>
    @include('includes/navbar')
    <!-- Main content -->
    <div class="container">
        <div class="page-heading">
            <button class="btn btn-primary pull-right ml-5" type="button" data-toggle="modal"
                data-target="#addExpense"><span><i class="mdi mdi-plus-circle-outline"></i></span>
                {{ __('expenses.button.add-expense') }}</button>
            <div class="heading-content">
                <div class="user-image">
                    @if (empty($user->avatar))
                        <img src="{{ asset('assets/images/avatar.png') }}" class="img-circle img-responsive">
                    @else
                        <img src="{{ asset('uploads/avatar/' . $user->avatar) }}" class="img-circle img-responsive">
                    @endif
                </div>
                <div class="heading-title">
                    <h2>{{ __('expenses.heading.welcome') }}, {{ $user->fname }} {{ $user->lname }}</h2>
                    <p>{{ __('expenses.heading.intro') }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('expenses.expense-table.expense-records') }}</h4>
                     
                    </div>
                    <div class="card-body">
                        <div class="table-responsive longer">
                            <table class="table display" id="datatable">
                                <thead>
                                    <tr>
                                        <th width="40%">{{ __('expenses.expense-table.name') }}</th>
                                        <th>{{ __('expenses.expense-table.date') }}</th>
                                        <th>{{ __('expenses.expense-table.amount') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($expensessss) > 0)
                                        @php
                                            $categories = [];
                                        @endphp
                                        @foreach ($expensessss as $expense)
                                            <tr>
                                                <td><strong>{{ __('expenses.title-expense.name') }}:
                                                        {{ $expense->title }}</strong><br />
                                                    <span
                                                        class="text-danger">{{ __('expenses.title-expense.category-expense') }}
                                                        :

                                                        @foreach ($expense->expenseDetail as $detail)
                                                            <span
                                                                class="text-danger">{{ $detail->category->name }},</span>
                                                        @endforeach

                                                        <br>
                                                        @foreach ($account as $ac)
                                                            @if ($ac->id == $expense->account)
                                                                <span>{{ __('expenses.title-expense.resource-expense') }}:
                                                                    {{ $ac->name }}<br /></span>
                                                            @endif
                                                        @endforeach
                                                        {{-- @if (empty($expense->account))
                                        <span>{{__('expenses.title-expense.resource-expense')}}: {{__('expenses.expense-table.other')}}<br/></span>
                                        @else
                                        <span>{{__('expenses.title-expense.resource-expense')}}: {{ $expense->account}}<br/></span>
                                        @endif --}}
                                                </td>
                                                <td><span>{{ date('M d, Y', strtotime($expense->expense_date)) }}</span>
                                                </td>
                                                <td><strong>{{ number_format($expense->amount, 0, ',', '.') . ' ₫' }}</strong>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-default dropdown-toggle" type="button"
                                                            data-toggle="dropdown">{{ __('expenses.expense-table.actions') }}
                                                            <span class="caret"></span> </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="c-dropdown__item dropdown-item fetch-display-click"
                                                                    data="expenseid:{{ $expense->id }}"
                                                                    href="{{ route('expense.edit', $expense->id) }}"><i
                                                                        class="mdi mdi-pencil"></i>
                                                                    {{ __('expenses.expense-table.edit') }}</a></li>
                                                            {{-- <li><a class="send-to-server-click" data="csrf-token:{{csrf_token()}}|expenseid:{{$expense->id}}" url="{{ url('Expenses@delete') }}" warning-title="{{__('expenses.messages.are-you-sure')}}" warning-message="{{__('expenses.messages.delete')}}" warning-button="{{__('expenses.messages.continue')}}" loader="true"><i class="mdi mdi-delete"></i> {{__('expenses.expense-table.delete')}}</a></li> --}}
                                                            <li>
                                                                <form method="POST"
                                                                    action="{{ route('expense.destroy', $expense->id) }}">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <input type="hidden" name="expenseid"
                                                                        value="{{ $expense->id }}">
                                                                    <button type="submit"
                                                                        onclick="return confirm('Bạn có chắc muốn xóa khoản chi này?')"
                                                                        class="send-to-server-click btn-delete"
                                                                        data="expenseid:{{ $expense->id }}"
                                                                        loader="true">
                                                                        <i class="mdi mdi-delete"
                                                                            style="margin-right: 10px;"></i>
                                                                        {{ __('expenses.expense-table.delete') }}
                                                                    </button>
                                                                </form>
                                                                {{-- <a href="{{ route('income.destroy', $Income->id) }}" class="c-dropdown__item dropdown-item fetch-display-click btn-delete" onclick="return confirm('Bạn có chắc muốn xóa khoản thu này?')">
                                              <i class="mdi mdi-delete"></i> {{ __('income.income-table.delete') }}
                                            </a> --}}

                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                {{ __('expenses.expense-table.empty') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ date('M') }} {{ __('expenses.info-box.budget-usage') }}</h4>
                        
                    </div>
                    <div class="card-body">
                        <section class="text-center mt-15">
                            <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200"
                                height="200" xmlns="http://www.w3.org/2000/svg">
                                <circle class="circle-chart__background" stroke="#efefef" stroke-width="2"
                                    fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                                <circle class="circle-chart__circle" stroke="#F4BE4A" stroke-width="2"
                                    stroke-dasharray="{{ $stats['percentage'] }},100" stroke-linecap="round"
                                    fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                                <g class="circle-chart__info">
                                    <text class="circle-chart__percent" x="16.91549431" y="15.5"
                                        alignment-baseline="central" text-anchor="middle"
                                        font-size="8">{{ $stats['percentage'] }}%</text>
                                    <text class="circle-chart__subline" x="16.91549431" y="20.5"
                                        alignment-baseline="central" text-anchor="middle" font-size="2">
                                        {{ number_format($stats['spent'], 0, ',', '.') . ' ₫' }}
                                        {{ __('expenses.info-box.spent') }}</text>
                                </g>
                            </svg>
                            <div class="chart-insights">
                                <p>{{ __('expenses.info-box.you-have-spent') }}</p>
                                <h4><strong>{{ number_format($stats['spent'], 0, ',', '.') . ' ₫' }}</strong>
                                    {{ __('expenses.info-box.out-of') }}
                                    <strong>{{ number_format($user->monthly_spending, 0, ',', '.') . ' ₫' }}</strong>
                                </h4>
                            </div>
                        </section>
                        <div></div>
                    </div>
                </div>


                @if ($stats['percentage'] < 33)
                    <div class="card bg-green text-white">
                    @elseif($stats['percentage'] < 66)
                        <div class="card bg-info text-white">
                        @elseif($stats['percentage'] < 100)
                            <div class="card bg-warning text-white">
                            @elseif($stats['percentage'] > 100)
                                <div class="card bg-danger text-white">
                @endif
                <div class="card-header">
                    <h4 class="text-white">{{ __('expenses.info-box.budget-status') }}</h4>
                </div>
                <div class="card-body">
                    <div class="insight-card text-center">

                        @if ($stats['percentage'] < 33)
                            <h3>{{ __('expenses.info-box.looking-good') }}, {{ $user->fname }}!</h3>
                        @elseif($stats['percentage'] < 66)
                            <h3>G{{ __('expenses.info-box.good-progress') }}, {{ $user->fname }}!</h3>
                        @elseif($stats['percentage'] < 100)
                            <h3>{{ __('expenses.info-box.almost-there') }}, {{ $user->fname }}!</h3>
                        @elseif($stats['percentage'] > 100)
                            <h3>{{ __('expenses.info-box.ooh') }} {{ $user->fname }}!</h3>
                        @endif

                        @if ($stats['percentage'] > 100)
                            <p>{{ sprintf(__('expenses.info-box.overbudget'), number_format($stats['spent'], 0, ',', '.') . ' ₫', $stats['percentage'] - 100) }}
                            </p>
                        @else
                            <p>{{ sprintf(__('expenses.info-box.underbudget'), $stats['percentage'], 100 - $stats['percentage']) }}
                            </p>
                        @endif
                        <a href="{{ route('budget.index') }}">{{ __('expenses.links.adjust-budget') }}<span><i
                                    class="mdi mdi-hand-pointing-right"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- footer -->

    </div>


    <!-- view edit modal -->
    <div class="modal fade" id="update" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="update-form"></div>
        </div>
    </div>
    <div class="modal fade" id="addExpense" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('expenses.expense-form.add-title') }}</h4>
                </div>
                <form class="simcy-form" action="{{ route('expense.add') }}" data-parsley-validate=""
                    loader="true" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <p>{{ __('expenses.expense-form.add-intro') }}</p>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{ __('expenses.expense-form.label.title') }}</label>
                                    <input type="text" class="form-control" name="title"
                                        placeholder="{{ __('expenses.expense-form.placeholder.title') }}"
                                        required="">
                                    {{-- <input type="hidden" name="csrf-token" value="{{csrf_token()}}" /> --}}
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
                                        <option value="00">{{ __('expenses.expense-form.account.other') }}
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
                                    <select class="form-control select2" name="category[]" id="categorySelect" multiple="multiple">
                                        {{-- @if (!empty($categories)) --}}
                                            @foreach ($categoryDefault as $key => $val)
                                               
                                                <option value="{{ $val->id }}">
                                                    @php
                                                    $str = '';
                                                    for ($i = 0; $i < $val->level; $i++) {
                                                        echo $str;
                                                        $str .= '----  ';
                                                    }
                                                @endphp
                                                    {{ $val->name }}
                                                </option>
                                            @endforeach
                                        {{-- @endif --}}
                                        {{-- <option value="00">{{ __('expenses.expense-form.category.other') }}
                                        </option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{ __('expenses.expense-form.label.date') }}</label>
                                    <input type="date" class="form-control datepicker" name="expense_date"
                                        placeholder="{{ __('expenses.expense-form.placeholder.date') }}"
                                        required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{ __('expenses.expense-form.label.directory') }}</label>
                                    <input type="text" class="form-control" name="directory"
                                        placeholder="{{ __('expenses.expense-form.placeholder.directory') }}" >
                                    @if (!empty($directorys))
                                        <label>{{ __('expenses.expense-form.label.available') }}</label>
                                        <select class="form-control select2" name="directoryMul[]" id="directorySelect" multiple="multiple">
                                           
                                                @foreach ($directorys as $dir)
                                                    <option value="{{ $dir->id }}">{{ $dir->name }}</option>
                                                @endforeach
                                            
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{ __('expenses.expense-form.label.description') }}</label>
                                    <input type="text" class="form-control " name="description"
                                        placeholder="{{ __('expenses.expense-form.placeholder.description') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ __('expenses.button.close') }}</button>
                        <button type="submit"
                            class="btn btn-primary">{{ __('expenses.button.save-expense') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    @include('includes/footer')

</body>

</html>

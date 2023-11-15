@include('includes/header')
<body>
@include('includes/navbar')
<!-- Main content -->
 <div class="container">
    <div class="page-heading">
        <button class="btn btn-primary pull-right ml-5" type="button" data-toggle="modal" data-target="#create"><span><i class="mdi mdi-plus-circle-outline"></i></span>{{__('account.button.add-account')}}</button>
        <div class="heading-content">
            <div class="user-image">
                @if(empty($user->avatar))
                <img src="{{ asset('assets/images/avatar.png') }}" class="img-circle img-responsive">
                @else
                <img src="{{ asset('uploads/avatar/'.$user->avatar) }}" class="img-circle img-responsive">
                @endif
            </div>
            <div class="heading-title">
                <h2>{{__('account.heading.welcome')}}, {{$user->fname}} {{$user->lname}}</h2>
                <p>{{__('account.heading.intro')}}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                 
                    <h4>{{__('account.accounts-table.accounts')}}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive longer">
                        <table class="table display" id="datatable">
                            <tbody>
                                @if(!empty($accounts))
                                @foreach($accounts as $account)
                                <tr>
                                    <td class="text-center">
                                        <div class="icon-account"><i class="mdi mdi-briefcase"></i></div>
                                    </td>
                                    <td><strong>{{ $account->name }}</strong>
                                        <br><span>
                                            @if($account->type == 'Cash')
                                                {{__('overview.accounts-form.types.cash')}}
                                            @elseif($account->type == 'Bank')
                                                {{__('overview.accounts-form.types.bank')}}
                                            @elseif($account->type == 'Card')
                                                {{__('overview.accounts-form.types.card')}}
                                            @elseif($account->type == 'E-Wallet')
                                                {{__('overview.accounts-form.types.ewallet')}}
                                            @elseif($account->type == 'Other')
                                                {{__('overview.accounts-form.types.other')}}
                                            @else
                                                {{ $account->type }}
                                            @endif
                                        </span></td>
                                    <td><strong>{{ number_format($account->balance, 0, ',', '.') . ' ₫'  }}</strong>
                                        <br><span>{{__('overview.accounts-table.balance')}}</span></td>
                                    <td><strong>{{ $account->transactions }}</strong>
                                        <br><span>{{__('overview.accounts-table.transactions')}}</span></td>
                                    <td><strong>{{date_format(date_create($account->updated_at), 'd/m/Y') }}</strong>
                      
                                        <br><span>{{__('overview.accounts-table.updated-on')}}</span></td>
                                    {{-- <td>
                                        @if($account->status == 'Active')
                                        <strong class="text-primary"><i class="mdi mdi-checkbox-blank-circle"></i> {{__('overview.accounts-table.active')}}</strong>
                                        @else
                                        <strong class="text-danger"><i class="mdi mdi-checkbox-blank-circle"></i> {{__('overview.accounts-table.inactive')}}</strong>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">{{__('overview.accounts-table.actions')}}<span class="caret"></span> </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="c-dropdown__item dropdown-item fetch-display-click"  data="incomeid:{{$account->id}}"  href="{{ route('account.edit',$account->id)}}"><i class="mdi mdi-pencil"></i> {{__('overview.accounts-table.edit')}}</a></li>
                                                <li> 
                                                    <form method="POST" action="{{route('account.destroy',$account->id)}}" >
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa nguồn tiền này?')" class="send-to-server-click btn-delete"  data="accountid:{{$account->id}}" loader="true">
                                                      <i class="mdi mdi-delete" style="margin-right: 10px;"></i> {{__('overview.accounts-table.delete')}}
                                                    </button>
                                                  </form>
                                                  {{-- <a href="{{ route('income.destroy', $Income->id) }}" class="c-dropdown__item dropdown-item fetch-display-click btn-delete" onclick="return confirm('Bạn có chắc muốn xóa khoản thu này?')">
                                                    <i class="mdi mdi-delete"></i> {{ __('income.income-table.delete') }}
                                                  </a> --}}
                                           
                                                </li>
                                                <li>
                                                      <button  class="send-to-server-click btn-add " type="button" data-toggle="modal" data-target="#addIncome"  data-accountid="{{$account->id}}"><i class="mdi mdi-plus-circle-outline" style="margin-right: 10px;"></i>Thêm khoản thu</button>

                                                </li>
                                                <li>
                                                     <button class="send-to-server-click btn-add" type="button" data-toggle="modal" data-target="#addExpense" data-accountid="{{$account->id}}"><i class="mdi mdi-plus-circle-outline" style="margin-right: 10px;"></i>Thêm khoản chi</button>

                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">{{__('overview.graph.empty')}}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
  <!-- footer -->
    <!--Add Account-->
    <div class="modal fade" id="create" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('account.accounts-form.add-title')}}</h4>
                </div>
                <form class="simcy-form" action="{{ route('account.create') }}" data-parsley-validate="" loader="true" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p>{{__('account.accounts-form.add-intro')}}</p>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('account.accounts-form.label.name')}}</label>
                                    <input type="text" class="form-control" name="name" placeholder="{{__('account.accounts-form.placeholder.name')}}" required="">
                                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('account.accounts-form.label.balance')}}</label>
                                    <span class="input-prefix">VND</span>
                                    <input type="number" class="form-control prefix" step="0.01" data-parsley-pattern="^[+-]?[0-9]*\.[0-9]{2}$" name="balance" placeholder="{{__('account.accounts-form.placeholder.balance')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{__('account.accounts-form.label.type')}}</label>
                                    <select class="form-control select2" name="type">
                                        <option value="Cash">{{__('account.accounts-form.types.cash')}}</option>
                                        <option value="Bank">{{__('account.accounts-form.types.bank')}}</option>
                                        <option value="Card">{{__('account.accounts-form.types.card')}}</option>
                                        <option value="E-Wallet">{{__('account.accounts-form.types.ewallet')}}</option>
                                        <option value="Other">{{__('account.accounts-form.types.other')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <label>{{__('account.accounts-form.label.status')}}</label>
                                    <select class="form-control select2" name="status">
                                        <option value="Active">{{__('account.accounts-form.status.active')}}</option>
                                         <option value="Inactive">{{__('account.accounts-form.status.inactive')}}</option> 
                                    </select>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('account.button.close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('account.button.add-account')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
  @include('includes/footer')
</div>

<!--Record Income-->

<!--update Income-->
<div class="modal budget fade" id="update" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="updateform"></div>
    </div>
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
                                    <select class="form-control select2" name="category" id="categorySelect" required>
                                    <option >Chọn hạng mục
                                        </option> 
                                        {{-- @if (!empty($categories)) --}}
                                            @foreach ($categories as $key => $val)
                                               
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
                                        <option value="00">{{ __('expenses.expense-form.category.other') }}
                                        </option> 
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
<!-- addIncome -->
    <div class="modal fade" id="addIncome" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('income.income-form.add-title') }}</h4>
            </div>
            <div class="modal-body">
                <p>{{ __('income.income-form.add-intro') }}</p>
                <form class="simcy-form" action="{{ route('income.add') }}" data-parsley-validate="" method="POST"
                    loader="true">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>{{ __('income.income-form.label.title') }}</label>
                                <input type="text" class="form-control" name="title"
                                    placeholder="{{ __('income.income-form.placeholder.title') }}" required="">
                                {{-- <input type="hidden" name="csrf-token" value="{{csrf_token()}}" /> --}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>{{ __('income.income-form.label.amount') }}</label>
                                <span class="input-prefix">VND</span>
                                <input type="number" class="form-control prefix" step="1"
                                    data-parsley-pattern="^[0-9]$" name="amount" min="1000"
                                    placeholder="{{ __('income.income-form.placeholder.amount') }}" required="">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>{{ __('income.income-form.label.account') }}</label>
                                <select class="form-control select2" name="account">
                                    <option value="00">{{ __('income.income-form.account.other') }}</option>
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
                                <label>{{ __('income.income-form.label.category') }}</label>
                                <select class="form-control select2" name="category">
                                    
                                    @if (!empty($incomecategories))
                                        @foreach ($incomecategories as $incomecategory)
                                            <option value="{{ $incomecategory->id }}">{{ $incomecategory->name }}
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
                                <label>{{ __('income.income-form.label.date') }}</label>
                                <input type="date" class="form-control datepicker" name="income_date"
                                    placeholder="{{ __('income.income-form.placeholder.date') }}" required="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>{{ __('income.income-form.label.directory') }}</label>
                                <input type="text" class="form-control" name="directory"
                                    placeholder="{{ __('income.income-form.placeholder.directory') }}" >
                                @if (!empty($directorys))
                                    <label>{{ __('income.income-form.label.available') }}</label>
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
                                <label>{{ __('income.income-form.label.description') }}</label>
                                <input type="text" class="form-control " name="description"
                                    placeholder="{{ __('income.income-form.placeholder.description') }}">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    data-dismiss="modal">{{ __('income.button.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('income.button.add-income') }}</button>
            </div>
            </form>
        </div>

    </div>
</div>
</body>
</html>

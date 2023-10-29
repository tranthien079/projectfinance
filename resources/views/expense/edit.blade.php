@include('includes/header')
<body>
@include('includes/navbar')

<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h4 class="text-center">{{__('expenses.expense-form.update-title')}}</h4>
           
               <form class="simcy-form" action="{{ route('expense.update') }}" data-parsley-validate method="POST" loader="true">
                @csrf
            <div class="modal-body">
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12">
                           <label>{{__('expenses.expense-form.label.title')}}</label>
                           <input type="text" class="form-control" name="title" value="{{$expense->title}}" placeholder="{{__('expenses.expense-form.placeholder.title')}}" required>
                           <input type="hidden" name="csrf-token" value="{{csrf_token()}}" />
                           <input type="hidden" name="expenseid" value="{{$expense->id}}" />
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12">
                           <label>{{__('expenses.expense-form.label.amount')}}</label>
                           <span class="input-prefix">VND</span>
                           <input type="number" class="form-control prefix" value="{{$expense->amount}}" name="amount" placeholder="{{__('expenses.expense-form.placeholder.amount')}}">
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12">
                           <label>{{__('expenses.expense-form.label.account')}}</label>
                           <select class="form-control select2" name="account">
                              <option value="0" @if($expense->account == '0') selected @endif>
                                 {{__('expenses.expense-form.account.other')}}</option>
                             @if(!empty($accounts))
                             @foreach($accounts as $account)
                              <option value="{{ $account->id }}" @if($expense->account == $account->id) selected @endif>
                                 {{ $account->name }}</option>
                             @endforeach
                             @endif
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12">
                            <label>{{__('expenses.expense-form.label.category')}}</label>
                            <select class="form-control select2" name="category[]" id="categorySelect"
                            multiple="multiple">
                            @if (!empty($categories))
                                @foreach ($categories as $key => $val)
                                    @php
        
                                       $id =  $val->id_expense;
                                      
                                    @endphp
                                    <option {{ $expense->id == $id? 'selected' : ''}} value="{{ $val->id }}">
                                        @php
                                            $str = '';
                                            for ($i = 0; $i < $val->level; $i++) {
                                                echo $str;
                                                $str .= '-- ';
                                            }
                                        @endphp
                                        {{ $val->name }}
                                    </option>
                                @endforeach
                            @endif
                            <option value="00">{{ __('expenses.expense-form.category.other') }}</option>
                        </select>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12">
                           <label>{{__('expenses.expense-form.label.date')}}</label>
                           <input type="text" class="form-control datepicker-dynamic" value="{{date('m/d/Y', strtotime($expense->expense_date))}}" name="expense_date" placeholder="Date">
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                         <div class="col-md-12">
                             {{-- <label>{{ __('expenses.expense-form.label.directory') }}</label>
                             <input type="text" class="form-control" name="directory"
                                 placeholder="{{ __('expenses.expense-form.placeholder.directory') }}" > --}}
                             @if (!empty($directorys))
                                 <label>{{ __('expenses.expense-form.label.available') }}</label>
                                 <select class="form-control select2" name="directoryMul[]" id="directorySelect" multiple="multiple">
                                         @foreach ($directorys as $dir)
                                         @php
        
                                         $id =  $dir->expense;
                                        
                                          @endphp
                                             <option {{ $expense->id == $id ? 'selected' : ''}}  value="{{ $dir->id }}">{{ $dir->name }}</option>
                                         @endforeach
                                     
                                 </select>
                             @endif
                         </div>
                     </div>
                 </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12">
                           <label>{{__('expenses.expense-form.label.description')}}</label>
                           <input type="text" class="form-control" value="{{$expense->description}}" name="description" placeholder="{{__('expenses.expense-form.placeholder.description')}}">
                        </div>
                     </div>
                  </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default"
               ><a href="{{ route('expense.index') }}">{{ __('expenses.button.close') }}</a></button>
            <button type="submit" class="btn btn-primary">{{__('expenses.button.update-expense')}}</button>
            </div>
            </form>
    </div>
    <div class="col-md-2"></div>

  </div>
  @include('includes/footer')
</div>

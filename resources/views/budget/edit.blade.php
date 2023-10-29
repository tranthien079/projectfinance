@include('includes/header')
<body>
@include('includes/navbar')

<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h4 class="text-center">Cập nhật hạn mức chi</h4>
           
               <form class="simcy-form" action="{{ route('budget.update') }}" data-parsley-validate loader="true" method="POST" enctype="multipart/form-data" onsubmit="return kiemTraNgay()">
                @csrf
            <div class="modal-body">
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12">
                           <label>{{__('expenses.expense-form.label.title')}}</label>
                           <input type="text" class="form-control" name="title" value="{{$cashlimit->title}}" placeholder="{{__('expenses.expense-form.placeholder.title')}}" required>
                           <input type="hidden" name="cashid" value="{{$cashlimit->id}}" />
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12">
                           <label>{{__('expenses.expense-form.label.amount')}}</label>
                           <span class="input-prefix">VND</span>
                           <input type="number" class="form-control prefix" value="{{$cashlimit->amountlimit}}" name="amount" placeholder="{{__('expenses.expense-form.placeholder.amount')}}">
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-md-12">
                           <label>{{__('expenses.expense-form.label.account')}}</label>
                           <select class="form-control select2" name="account">
                              <option value="00"> Tất cả tài khoản</option>
                             @if(!empty($accounts))
                             @foreach($accounts as $account)
                              <option value="{{ $account->id }}" @if($cashlimit->account == $account->id) selected @endif>
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
                            <select class="form-control select2" name="category[]" id="categoryAdd"
                            multiple="multiple">
                            @if (!empty($categories))
                                @foreach ($categories as $key => $val)
                                    @php
                                       $id_category =  $val->id;
                                    @endphp
                                    <option {{ $cashlimit->category == $id_category ? 'selected' : ''}} value="{{ $val->id }}">
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
                           <label>Ngày bắt đầu</label>
                           <input type="date" class="form-control datepicker-dynamic" value="{{ $cashlimit->startday }}" name="startday" id="start" placeholder="Date">
                        </div>
                     </div>
                  </div>
                 
                  <div class="form-group">
                    <div class="row">
                       <div class="col-md-12">
                          <label>Ngày kết thúc</label>
                          <input type="date" class="form-control datepicker-dynamic" value="{{$cashlimit->endday}}" name="endday" id="end" placeholder="Date">
                       </div>
                    </div>
                 </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default"
               ><a href="{{ route('budget.index') }}">{{ __('expenses.button.close') }}</a></button>
            <button type="submit" class="btn btn-primary">{{__('expenses.button.update-expense')}}</button>
            </div>
            </form>
    </div>
    <div class="col-md-2"></div>

  </div>
  @include('includes/footer')
</div>

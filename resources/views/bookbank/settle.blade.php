@include('includes/header')

<body>
    @include('includes/navbar')
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h4 class="text-center">Tất toán sổ tiết kiệm</h4>
                <form class="simcy-form" action="{{ route('bookbank.updatesettle') }}" data-parsley-validate="" method="POST" loader="true"  onsubmit="return kiemTraNgayTatToan()">
                    @csrf
                    <input type="hidden" name="bookbankid" value="{{$bookbank->id}}" />
                    <div class="modal-body">
                    <div class="form-group">
                            <div class="row">
                               <div class="col-md-12">
                                  <label>Ngày tất toán</label>
                                  <input type="text" class="form-control datepicker-dynamic" value="{{  date_format(date_create(date('Y-m-d')), 'd/m/Y')}}" id="settledate" readonly name="settledate" placeholder="{{__('income.income-form.placeholder.date')}}">
                                  <input type="hidden" class="form-control datepicker-dynamic" value="{{$bookbank->senddate}}" id="senddate" name="senddate" placeholder="{{__('income.income-form.placeholder.date')}}">
                                </div>
                            </div>
                         </div>
                        <div class="form-group">
                            <div class="row">
                               <div class="col-md-12">
                                  <label>{{__('income.income-form.label.amount')}}</label>
                                  <span class="input-prefix">VND</span>
                                  <input type="number" class="form-control prefix" readonly value="{{$bookbank->amount}}" name="amount" readonly  placeholder="{{__('income.income-form.placeholder.amount')}}">
                                
                                </div>
                            </div>
                         </div>
                         <div class="form-group">
                            <div class="row">
                               <div class="col-md-12">
                                  <label>Chọn tài khoản nhận tiền</label>
                                  <select class="form-control select2" name="accountreceive" id="categorySelect" required>
                       
                                        <option value="">Chọn tài khoản</option> 
                                    @if(!empty($accounts))
                                    @foreach($accounts as $account)
                                     <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                    @endif
                                  </select>
                               </div>
                            </div>
                         </div>
                         <div class="form-group">
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-default pull-right btn-block"
                                    >
                                    <a href="{{ route('bookbank.index') }}">{{__('income.button.close')}}</button>
                                </div>
                                <div class="col-md-4">
                                    
                                <button type="submit" class="btn btn-primary pull-right btn-block" data="bookbankid:{{ $bookbank->id }}">Lưu</button>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                         </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('includes/footer')
        </div>
    </div>
</div>
</body>
<script>
    var ngayhientai = new Date(document.getElementById('settledate').value);
        var ngaytattoan = new Date(document.getElementById('senddate').value);
        console.log(ngaytattoan);
        console.log(ngayhientai);

     function kiemTraNgayTatToan() {
        var ngayhientai = new Date(document.getElementById('settledate').value);
        var ngaytattoan = new Date(document.getElementById('senddate').value);

            if (ngayhientai < ngaytattoan) {
                alert('Ngày tất toán phải trước ngày hiện tại');
                return false;
            }
        }
</script>

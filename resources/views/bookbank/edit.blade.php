@include('includes/header')
<body>
@include('includes/navbar')

<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h4 class="text-center">Cập nhật sổ tiết kiệm</h4>
     
        <form class="simcy-form" action="{{ route('bookbank.update') }}" data-parsley-validate="" method="POST" loader="true">
         @csrf
     <div class="modal-body">
           <div class="form-group">
              <div class="row">
                 <div class="col-md-12">
                    <label>Tên sổ tiết kiệm</label>
                    <input type="text" class="form-control" name="bookbank" value="{{$bookbank->namebb}}" placeholder="{{__('income.income-form.placeholder.title')}}">
                    <input type="hidden" name="incomeid" value="{{$bookbank->id}}" />
                 </div>
              </div>
           </div>
           <div class="form-group">
              <div class="row">
                 <div class="col-md-12">
                    <label>{{__('income.income-form.label.amount')}}</label>
                    <span class="input-prefix">VND</span>
                    <input type="number" class="form-control prefix" value="{{$bookbank->amount}}" name="amount" placeholder="{{__('income.income-form.placeholder.amount')}}">
                 </div>
              </div>
           </div>
           <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label>Tên ngân hàng</label>
                     <select name="namebank" id="" class=" form-control bank-select" required >
                         <option value="agribank" @if( $bookbank->account == 'agribank' ) selected @endif data-image="{{ asset('assets/images/agribank.png') }}">Agribank</option>
                         <option value="bidv" @if( $bookbank->account == 'bidv' ) selected @endif  data-image="{{ asset('assets/images/bidv.png') }}">BIDV</option>
                         <option value="mbbank" @if( $bookbank->account == 'mbbank' ) selected @endif data-image="{{ asset('assets/images/mbbank1.png') }}">MB Bank</option>
                         <option value="sacombank" @if( $bookbank->account == 'sacombank' ) selected @endif data-image="{{ asset('assets/images/sacombank.png') }}">Sacombank</option>
                         <option value="techcombank" @if( $bookbank->account == 'techcombank' ) selected @endif data-image="{{ asset('assets/images/techcombank.png') }}">Techcombank</option>
                         <option value="tpbank" @if( $bookbank->account == 'tpbank' ) selected @endif data-image="{{ asset('assets/images/tpbank.png') }}">TPBank</option>
                         <option value="vietcombank" @if( $bookbank->account == 'vietcombank' ) selected @endif data-image="{{ asset('assets/images/vietcombank.png') }}">Vietcombank</option>
                         <option value="vietinbank" @if( $bookbank->account == 'vietinbank' ) selected @endif data-image="{{ asset('assets/images/viettinbank.png') }}">Vietinbank</option>
                         <option value="vpbank" @if( $bookbank->account == 'vpbank' ) selected @endif data-image="{{ asset('assets/images/vpbank.png') }}">VPBank</option>

                     </select>
                </div>
            </div>
           </div>
            <div class="form-group">
                <div class="row">
                <div class="col-md-12">
                    <label>Ngày gửi</label>
                    <input type="date" class="form-control datepicker-dynamic" value="{{$bookbank->senddate}}" name="senddate" placeholder="{{__('income.income-form.placeholder.date')}}">
                </div>
                </div>
            </div>
           <div class="form-group">
              <div class="row">
                 <div class="col-md-12">
                    <label>{{__('income.income-form.label.account')}}</label>
                    <select class="form-control select2" name="account">
                       <option value="0" @if($bookbank->account == '0') selected @endif>
                          {{__('income.income-form.account.other')}}</option>
                      @if(!empty($accounts))
                      @foreach($accounts as $account)
                       <option value="{{ $account->id }}" @if( $bookbank->account == $account->id ) selected @endif>{{ $account->name }}</option>
                      @endforeach
                      @endif
                    </select>
                 </div>
              </div>
           </div>
          
           <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <label>Kỳ hạn</label>
                   
                    <select name="term" id="term" class="form-control select2" >
                        <option value="1" @if( $bookbank->term == 1 ) selected @endif>1 tháng </option>
                        <option value="3" @if( $bookbank->term == 3 ) selected @endif>3 tháng </option>
                        <option value="6" @if( $bookbank->term == 6 ) selected @endif>6 tháng </option>
                        <option value="12" @if( $bookbank->term == 12 ) selected @endif>12 tháng </option>
                        <option value="other" @if( $bookbank->term != 1 ||  $bookbank->term != 3 ||  $bookbank->term != 6 ||  $bookbank->term != 12 ) selected @endif>Nhập số khác</option>
                    </select>
                    <input type="number" name="termTemp" class="form-control"  value= {{ $bookbank->term }} min="1" placeholder="Nhập kỳ hạng khác" id="otherNumberInput" style="display: none;">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12 input-hero">
                    <label>Lãi suất</label>
                    <input type="number" inputmode="numeric"  name="interest" id="" min="0" class="form-control" value={{ $bookbank->interest }}  required>
                     <span>%/năm</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12 input-hero">
                    <label>Lãi suất không thời hạn</label>
                    <input type="number" inputmode="numeric"  name="nonterminterest" id="" step="0.01" min="0.05" class="form-control" value={{ $bookbank->nonterminterest }} required>
                     <span>%/năm</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12 input-hero">
                    <label>Số ngày tính lãi / năm</label>
                    <input type="number" inputmode="numeric"  name="numberdaysinterest" id="" min="1" class="form-control" value={{ $bookbank->numberdaysinterest }} required>
                     <span>Ngày</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12 input-hero">
                    <label>Trả lãi</label>
                   <select name="payinterest" id="" class="form-control" required>
                         <option value="end" @if( $bookbank->payinterest == "end" ) selected @endif>Cuối kì</option>
                         <option value="begin" @if( $bookbank->payinterest == "begin" ) selected @endif>Đầu kì</option>
                         <option value="monthlyperiod" @if( $bookbank->payinterest == "monthlyperiod" ) selected @endif>Định kì hàng tháng</option>
                   </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12 input-hero">
                    <label>Khi đến hạn</label>
                   <select name="finalizefund" id="" class="form-control" required>
                         <option value="renewpandi" @if( $bookbank->finalizefund == "renewpandi" ) selected @endif>Tái tục gốc và lãi</option>
                         <option value="renewp"  @if( $bookbank->finalizefund == "renewp" ) selected @endif>Tái tục gốc</option>
                         <option value="finalize"  @if( $bookbank->finalizefund == "finalize" ) selected @endif>Tất toán sổ</option>
                   </select>
                </div>
            </div>
        </div>
          
           <div class="form-group">
            <div class="row">
               <div class="col-md-12">
                  <label>{{__('income.income-form.label.description')}}</label>
                  <input type="text" class="form-control" value="{{$bookbank->description}}" name="description" placeholder="{{__('income.income-form.placeholder.description')}}">
               </div>
            </div>
         </div>
     </div>
        <div class="modal-footer " >
         <button type="button" class="btn btn-default"
         >
         <a href="{{ route('bookbank.index') }}">{{__('income.button.close')}}</button>
           <button type="submit" class="btn btn-primary">{{__('income.button.update-income')}}</button>
        </div>
     </form>
    </div>
    <div class="col-md-2"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Lấy phần tử select và input
          const numberSelect = document.getElementById('numberSelect');
          const otherNumberInput = document.getElementById('otherNumberInput');
        
          // Thêm sự kiện nghe cho sự thay đổi trong phần tử select
          numberSelect.addEventListener('change', function() {
            if (numberSelect.value === 'other') {
              // Nếu lựa chọn là "other", hiển thị trường nhập số khác
              otherNumberInput.style.display = 'block';
            } else {
              // Nếu không phải "other", ẩn trường nhập số khác
              otherNumberInput.style.display = 'none';
            }
          });
        });
        </script>
  </div>
  @include('includes/footer')
</div>

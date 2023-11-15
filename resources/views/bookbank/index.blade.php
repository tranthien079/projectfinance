@include('includes/header')

<body>
    @include('includes/navbar')
    <div class="container">
    <div class="page-heading">
        <button class="btn btn-primary pull-right ml-5" type="button" data-toggle="modal" data-target="#create"><span><i class="mdi mdi-plus-circle-outline"></i></span>Thêm sổ tiết kiệm</button>
           
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
                   <p>Đây là sổ tiết kiệm của bạn. Hãy tiết kiệm nhiều nhất có thể.</p>
               </div>
           </div>
       </div>
   
       <div class="row">
           <div class="col-md-12">
               <div class="card">
                   <div class="card-header">
                       <h4>Sổ tiết kiệm</h4>
                   </div>
                   <div class="card-body">
                       <div class="table-responsive longer">
                           <table class="table display table-striped dataTable" id="datatable">
                               <tbody>
                                <tr>
                                    <td></td>
                                    <td>Tên sổ tiết kiệm</td>
                                    <td>Ngân hàng</td>
                                    <td>Ngày gửi</td>
                                    <td>Số tiền gửi</td>
                                    <td>Kỳ hạn</td>
                                    <td>Lãi xuất</td>
                                    <td></td>
                                </tr>
                                @if (count($bookbanks) > 0)
                                @php
                                $i=1;
                                @endphp
                                @foreach($bookbanks as $bookbank)
                                <tr>
                                    <td><span class="badge badge-success">{{ $i++ }}</span></td>
                                    <td><strong>{{ $bookbank->namebb }}</strong></td>
                                    <td><strong>{{ ucfirst($bookbank->namebank) }}</strong></td>
                                    <td><strong>{{ date_format(date_create($bookbank->senddate), 'd/m/Y') }}</strong></td>
                                    <td><strong>{{  number_format($bookbank->amount, 0, ',', '.') . ' ₫' }}</strong></td>
                                    <td><strong>{{ $bookbank->term }} tháng</strong></td>
                                    <td><strong>{{ $bookbank->interest}} %</strong></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button"
                                                data-toggle="dropdown">{{ __('expenses.expense-table.actions') }}
                                                <span class="caret"></span> </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="c-dropdown__item dropdown-item fetch-display-click"
                                                        data="bookbankid:{{ $bookbank->id }}"
                                                        href="{{ route('bookbank.edit', $bookbank->id) }}"><i
                                                            class="mdi mdi-pencil"></i>
                                                        {{ __('expenses.expense-table.edit') }}</a></li>
                                               
                                              <li>
                                                    <form method="POST" action="{{ route('bookbank.settle', $bookbank->id) }}">
                                                    @method('POST')
                                                        @csrf
                                                        <input type="hidden" name="bookbankid"
                                                            value="{{ $bookbank->id }}">
                                                        <button type="submit" class="c-dropdown__item dropdown-item fetch-display-click btn-settle" data="bookbankid:{{ $bookbank->id }}">
                                                            <i class="mdi mdi-book " style="margin-right: 10px;!important"></i>
                                                            Tất toán sổ
                                                        </button>
                                                    </form>
                                                </li>
                                                {{-- <li>
                                                    <button type="button" class="c-dropdown__item dropdown-item fetch-display-click" data-bookbankid="{{ $bookbank->id }}" onclick="return confirm('Bạn có muốn tất toán sổ tiết kiệm này không?');">
                                                        <i class="mdi mdi-book "></i>
                                                        Tất toán sổ
                                                    </button>
                                                </li> --}}

                                                <li>
                                                    <form method="POST"
                                                        action="{{ route('bookbank.destroy', $bookbank->id) }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="hidden" name="bookbankid"
                                                            value="{{ $bookbank->id }}">
                                                        <button type="submit"
                                                            onclick="return confirm('Bạn có chắc muốn sổ tiết kiệm này?')"
                                                            class="send-to-server-click btn-delete"
                                                            data="bookbankid:{{ $bookbank->id }}"
                                                            loader="true">
                                                            <i class="mdi mdi-delete"
                                                                style="margin-right: 10px;!important"></i>
                                                            {{ __('expenses.expense-table.delete') }}
                                                        </button>
                                                    </form>
                                                 

                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @endif
                               </tbody>
                           </table>
                           @if (count($bookbanks) > 0)

                           @else
                           <div class="text-center">Không có sổ tiết kiệm nào.</div>
                           @endif
                       </div>
                   </div>
               </div>
           </div>
           @if(count($bookbankSettled) > 0) 
           <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   
                    <h4>Sổ đã tất toán</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive longer">
                        <table class="table display table-striped dataTable" id="datatable">
                            <tbody>
                             <tr>
                                 <td></td>
                                 <td>Tên sổ tiết kiệm</td>
                                 <td>Ngân hàng</td>
                                 <td>Ngày gửi</td>
                                 <td>Số tiền gửi</td>
                                 <td>Kỳ hạn</td>
                                 <td>Lãi xuất</td>
                                 <td></td>
                             </tr>
                             @if (count($bookbankSettled) > 0)
                             @php
                             $i=1;
                             @endphp
                             @foreach($bookbankSettled as $bookbank)
                             <tr>
                                 <td><span class="badge badge-success">{{ $i++ }}</span></td>
                                 <td><strong>{{ $bookbank->namebb }}</strong></td>
                                 <td><strong>{{ ucfirst($bookbank->namebank) }}</strong></td>
                                 <td><strong>{{ date_format(date_create($bookbank->senddate), 'd/m/Y') }}</strong></td>
                                 <td><strong>{{  number_format($bookbank->amount, 0, ',', '.') . ' ₫' }}</strong></td>
                                 <td><strong>{{ $bookbank->term }} tháng</strong></td>
                                 <td><strong>{{ $bookbank->interest}} %</strong></td>
                                 <td>
                                     <div class="dropdown">
                                         <button class="btn btn-default dropdown-toggle" type="button"
                                             data-toggle="dropdown">{{ __('expenses.expense-table.actions') }}
                                             <span class="caret"></span> </button>
                                         <ul class="dropdown-menu">
                                             <li>
                                                 <form method="POST"
                                                     action="{{ route('bookbank.destroy', $bookbank->id) }}">
                                                     @method('DELETE')
                                                     @csrf
                                                     <input type="hidden" name="bookbankid"
                                                         value="{{ $bookbank->id }}">
                                                     <button type="submit"
                                                         onclick="return confirm('Bạn có chắc muốn sổ tiết kiệm này?')"
                                                         class="send-to-server-click btn-delete"
                                                         data="bookbankid:{{ $bookbank->id }}"
                                                         loader="true">
                                                         <i class="mdi mdi-delete"
                                                             style="margin-right: 10px;"></i>
                                                         {{ __('expenses.expense-table.delete') }}
                                                     </button>
                                                 </form>
                                             </li>
                                         </ul>
                                     </div>
                                 </td>
                             </tr>
                             @endforeach
                             
                             @endif
                            </tbody>
                         
                        </table>
                    </div>
                </div>
            </div>
        </div>
           @endif
       </div>
     <!-- footer -->
       <!--Add Account-->
       <div class="modal fade" id="create" role="dialog">
           <div class="modal-dialog modal-sm">
               <!-- Modal content-->
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title">Thêm sổ tiết kiệm</h4>
                   </div>
                   <form class="simcy-form" action="{{ route('bookbank.add') }}" data-parsley-validate="" loader="true" method="POST" enctype="multipart/form-data">
                       @csrf
                       <div class="modal-body">
                           <p>Tạo một sổ tiết kiệm mới</p>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12">
                                       <label>Tên sổ tiết kiệm</label>
                                       <input type="text" class="form-control" name="namebb" placeholder="Nhập tên sổ tiết kiệm" required="">
                                       <input type="hidden" name="csrf-token" value="{{csrf_token()}}" />
                                   </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12">
                                       <label>Số tiền gửi</label>
                                       <span class="input-prefix">VND</span>
                                       <input type="number" name="amount" id="" min="1000" class="form-control prefix" required placeholder="Nhập số tiền gửi">
                                   </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12">
                                       <label>Tên ngân hàng</label>
                                        <select name="namebank" id="" class=" form-control bank-select" required >
                                            <option value="agribank" data-image="{{ asset('assets/images/agribank.png') }}">Agribank</option>
                                            <option value="bidv" data-image="{{ asset('assets/images/bidv.png') }}">BIDV</option>
                                            <option value="mbbank" data-image="{{ asset('assets/images/mbbank1.png') }}">MB Bank</option>
                                            <option value="sacombank" data-image="{{ asset('assets/images/sacombank.png') }}">Sacombank</option>
                                            <option value="techcombank" data-image="{{ asset('assets/images/techcombank.png') }}">Techcombank</option>
                                            <option value="tpbank" data-image="{{ asset('assets/images/tpbank.png') }}">TPBank</option>
                                            <option value="vietcombank" data-image="{{ asset('assets/images/vietcombank.png') }}">Vietcombank</option>
                                            <option value="vietinbank" data-image="{{ asset('assets/images/viettinbank.png') }}">Vietinbank</option>
                                            <option value="vpbank" data-image="{{ asset('assets/images/vpbank.png') }}">VPBank</option>

                                        </select>
                                   </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12">
                                       <label>Ngày gửi</label>
                                      <input type="date" name="senddate" id="" class="form-control" required>
                                   </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12">
                                       <label>Kỳ hạn</label>
                                       <select name="term" id="term" class="form-control" >
                                            <option value="1">1 tháng </option>
                                            <option value="3">3 tháng </option>
                                            <option value="6">6 tháng </option>
                                            <option value="12">12 tháng </option>
                                            <option value="other">Nhập số khác</option>

                                        </select>
                                        <input type="number" name="termTemp" class="form-control"  min="1" placeholder="Nhập kỳ hạng khác" id="otherNumberInput" style="display: none;">
                                     
                                   </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12 input-hero">
                                       <label>Lãi suất</label>
                                       <input type="number" inputmode="numeric"  name="interest" id="" min="0" class="form-control" required>
                                        <span>%/năm</span>
                                   </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12 input-hero">
                                       <label>Lãi suất không thời hạn</label>
                                       <input type="number" inputmode="numeric"  name="nonterminterest" id="" step="0.01" min="0.05" class="form-control" value="0.05" required>
                                        <span>%/năm</span>
                                   </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12 input-hero">
                                       <label>Số ngày tính lãi / năm</label>
                                       <input type="number" inputmode="numeric"  name="numberdaysinterest" id="" min="1" class="form-control" value="365" required>
                                        <span>Ngày</span>
                                   </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12 input-hero">
                                       <label>Trả lãi</label>
                                      <select name="payinterest" id="" class="form-control" required>
                                            <option value="end">Cuối kì</option>
                                            <option value="begin">Đầu kì</option>
                                            <option value="monthlyperiod">Định kì hàng tháng</option>
                                      </select>
                                   </div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="row">
                                   <div class="col-md-12 input-hero">
                                       <label>Khi đến hạn</label>
                                      <select name="finalizefund" id="" class="form-control" required>
                                            <option value="renewpandi">Tái tục gốc và lãi</option>
                                            <option value="renewp">Tái tục gốc</option>
                                            <option value="finalize">Tất toán sổ</option>
                                      </select>
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
                                   <div class="col-md-12 input-hero">
                                       <label>Diễn giải</label>
                                       <input type="text" name="description" id=""  class="form-control" placeholder="Nhập diễn giải">
                                   </div>
                               </div>
                           </div>
                            
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
    
    


{{-- <script>
function confirmSettle(button) {
    var bookbankId = button.getAttribute('data-bookbankid');
    var interest = calculateInterest(bookbankId); 
    console.log(bookbankId);
}
</script> --}}
    </div>

</body>

</html>
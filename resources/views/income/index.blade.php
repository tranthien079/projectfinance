@include('includes/header')
<body>
@include('includes/navbar')
<!-- Main content -->
<div class="container">
    <div class="page-heading">
            <button class="btn btn-primary pull-right ml-5" type="button" data-toggle="modal" data-target="#addIncome"><span><i class="mdi mdi-plus-circle-outline"></i></span> {{__('income.button.add-income')}} </button>
        <div class="heading-content">
            <div class="user-image">
                @if(empty($user->avatar))
                <img src="{{ asset('assets/images/avatar.png') }}" class="img-circle img-responsive">
                @else
                <img src="{{ asset('uploads/avatar/'.$user->avatar) }}" class="img-circle img-responsive">
                @endif
            </div>
            <div class="heading-title">
                <h2>{{__('income.heading.welcome')}}, {{$user->fname}} {{$user->lname}}</h2>
                <p>{{__('income.heading.intro')}}</p>
            </div>
        </div>
    </div>  

    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>{{__('income.income-table.income-records')}}</h4>
              </div>
              <div class="card-body">
                  <div class="table-responsive longer">
                      <table class="table display" id="datatable">
                          <thead>
                              <tr>
                                  <th width="40%">{{__('income.income-table.name')}}</th>
                                  <th>{{__('income.income-table.date')}}</th>
                                  <th>{{__('income.income-table.amount')}}</th>
                                  <th align="center">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          @if(!empty($income))
                            @foreach($income as $Income)                             
                              <tr>
                                  <td><strong>{{__('income.title-income.name')}}: {{$Income->title}}</strong><br>
                                    <p class="text-primary">{{__('income.title-income.category-income')}}: {{$Income->categoryname}}</p>
                                    @if(empty($Income->name))
                                    <span>{{__('income.income-table.other')}} </span>
                                    @else
                                    <span>{{__('income.title-income.resource-income')}}: {{ $Income->name}} </span>
                                    @endif
                                  </td>
                                  <td><span>{{date_format(date_create($Income->income_date), 'd/m/Y')}}</span></td>
                                  <td><strong>{{ number_format($Income->amount, 0, ',', '.') . ' ₫' }}</strong></td>
                                  <td>
                                    <div class="dropdown">
                                      <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">{{__('income.income-table.actions')}} <span class="caret"></span> </button>
                                      <ul class="dropdown-menu">
                                          <li><a class="c-dropdown__item dropdown-item fetch-display-click"  data="incomeid:{{$Income->id}}"  href="{{ route('income.edit',$Income->id)}}"><i class="mdi mdi-pencil"></i> {{__('income.income-table.edit')}}</a></li>
                                        
                                          <li> 
                                              <form method="POST" action="{{route('income.destroy',$Income->id)}}" >
                                              @method('DELETE')
                                              @csrf
                                              <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa khoản thu này?')" class="send-to-server-click btn-delete"  data="incomeid:{{$Income->id}}" loader="true">
                                                <i class="mdi mdi-delete" style="margin-right: 10px;"></i> {{__('income.income-table.delete')}}
                                              </button>
                                            </form>
                                            {{-- <a href="{{ route('income.destroy', $Income->id) }}" class="c-dropdown__item dropdown-item fetch-display-click btn-delete" onclick="return confirm('Bạn có chắc muốn xóa khoản thu này?')">
                                              <i class="mdi mdi-delete"></i> {{ __('income.income-table.delete') }}
                                            </a> --}}
                                     
                                          </li>
                                         
                                         

                                        </ul>
                                    </div>
                              </tr>
                              @endforeach
                          @else
                          <tr>
                            <td colspan="5" class="text-center">{{__('income.income-table.empty')}}</td>
                          </tr>
                          @endif
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
        </div>
        {{-- <div class="col-md-3">
            <div class="card">
              <div class="card-header">
                <h4>{{ date("M") }} {{__('income.info-box.income-progress')}}</h4>
              </div>
              <div class="card-body">
                  <section class="text-center mt-15">
                    <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                      <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                      <circle class="circle-chart__circle" stroke="#F4BE4A" stroke-width="2" stroke-dasharray="{{ $stats['percentage'] }},100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                      <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="8">{{ $stats['percentage']}}%</text>
                        <text class="circle-chart__subline" x="16.91549431" y="20.5" alignment-baseline="central" text-anchor="middle" font-size="2"> {{ number_format($stats['earned'], 0, ',', '.') . ' ₫' }} {{__('income.info-box.earned')}}</text>
                      </g>
                    </svg>   
                    <div class="chart-insights">
                      <p>{{__('income.info-box.you-have-earned')}}</p>
                      <h4><strong>{{ number_format($stats['earned'], 0, ',', '.') . ' ₫' }}</strong> {{__('income.info-box.out-of')}} <strong>{{ number_format($user->monthly_earning, 0, ',', '.') . ' ₫' }}</strong></h4>
                    </div>
                  </section>
                  <div></div>
              </div>
            </div>

            @if( $stats['percentage'] < 33 )
            <div class="card bg-warning text-white">
            @elseif($stats['percentage'] < 66)
            <div class="card bg-info text-white">
            @elseif($stats['percentage'] > 66)
            <div class="card bg-green text-white">
            @endif
              <div class="card-header">
                <h4 class="text-white">{{__('income.info-box.budget-status')}}</h4>
              </div>
              <div class="card-body">
                <div class="insight-card text-center">

                  @if( $stats['percentage'] < 33 )
                  <h3>{{__('income.info-box.a-bit-dry')}}, {{ $user->fname }}!</h3>
                  @elseif($stats['percentage'] < 66)
                  <h3>{{__('income.info-box.good-progress')}}, {{ $user->fname }}!</h3>
                  @elseif($stats['percentage'] > 66)
                  <h3>{{__('income.info-box.looking-good')}}, {{ $user->fname }}!</h3>
                  @endif
                  <p>{{ sprintf(__('income.info-box.budget-message'), ( $stats['percentage'] ) , ( 100 - $stats['percentage'] )) }}</p>
                  <a href="{{ route('budget.index') }}" >{{__('income.links.adjust-budget')}} <span><i class="mdi mdi-hand-pointing-right"></i></span></a>
                </div>
              </div>
            </div>
        </div> --}}
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
  <!-- footer -->
  
</div>

    <!-- view edit modal -->

    <!-- end view update -->
    <!-- scripts -->
    <!-- <script src="assets/js/jquery-3.2.1.min.js"></script> -->
    {{-- <script src="{{ url('') }}lang/{{env('APP_LOCALE_DEFAULT')}}/simcify-lang.js"></script> <!-- js language translation -->
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js//jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/js/simcify.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/datetime-moment.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/currency.js"></script>
    <!-- custom scripts -->
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{ url('') }}lang/{{env('APP_LOCALE_DEFAULT')}}/lang.js"></script> <!-- js language translation -->
    <script>
        $(document).ready(function() {
            $.fn.dataTable.moment("MMM DD, YYYY");
            $('#datatable').DataTable({
              
                dom: 'Bfrtip',
                columnDefs: [
                  { type: 'currency', targets: 2 }
                ],
                order: [[ 1, 'desc']],
                buttons: [{
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2 ],
                    stripNewlines: false,
                },
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2 ],
                },
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2 ],
                    stripNewlines: false,
                    },
                    customize : function(doc) {
                        doc.content[1].table.widths = [ '60%', '20%', '20%',];
                    }
            }
                ],
                language: {
                    url: '{{ url('') }}lang/{{env('APP_LOCALE_DEFAULT')}}/table_lang.json'
                }
            });
        });
        

    </script> --}}
    @include('includes/footer')
</body>
</html>
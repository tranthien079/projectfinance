<div class="container" style="padding-top:0!important;">
    <div class="col-md-12">
    <footer>
    <div class="footer-logo">
        <img src="{{ asset('uploads/app/logo.png') }}" class="img-responsive">
    </div>
    <p class="text-right pull-right">&copy; {{ date('Y') }} <i>VENUS</i><span>•</span>
        {{ __('pages.footer') }}</p>
</footer>

    </div>
</div>


<!-- add income -->
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
                                <select class="form-control select2" name="category" id="categorySelect" required >
                                <option value="">Chọn hạng mục</option> 
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
<!-- view edit modal -->


<!--Record Expense-->

 <!-- scripts -->
    <!-- <script src="assets/js/jquery-3.2.1.min.js"></script> -->
    <script src="{{ url('') }}lang/{{env('APP_LOCALE_DEFAULT')}}/simcify-lang.js"></script> <!-- js language translation -->
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
                buttons: [
                  {
                    extend: 'copyHtml5',
                    exportOptions: {
                      columns: [ 0, 1, 2 ],
                      stripNewlines: false,
                    },
                  },
                  {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2 ]
                    }
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
        function kiemTraNgay() {
    var ngayBatDau = new Date(document.getElementById('start').value);
    var ngayKetThuc = new Date(document.getElementById('end').value);

    if (ngayKetThuc <= ngayBatDau) {
        alert('Ngày kết thúc phải sau ngày bắt đầu');
        return false;
    }

    return true;
    }
    const numberSelect = document.getElementById('term');
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
    </script>
   
    <script>

        $(document).ready(function() {
    function formatBank (bank) {
        if (!bank.id) { return bank.text; }
        var $bank = $(
            '<span><img src="' + $(bank.element).data('image') + '" class="img-flag" width="30" /> ' + bank.text + '</span>'
        );
        return $bank;
    };

    $(".bank-select").select2({
        templateResult: formatBank,
        templateSelection: formatBank
    });
});
    </script>
<script>
    $('input[type=number]').on('input', function() {
    this.value = parseFloat(this.value).toFixed(0);
});
  $(document).ready(function() {
    
    $('#categoryAdd').select2({
        maximumSelectionLength: 1
    });

      $('#categorySelect').select2({
       
      });
    //   $('#categorySelect').on('change', function() {
    //     var selectedOptions = $(this).val();

    //     if (selectedOptions.length > 0) {
    //       var firstOptionValue = selectedOptions[0];

    //       $('#categorySelect option').each(function() {
    //         var optionValue = $(this).val();

    //         if (optionValue === firstOptionValue || optionValue.startsWith(firstOptionValue + '.')) {
    //           $(this).prop('selected', true);
    //         }
    //       });

    //       $('#categorySelect').trigger('change.select2'); // Cập nhật Select2
    //     }
    //   });

    $('#directorySelect').select2({
       
    });
    // $('#directorySelect').on('change', function() {
    //   var selectedOptions = $(this).val();

    //   if (selectedOptions.length > 0) {
    //     var firstOptionValue = selectedOptions[0];

    //     $('#directorySelect option').each(function() {
    //       var optionValue = $(this).val();

    //       if (optionValue === firstOptionValue || optionValue.startsWith(firstOptionValue + '.')) {
    //         $(this).prop('selected', true);
    //       }
    //     });

    //     $('#directorySelect').trigger('change.select2'); // Cập nhật Select2
    //   }
    // });

    
    });
</script>
<script>
    $(document).ready(function() {
        $('.btn-add').click(function() {
            var accountId = $(this).data('accountid'); // get account id from data attribute
            $('#addExpense select[name="account"]').val(accountId); // set the value of the select
            $('#addIncome select[name="account"]').val(accountId); 
        });
    });
    </script>


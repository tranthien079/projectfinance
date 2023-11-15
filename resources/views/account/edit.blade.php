@include('includes/header')
<body>
@include('includes/navbar')

<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h4 class="text-center">{{__('account.accounts-form.update-title')}}</h4>
     
        <form class="simcy-form" action="{{ route('account.update') }}" data-parsley-validate="" loader="true" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <p>{{sprintf(__('account.accounts-form.update-intro'), $account->name)}}</p>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label>{{__('account.accounts-form.label.name')}}</label>
                            <input type="text" class="form-control" value="{{$account->name}}" name="name" placeholder="{{__('account.accounts-form.placeholder.name')}}">
                            <input type="hidden" name="csrf-token" value="{{csrf_token()}}" />
                            <input type="hidden" name="accountid" value="{{$account->id}}" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label>{{__('account.accounts-form.label.balance')}}</label>
                            <span class="input-prefix">VND</span>
                            <input type="number" class="form-control prefix" value="{{$account->balance}}" step="0.01" data-parsley-pattern="^-?[0-9]*\.?[0-9]{0,2}$" name="balance" placeholder="{{__('account.accounts-form.placeholder.balance')}}" required="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label>{{__('account.accounts-form.label.type')}}</label>
                            <select class="form-control select2" name="type">
                                <option value="Cash" @if($account->type == 'Cash') selected @endif >
                                    {{__('account.accounts-form.types.cash')}}</option>
                                <option value="Bank" @if($account->type == 'Bank') selected @endif >
                                    {{__('account.accounts-form.types.bank')}}</option>
                                <option value="Card" @if($account->type == 'Card') selected @endif >
                                    {{__('account.accounts-form.types.card')}}</option>
                                <option value="E-Wallet" @if($account->type == 'E-Wallet') selected @endif >
                                    {{__('account.accounts-form.types.ewallet')}}</option>
                                <option value="Other" @if($account->type == 'Other') selected @endif >
                                    {{__('account.accounts-form.types.other')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default"
               ><a href="{{ route('account.index') }}">{{ __('account.button.close') }}</a></button>
                <button type="submit" class="btn btn-primary">{{__('account.button.save-account')}}</button>
            </div>
        </form>
    </div>
    <div class="col-md-2"></div>

  </div>
  @include('includes/footer')
</div>

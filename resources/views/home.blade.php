@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <div class="text-center">
                        <div>BALANCE - <span class="text-primary">💰</span><span>{{Auth::user()->balance()}}</span></div>
                        <button type="button" data-toggle="modal" data-target="#paymentModal" class="btn btn-large btn-outline btn-primary text-center">Fund Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="paymentModal" aria-labelledby="paymentModal" aria-hidden="true">
    <form method="POST" action="{{ route('paystack.standard') }}" accept-charset="UTF-8">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fund Account Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>

                    <div class="col-md-6">
                        <input id="amount" type="number" class="form-control" name="amount" required min="500">
                    </div>
                    <span class="ml-4 text-danger" role="alert">
                            <strong id="amount-error"></strong>
                    </span>
                </div>
                <div class="form-group row">
                        <label for="purpose" class="col-md-4 col-form-label text-md-right">Purpose</label>

                        <div class="col-md-6">
                            <input id="purpose" type="text" class="form-control" name="purpose">
                        </div>
                        <span class="ml-4 text-danger" role="alert">
                                <strong id="purpose-error"></strong>
                        </span>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="email" value={{Auth::user()->email}}>
                <input type="hidden" name="reference" value={{ Paystack::genTranxRef() }}>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> {{-- required --}}
                <button type="button" id="pay-inline" onclick="payWithPaystack();" class="btn btn-primary">Pay Inline</button>
                <button type="Submit" class="btn btn-secondary">Pay Standard</button>
            </div>
            </div>
        </div>
    </form>
</div>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    @if (session('status'))
    toastr.success("{{ session('status') }}")
    @endif
    const email = @json(Auth::user()->email);
    const payUrl = "{{route('paystack.post')}}";
    const key = @json($config);
    console.log(payUrl);
</script>
<script src="{{asset('js/fund/index.js')}}"></script>
@endsection

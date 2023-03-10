@extends('layout/offer')

@section('content-right')
    <div class="panel panel-primary">
        <div class="panel-heading text-white">
            <h4><strong>Заполните следующие данные</strong></h4>
        </div>
        <div class="panel-body">
            <div class="ibox ">
                <div class="ibox-content">

                    <form action="/offer-actions/create" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @include('include.flash')
                        @include('include.errors')

                        <input type="hidden" value="{{ $Tender->id }}" name="tender_id" />
                        <div class="form-group row "><label class="col-4 col-form-label">Сумма ставки :</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="bid_amount"
                                    value="{{ old('bid_amount') }}">
                            </div>
                        </div>
                        <div class="form-group row "><label class="col-4 col-form-label">Период:</label>
                            <div class="col-8">
                                <input type="hidden" class="form-control" name="period" value="{{ old('period') }}">

                                <div class="row">
                                    <div class="input-group col">
                                        <input type="number" min="0" class="form-control" name="period_years"
                                            value="{{ old('period_years', 0) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">Годы</span>
                                        </div>
                                    </div>
                                    <div class="input-group col">
                                        <input type="number" min="0" class="form-control" name="period_months"
                                            value="{{ old('period_months', 0) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">Месяцы</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row "><label class="col-4 col-form-label">Примечание :</label>
                            <div class="col-8">
                                <textarea class="form-control" name="note">{{ old('note') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3 offset-9">
                                <button class="btn-block btn btn-sm btn-secondary btn-lg float-right "
                                    type="submit">Потвердить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection

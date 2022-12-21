@extends('layout/account')

@section('content')

    <div class="ibox ">
        <div class="ibox-title">
            <h5 class="text-success">Редактировать тендера</h5>
        </div>
        <div class="ibox-content">
            <form action="/tender-actions/update" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                @include('include.flash')
                @include('include.errors')

                <input type="hidden" class="form-control" name="id" value="{{ $tenderDetails->id }}">
                <div class="form-group row "><label class="col-2 col-form-label">Название :</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="title" value="{{ $tenderDetails->title }}">
                    </div>
                </div>
                <div class="form-group row"><label class="col-2 col-form-label">Описание :</label>
                    <div class="col-10">
                        <textarea class="form-control" rows="3" name="description"> {{ $tenderDetails->description }}</textarea>
                    </div>
                </div>
                <div class="form-group row" id="data_1"><label class="col-2 col-form-label">Дата начала :</label>
                    <div class="input-group date col-10">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"
                            class="form-control form-control-sm" name="start_date" value="{{ $tenderDetails->start_date }}">
                    </div>
                </div>
                <div class="form-group row" id="data_1"><label class="col-2 col-form-label">Дата окончания:</label>
                    <div class="input-group date col-10">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"
                            class="form-control form-control-sm" name="end_date" value="{{ $tenderDetails->end_date }}">
                    </div>
                </div>
                <div class="form-group row"><label class="col-2 col-form-label">Сумма задатка :</label>
                    <div class="col-10">
                        <div class="input-group-prepend">
                            <span class="input-group-addon">₽</span>
                            <input type="text" class="form-control" name="deposit" value="{{ $tenderDetails->deposit }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row"><label class="col-2 col-form-label">Начальная цена:</label>
                    <div class="col-10">
                        <div class="input-group-prepend">
                            <span class="input-group-addon">₽</span>
                            <input type="text" class="form-control" name="estimate_cost"
                                value="{{ $tenderDetails->estimate_cost }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row"><label class="col-2 col-form-label">Адрес :</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="location" value="{{ $tenderDetails->location }}">
                    </div>
                </div>
                <div class="form-group row"><label class="col-2 col-form-label">Категория :</label>
                    <div class="col-10">
                        <select class="select2_demo_3 form-control" name="category_id" value="{{ old('category_id') }}">
                            <option value="-1">Выбрать</option>
                            @foreach ($tenderCategories as $categories)
                                <option value="{{ $categories->id }}"
                                    @if ($tenderDetails->tm_tender_category_id == $categories->id) selected="selected" @endif>{{ $categories->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row"><label class="col-2 col-form-label">Статус :</label>
                    <div class="col-10">
                        <select class="select2_demo_3 form-control" name="tender_status"
                            value="{{ old('tender_status') }}">
                            <option value="-1">Выбрать</option>
                            @foreach ($tenderStatus as $status)
                                <option value="{{ $status->id }}"
                                    @if ($tenderDetails->tm_tender_status_id == $status->id) selected="selected" @endif>{{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-3 offset-9">
            <button class="btn-block btn btn-sm btn-secondary btn-lg float-right m-r" type="submit">Обновить</button>
        </div>
    </div>
    </form>
    </div>
    </div>


    <script>
        var hasattachment = false;

        @if ($tenderDetails->hasPDF())
            hasattachment = true;
        @endif

        $(".select2_demo_3").select2({
            placeholder: "Select a state",
            allowClear: true
        });
        var mem = $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $(document).ready(function() {
            bsCustomFileInput.init();



            $("#js-switch").val(hasattachment);

            $("#js-switch").prop('checked', hasattachment);


            var elem = document.querySelector('.js-switch');
            var init = new Switchery(elem);

            if (elem.checked) {
                if (hasattachment) {
                    $("#attachment_preview").show();
                    $("#attachment_file").hide();

                } else {
                    $("#attachment_preview").hide();
                    $("#attachment_file").show();
                }
            } else {
                $("#attachment_file").hide();
                $("#attachment_preview").hide();
            }


            elem.onchange = function() {
                console.log("on change", hasattachment);

                $("#js-switch").val(elem.checked);
                $("#js-switch").prop('checked', elem.checked);

                if (elem.checked && hasattachment) {
                    $("#attachment_file").hide();
                    $("#attachment_preview").show();

                } else if (elem.checked && hasattachment === false) {
                    $("#attachment_file").show();
                    $("#attachment_preview").hide();

                } else {
                    $("#attachment_file").hide();
                    $("#attachment_preview").hide();
                    $("#attachment_file").val('');
                }
            };
        })
    </script>
@endsection

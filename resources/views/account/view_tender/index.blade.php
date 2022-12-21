@extends('layout/main')

@section('content')

    <div class="row m-t">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading text-white">
                    <h4><strong>Общие сведения</strong></h4>
                </div>
                <div class="panel-body">
                    <div class="form-group row "><label class="col-2 col-form-label"><strong>ID &nbsp; :</strong></label>
                        <div class="col-6">
                            <label class="col-form-label">{{ $tenderDetails->id }} &nbsp;</label>
                            <span
                                class=" label label-{{ $tenderDetails->getTenderCorrectStatus()->class_name }}">{{ $tenderDetails->getTenderCorrectStatus()->name }}</span>
                        </div>
                        <div class="col-3 offset-1">
                            <div class="widget lazur-bg mx-2 no-padding">
                                <div class="row p-2">
                                    <div class="col-2">
                                        <i class="fa fa-usd fa-3x"></i>
                                    </div>
                                    <div class="col-10 text-right">
                                        <span>Всего предложений</span>
                                        <h2 class="font-bold">{{ count($tenderDetails->offers()->get()) }}</h2>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group row "><label class="col-2 col-form-label"><strong>Название &nbsp;
                                :</strong></label>
                        <div class="col-6">
                            <label class="col-form-label">{{ $tenderDetails->title }}</label>
                        </div>
                    </div>
                    <div class="form-group row "><label class="col-2 col-form-label"><strong>Описание &nbsp;
                                :</strong></label>
                        <div class="col-6">
                            <label class="col-form-label">{{ $tenderDetails->description }}</label>
                        </div>
                    </div>
                    <div class="form-group row "><label class="col-2 col-form-label"><strong>Категория &nbsp;
                                :</strong></label>
                        <div class="col-6">
                            <label class="col-form-label">{{ $tenderDetails->category->name }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-success">
                <div class="panel-heading text-white">
                    <h4><strong>Ключевые значения</strong></h4>
                </div>
                <div class="panel-body">
                    <div class="form-group row "><label class="col-2 col-form-label"><strong>Начальная цена &nbsp;
                                :</strong></label>
                        <div class="col-6">
                            <label class="col-form-label">{{ sprintf('%0.2f', $tenderDetails->estimate_cost) }} ₽</label>
                        </div>
                    </div>
                    <div class="form-group row "><label class="col-2 col-form-label"><strong>Сумма задатка &nbsp;
                                :</strong></label>
                        <div class="col-6">
                            <label class="col-form-label">{{ sprintf('%0.2f', $tenderDetails->deposit) }} ₽</label>
                        </div>
                    </div>
                    <div class="form-group row "><label class="col-2 col-form-label"><strong>Дата начала&nbsp;
                                :</strong></label>
                        <div class="col-6">
                            <label class="col-form-label">{{ $tenderDetails->getStartDate() }}</label>
                        </div>
                    </div>

                    <div class="form-group row "><label class="col-2 col-form-label"><strong>Дата окончания &nbsp;
                                :</strong></label>
                        <div class="col-6">
                            <label class="col-form-label">{{ $tenderDetails->getEndDate() }}</label>
                        </div>
                    </div>
                    <div class="form-group row "><label class="col-2 col-form-label"><strong>Адрес &nbsp; :</strong></label>
                        <div class="col-6">
                            <label class="col-form-label">{{ $tenderDetails->location }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($tenderDetails->hasPDF())
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading text-white">
                        <h4><strong>Тендерная документация</strong></h4>
                    </div>
                    <div class="panel-body">
                        <div id="attachment_preview" class="widget">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fa fa-file-pdf-o fa-5x"></i>
                                </div>
                                <div class="col-10">
                                    <p class="font-bold"><a target="_blank"
                                            href="{{ $tenderDetails->getPDFFileURL() }}">Нажмите, чтобы просмотреть</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary cus">
                <div class="panel-heading text-white">
                    <h4><strong>Подать заявку</strong></h4>
                </div>
                <div class="panel-body">
                    @if (empty(session(config('global.session_user_obj'))))
                        <p>Пожалуйста <a href="{{ url('/login') }}">войдите</a> или <a
                                href="{{ url('/register') }}">зарегестрируйтесь</a> для того, чтобы подавать заявки !</p>
                    @else
                        @if (session(config('global.session_user_obj'))->um_user_role_id === config('global.user_role_admin'))
                            <p>Администраторы не могу подавать заявки !</p>
                        @elseif($tenderDetails->getOfferUserAlreadySubmited(session(config('global.session_user_obj'))->id) !== null)
                            <p>Вы уже подали заявку на этот тендер<a
                                    href="{{ url('/offer', $tenderDetails->getOfferUserAlreadySubmited(session(config('global.session_user_obj'))->id)->id) }}">
                                    моя заявка</a></p>
                        @else
                            <p>Вы можете подать заявку, заполнив информацию. <a class="linkos"
                                    href="{{ url('/offer/create', $tenderDetails->id) }}"> Нажав сюда</a></p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

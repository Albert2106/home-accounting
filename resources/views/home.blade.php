@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/datatables_basic.js') }}"></script>

    <script src="{{ asset('global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>

    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/donuts.js') }}"></script>

@endpush
@section('content')

{{--    Добавить доход--}}
    <div class="modal fade" id="incomeAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('accounting.add') }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить доход</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="type" value="1" >
                        <label for="category_select" class="col-form-label">Категория:</label>
                        <select class="custom-select" name="category_id" id="category_select">
                            <option selected>Не выбрано</option>
                            @foreach($categoryIncomes as $categoryIncome)
                            <option value="{{ $categoryIncome->getId() }}">{{ $categoryIncome->getName() }}</option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Сума:</label>
                            <input type="number" name="amount" class="form-control" id="message-text">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Коментарий:</label>
                            <textarea class="form-control" name="comment" id="message-text"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
                </form>
            </div>
        </div>
    </div>

{{--    Добавить расход--}}

<div class="modal fade" id="expensesAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('accounting.add') }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить расход</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="2" >
                    <label for="category_select" class="col-form-label">Категория:</label>
                    <select class="custom-select" name="category_id" id="category_select">
                        <option selected>Не выбрано</option>
                        @foreach($categoryExpenses as $categoryExpense)
                            <option value="{{ $categoryExpense->getId() }}">{{ $categoryExpense->getName() }}</option>
                        @endforeach
                    </select>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Сума:</label>
                        <input type="number" name="amount" class="form-control" id="message-text">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Коментарий:</label>
                        <textarea class="form-control" name="comment" id="message-text"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Content area -->
    <div class="content">
        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Главная</span>
                    </h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <div class="d-flex justify-content-center">
                        <a href="#" data-toggle="modal" data-target="#incomeAddModal" class="btn btn-link btn-float text-default"><i
                                class="icon-bars-alt text-primary"></i>
                            <span>Добавить доход</span></a>
                        <a href="#" data-toggle="modal" data-target="#expensesAddModal" class="btn btn-link btn-float text-default"><i
                                class="icon-bars-alt text-primary"></i>
                            <span>Добавить расход</span></a>
                        <a href="#" class="btn btn-link btn-float text-default"><i
                                class="icon-calendar5 text-primary"></i>
                            <span>Скачать Exel</span></a>
                    </div>

                </div>
            </div>
        </div>
        <!-- /page header -->
        <!-- Marketing campaigns -->
        <div class="card">

            <div class="card-body d-sm-flex align-items-sm-center justify-content-sm-between flex-sm-wrap">
                <div class="d-flex align-items-center mb-3 mb-sm-0">
                    <div id="campaigns-donut"></div>
                    <div class="ml-3">
                        <h5 class="font-weight-semibold mb-0">{{ number_format($incomeCount,2,'.',' ') }}</h5>
                        <span class="badge badge-mark border-success mr-1"></span> <span
                            class="text-muted">Доходы</span>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3 mb-sm-0">
                    <div id="campaign-status-pie"></div>
                    <div class="ml-3">
                        <h5 class="font-weight-semibold mb-0">{{ number_format($expensesCount,2,'.',' ') }} </h5>
                        <span class="badge badge-mark border-danger mr-1"></span> <span
                            class="text-muted">Расходы</span>
                    </div>
                </div>
            <div></div>
            </div>

        </div>
        <!-- /marketing campaigns -->
        <!-- Basic datatable -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Домашняя бухгалтерия</h5>
            </div>

            <table class="table datatable-basic">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Тип</th>
                    <th>Категория</th>
                    <th>Сумма</th>
                    <th class="text-center">Коментарий</th>
                    <th>Дата</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accountings as $id => $accounting)
                    <tr>
                        <td style="width: 15px;">{{ ++$id }}</td>
                        <td style="width: 150px">
                            @if($accounting->getType() == 1)
                                <span class="badge badge-success">Доход</span>
                            @else
                                <span class="badge badge-danger">Расход</span>
                            @endif
                        </td>
                        <td style="width: 300px;">{{ $accounting->relationCategory->name }}</td>
                        <td style="width: 80px">{{ number_format($accounting->getAmount(),2,'.',' ') }}</td>
                        <td class="text-center" style="width: 400px">{{ $accounting->getComment() }}</td>
                        <td>{{ $accounting->getCreatedAt() }}</td>
                        <td style="width: 50px"><a href="{{ route('accounting.delete',$accounting->id) }}">Удалить</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /basic datatable -->

    </div>
    <!-- /content area -->

@endsection

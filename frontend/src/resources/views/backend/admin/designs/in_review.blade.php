@extends('backend.layouts.app')

@section('scripts_head')
    <link href="/backend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/backend/plugins/datatables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet"
          type="text/css">
    <style>
        .form-inline {
            display: inline-block;
        }
    </style>
@stop

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('designs.in_review.title') }}
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i> {{ trans('designs.in_review.title') }}</li>
        </ol>
    </section>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <table id="tags-table" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('designs.name') }}</th>
                                <th>{{ trans('designs.description') }}</th>
                                <th>{{ trans('designs.created_at') }}</th>
                                <th>{{ trans('designs.designer') }}</th>
                                <td>{{ trans('designs.commission') }}</td>
                                <th style="width: 120px">Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($designs as $design)
                                <tr class="first odd">
                                    <td>{{ $design->getName() }}</td>
                                    <td>{{ $design->getDescription() }}</td>
                                    <td>{{ $design->getCreatedAt()->format('d-m-Y') }}</td>
                                    <td>{{ $design->getDesigner()->getNickName() }}</td>
                                    <td>{{ $design->getCommission() }} %</td>
                                    <td style="white-space:nowrap;">
                                        <a class="btn btn-info btn-xs"
                                           href="{{route('admin.designs.show', $design->getId())}}">
                                            <span class="fa fa-info-circle"></span>
                                        </a>

                                            {{ Form::open([
                                                    'route' => ['admin.designs.approve', $design->getId()],
                                                    'method' => 'post',
                                                    'class' => 'form-inline'
                                                ])
                                            }}

                                            @include('backend.includes.confirm', [
                                                    'id' => 'design-approve-' . $design->getId(),
                                                    'model_id' => $design->getId(),
                                                    'labelled_by' => 'design-approve-' . $design->getId(),
                                                    'title' => trans('designs.approve_design_dialog_title'),
                                                    'question' => trans('designs.decline_design_dialog_title'),
                                                    'route' => 'admin.designs.approve'
                                            ])

                                            {{Form::close()}}

                                            <a class="btn btn-success btn-xs" data-toggle="modal"
                                               data-target="#approve-design-{{$design->getId()}}">
                                                <span class="fa fa-check"></span>
                                            </a>

                                            <a class="btn btn-danger btn-xs" href="{{ route('admin.designs.rejectForm', $design->getId()) }}">
                                                <span class="fa fa-close"></span>
                                            </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">{{ trans('designs.empty') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $designs->links() }}
                    </div>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section><!-- /.content -->
@endsection

@section('scripts_body')
    <script src="/backend/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="/backend/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
    <script src="/backend/plugins/datatables/extensions/Responsive/js/responsive.bootstrap.min.js"></script>
@endsection

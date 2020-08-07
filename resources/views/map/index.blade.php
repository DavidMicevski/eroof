@extends('map.base')
@section('action-content')
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-8">
                    <a class="btn btn-primary" href="{{ route('map.create') }}" style="margin-left: 30px; margin-top: 30px;">Create Measurement</a>
                </div>
                <div class="col-sm-4" style="margin-top: 30px; padding-right: 40px;">
                    <div class="position-relative d-inline-block float-right">
                    <input placeholder="Search Measurements" type="text" class="search-filters form-control" value="">
                    <i class="fa fa-search icon" style="color: rgb(204, 204, 204); font-size: 24px;"></i>
                </div>
                <label for="check-Trashed" class="form-check-label float-right">
                    <i class="fa fa-trash-o"></i>Trashed
                </label>
                <input type="checkbox" name="" class="float-right" style="margin-right: 5px; margin-top: 7px;">
            </div>
        </div>
    </div>
    <div class="box-body">
        <div id="measurements" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-12">
                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                        <thead>
                            <tr role="row" >
                                <th width="10%" class="table-header">Edit</th>
                                <th width="10%" class="table-header">Image type</th>
                                <th width="10%" class="table-header">Author</th>
                                <th width="20%" class="sorting hidden-xs table-header">Address</th>
                                <th width="10%" class="table-header">Customer</th>
                                <th width="10%" class="table-header">Download Report...</th>
                                <th width="10%" class="sorting hidden-xs table-header">Created</th>
                                <th width="10%" class="table-header" style="border-right: 2px solid #f4f4f4">Last Updated...</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            @foreach ($maps as $map)
                            <tr role="row" class="odd">
                                <td tabindex="9" class="" style="text-align: center;">
                                    <button type="button" class="btn-icon btn btn btn-link" style="color: #9c9c9d" onclick="edit()">
                                        <i class="fa fa-edit" style="font-size: 18px;"></i>
                                        <div class="full-text flex align-center">
                                        </div>
                                    </button>
                                </td>
                                <td class="table-cell">{{ $map->maptype }}</td>
                                <td class="table-cell">Me</td>
                                <td tabindex="9" class="" style="text-align: center;">
                                    <button type="button" class="btn-icon btn btn btn-link" style="color: #9c9c9d" onclick="edit()">
                                        <div class="full-text flex align-center">
                                            {{ $map->address }}
                                        </div>
                                    </button>
                                </td>
                                <td class="table-cell">Me</td>
                                <td tabindex="9" class="" style="text-align: center;">
                                    <button type="button" class="btn-icon btn btn btn-link" style="color: #9c9c9d" onclick="download()">
                                        <i class="fa fa-file-pdf-o" style="font-size: 18px;"></i>
                                        <div class="full-text flex align-center">
                                        </div>
                                    </button>
                                </td>
                                <td class="table-cell">{{ $map->created_at }}</td>
                                <td class="table-cell">{{ $map->updated_at }}</td>
                                <td tabindex="9" class="" style="text-align: center;">
                                    <button type="button" class="btn-icon btn btn btn-link" style="color: #9c9c9d" onclick="remove('{{ $map->id }}')">
                                        <i class="fa fa-trash-o" style="font-size: 18px;"></i>
                                        <div class="full-text flex align-center">
                                        </div>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        <div class="row">
            <div class="col-sm-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/loading-spinner.js') }}"></script>
    <script type="text/javascript">
        function edit(id) {
            console.log(id);
        }

        function remove(id) {
            showLoading();
            var token = '{{csrf_field()}}'.split('value="');
            token = token[1].split('">');

            $.ajax({
                url: '/map/remove',
                type: 'post',
                data: {   
                    _token: token[0],
                    mapId: id
                },
                success: function(res) {
                    hideLoading();
                    location.reload();
                }
            });
        }

        function download(id) {
            console.log(id);
        }

        function showLoading() {
            Spinner();
            Spinner.show();
        }

        function hideLoading() {
            Spinner.hide();
        }
    </script>
</section>
@endsection
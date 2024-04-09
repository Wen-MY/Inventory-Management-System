<x-header />

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-check"></i> Import Brand
            </div>
            <!-- /panel-heading -->
            <div class="panel-body">

                <form class="form-horizontal" id="submitImportForm" action="{{ route('brand.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="add-product-messages"></div>
                    <div class="form-group">
                        <label for="brandfile" class="col-sm-3 control-label">Import Brand FIle: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <!-- the avatar markup -->
                            <div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>
                            <div class="kv-avatar center-block">
                                <input type="file" class="form-control" id="brandfile" placeholder="Import Brand FIle" name="brandfile" class="file-loading" style="width:auto;"/>
                            </div>
                            <a href="{{ asset('assets/import/brand.xlsx') }}" download>Sample file</a>
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" id="importBrandBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Import</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /panel-body -->
        </div>
    </div>
    <!-- /col-dm-12 -->
</div>
<!-- /row -->

<script src="{{ asset('custom/js/import.js') }}"></script>

<x-footer />

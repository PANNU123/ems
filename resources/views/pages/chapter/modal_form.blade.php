<div class="modal fade ajaxModelChapter" id="ajaxModelChapter" data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="modelHeading">Large Modal</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="closeBtn" aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
{{--                                    <h3 class="card-title">Quick Example</h3>--}}
                                </div>
                                <form id="chapterForm">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="subject_id" id="subject_id" value="{{$subject_id}}" class="form-control" placeholder="Enter name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Chapter Name</label>
                                            <input type="text" name="chapter_name" id="chapter_name" class="form-control" id="exampleInputEmail1" placeholder="Chapter name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default closeBtn" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-custom saveBtn" id="saveBtn">Save changes</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

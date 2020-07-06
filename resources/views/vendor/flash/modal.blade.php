<div id="delete-modal" class="modal fade text-danger" role="dialog">
    <div class="modal-dialog">
        <form action="" id="delete-form" method="post">
            <div class="modal-content">
                <div class="modal-header bg-danger" style="text-align: center">
                    <h4 class="modal-title text-center" id="check" style="color: white">DELETE CONFIRMATION</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <p class="text-center">Bạn có chắc chắn muốn xoá bản ghi này không?</p>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">OK</button>
                     <center>
                </div>
            </div>
        </form>
    </div>
</div>

@section('inline_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete-button').on('click', function() {
                var recordId = $(this).attr('record-id');
                var namePage = $(this).attr('name-page');
                var url = namePage + '/' + recordId;
                $('#delete-form').attr('action', url);
            });
        });
    </script>
@endsection

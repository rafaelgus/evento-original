<div class="modal" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $labelled_by }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">close</span>
                </button>
                <h4 class="modal-title">{{$title}}</h4>
            </div>
            <div class="modal-body">
                <p>{{ $question }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="submit" href="{{ route($route, $model_id) }}" class="btn btn-danger">Si</button>
            </div>
        </div>
    </div>
</div>
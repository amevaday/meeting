@can($view)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $name . '.show', $row->id) }}">
        View
    </a>
@endcan
@can($edit)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $name . '.edit', $row->id) }}">
        Edit
    </a>
@endcan
@can($delete)
    <form action="{{ route('admin.' . $name . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="delete">
    </form>
@endcan
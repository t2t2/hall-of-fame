<div class="page-header">
	<h2>Videos</h2>
</div>
<table id="userlist" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>URL</th>
			<th>YT?</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@foreach($videos->results as $video)
			<tr>
				<td>#{{ $video->id }}</td>
				<td>
					{{ e($video->title) }}
				</td>
				<td>
					{{ HTML::link($video->url, $video->url) }}
				</td>
				<td>
					{{ $video->youtube_id ? '<i class="icon-ok"></i>' : '<i class="icon-remove"></i>' }}
				<td>
					<a href="{{ action("admin.video@edit", array($video->id)) }}" title="Edit..."><i class="icon-pencil"></i></a>
					<a href="{{ action("admin.video@delete", array($video->id)) }}" title="Delete..."><i class="icon-trash"></i></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
{{ $videos->links() }}
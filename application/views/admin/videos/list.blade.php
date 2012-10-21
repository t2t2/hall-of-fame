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
			<th><i class="icon-white icon-thumbs-up"></i></th>
			<th style="width: 68px;">Actions</th>
		</tr>
	</thead>
	<tbody>
		@foreach($videos->results as $video)
			<tr>
				<td>#{{ $video->id }}</td>
				<td>{{ HTML::link_to_action("admin.video@view", $video->title ?: "[unknown}", array($video->id)) }}</td>
				<td>{{ HTML::link($video->url, $video->url) }}</td>
				<td>
					{{ $video->youtube_id ? '<i class="icon-white icon-ok"></i>' : '<i class="icon-white icon-remove"></i>' }}
				</td>
				<td>{{ $video->nominations }}</td>
				<td>
					<a href="{{ action("admin.video@view", array($video->id)) }}" title="View..."><i class="icon-white icon-list-alt"></i></a>
					<a href="{{ action("admin.video@edit", array($video->id)) }}" title="Edit..."><i class="icon-white icon-pencil"></i></a>
					<a href="{{ action("admin.video@merge", array($video->id)) }}" title="Merge..."><i class="icon-white icon-filter"></i></a>
					<a href="{{ action("admin.video@delete", array($video->id)) }}" title="Delete..."><i class="icon-white icon-trash"></i></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
{{ $videos->links() }}
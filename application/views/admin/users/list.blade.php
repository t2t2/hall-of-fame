<div class="page-header">
	<h2>Users <div class="pull-right"><a href="{{ action("admin.user@new") }}" class="btn"><i class="icon-plus"></i> New</a></div></h2>
</div>
<table id="userlist" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Person</th>
			<th>Votes</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users->results as $user)
			<tr>
				<td>#{{ $user->id }}</td>
				<td>
					@{{ HTML::link_to_action("admin.user@view", $user->username, array($user->id)) }}
					@if($user->admin)
						<span class="label">Admin</span>
					@endif
				</td>
				<td>
					@if($user->can_nominate)
					{{ $user->nominations }}/{{ Config::get("application.nominations") }}
					@else
					<i class="icon-white icon-remove"></i>
					@endif
				</td>
				<td>
					<a href="{{ action("admin.user@view", array($user->id)) }}" title="View..."><i class="icon-white icon-list-alt"></i></a>
					<a href="{{ action("admin.user@edit", array($user->id)) }}" title="Edit..."><i class="icon-white icon-pencil"></i></a>
					<a href="{{ action("admin.user@delete", array($user->id)) }}" title="Delete..."><i class="icon-white icon-trash"></i></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
{{ $users->links() }}
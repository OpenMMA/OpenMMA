<div>
    <table class="table table-striped" id="user_table">
        <thead>
            <tr>
                <th scope="col" width="">Role name</th>
                <th scope="col" width="1%"></th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($roles as $role)
            <tr>
                <td>{{ $role->title }}</td>
                <td class="hide"><a class="btn btn-primary px-1 py-0" href="/dashboard/group/{{ $group->name }}/role/{{ explode('.', $role->name, 2)[1] }}">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

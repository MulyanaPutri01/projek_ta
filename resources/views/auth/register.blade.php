
<div class="container">
    <h1>Register</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="role_id_role">Role</label>
            <select name="role_id_role" id="role_id_role" class="form-control" required>
                <option value="1">Admin</option>
                <option value="2">Bendahara</option>
                <option value="3">Sekretaris</option>
            </select>
        </div>

        <div class="form-group">
            <label for="nama_takmir">Nama Takmir</label>
            <input type="text" name="nama_takmir" id="nama_takmir" class="form-control" value="{{ old('nama_takmir') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

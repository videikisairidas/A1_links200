<form method="POST" action="{{ route('2fa.verify') }}">
    @csrf
    <label>Enter 6‑digit code</label>
    <input type="text" name="code" required>
    <button type="submit">Verify</button>
</form>

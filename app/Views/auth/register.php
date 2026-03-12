<h2>Register</h2>

<form method="POST" action="<?= base_path() ?>/register">

<input type="email" name="email" required placeholder="Email">

<input type="password" name="password" required placeholder="Password">

<button type="submit">
Register
</button>

</form>
<form method="POST" action="/cart/remove">

<input type="hidden" name="id" value="<?= $item['id'] ?>">

<button type="submit">
Remove
</button>

</form>
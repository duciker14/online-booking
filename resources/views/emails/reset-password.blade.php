<div style="text-align: center;">
    <h1>Forget Password Email</h1>

    <p>You can reset password from bellow link:</p>
    <a href="{{ route('reset.password', ['email' => $email, 'token' => $token]) }}" style="display: inline-block;
        border-radius: 5px;
        background: #319194;
        width: 150px;
        color: #fff;
        text-align: center;
        padding: 10px 5px;
        margin-top: 10px;
        text-decoration: none;">
        Reset Password
    </a>
</div>

<h1>Password reset</h1>
<h5>Go to the link below</h5>
<a href="{{'http://'.parse_url($_SERVER['APP_URL'])['host'].'/password/reset/'.$token.'/'.$email}}" class="btn btn-primary">Reset Password</a>

<div>
    <p>If you can't click the link above, just copy this link and go to it</p>
    <p style="color: #2162ff">{{'http://'.parse_url($_SERVER['APP_URL'])['host'].'/password/reset/'.$token.'/'.$email}}</p>
</div>

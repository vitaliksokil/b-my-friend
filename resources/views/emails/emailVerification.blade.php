<h1>Verify your email</h1>
<h5>Go to the link below</h5>
{{dd()}}
{{dd($_SERVER['APP_URL'].'/email/verify/'.$token.'/'.$user_id)}}
<a href="{{'http://'.parse_url($_SERVER['APP_URL'])['host'].'/email/verify/'.$token.'/'.$user_id}}" class="btn btn-primary">VERIFY EMAIL</a>

Перейдите по ссылке для сброса пароля: {{ url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}
